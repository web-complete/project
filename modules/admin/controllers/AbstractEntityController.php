<?php

namespace modules\admin\controllers;

use modules\admin\classes\EntityConfig;
use modules\admin\classes\filter\Filter;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\core\condition\Condition;
use WebComplete\core\entity\AbstractEntityService;
use WebComplete\core\utils\paginator\Paginator;

class AbstractEntityController extends AbstractController
{

    protected $itemsPerPage = 25;
    protected $entityConfigClass;
    protected $messageFormError = 'Ошибка валидации формы';

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionList(): Response
    {
        $page = $this->request->get('page', 1);
        $sortField = $this->request->get('sortField', 'id');
        $sortDir = $this->request->get('sortDir', 'desc');
        $filter = (array)$this->request->get('filter', []);

        $entityConfig = $this->getEntityConfig();
        $entityService = $this->getEntityService();

        /** @var Condition $condition */
        $condition = $this->container->make(Condition::class);
        Filter::parse($entityConfig->filterFields(), $filter, $condition);
        $condition->addSort($sortField, $sortDir === 'desc' ? \SORT_DESC : \SORT_ASC);

        /** @var Paginator $paginator */
        $paginator = $this->container->make(Paginator::class);
        $paginator->setItemsPerPage($this->itemsPerPage);
        $paginator->setCurrentPage($page);
        $items = $this->fetchListItems($entityService, $paginator, $condition);

        $listFields = [];
        foreach ($entityConfig->listFields() as $field) {
            $listFields[] = $field->get();
        }

        return $this->responseJsonSuccess([
            'title' => $entityConfig->titleList,
            'page' => $paginator->getCurrentPage(),
            'itemsPerPage' => $paginator->getItemsPerPage(),
            'itemsTotal' => $paginator->getTotal(),
            'listFields' => $listFields,
            'filterFields' => $this->getFilterFields($entityConfig),
            'items' => $items
        ]);
    }

    /**
     * @param $id
     *
     * @return Response
     * @throws \Exception
     */
    public function actionDetail($id): Response
    {
        $id = (int)$id;
        $entityConfig = $this->getEntityConfig();
        $entityService = $this->getEntityService();
        if (!$id || !($item = $entityService->findById($id))) {
            $item = $entityService->create();
        }

        $detailFields = [];
        foreach ($entityConfig->detailFields() as $field) {
            $field->value($item->get($field->getName()));
            $field->processField();
            $detailFields[] = $field->get();
        }

        return $this->responseJsonSuccess([
            'title' => $entityConfig->titleDetail,
            'detailFields' => $detailFields,
        ]);
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionSave(): Response
    {
        $id = (int)$this->request->get('id');
        $data = $this->request->request->all();
        $entityConfig = $this->getEntityConfig();
        $entityService = $this->getEntityService();
        if (!$id || !($item = $entityService->findById($id))) {
            $item = $entityService->create();
        }

        $form = $entityConfig->form();
        $form->setData($data);
        if ($form->validate()) {
            $item->mapFromArray($form->getData(), true);
            $entityService->save($item);
            return $this->responseJsonSuccess();
        }

        $errors = $form->getFirstErrors();
        return $this->responseJsonFail($this->messageFormError, ['errors' => $errors]);
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionDelete(): Response
    {
        return $this->responseJsonSuccess([]);
    }

    /**
     * @param EntityConfig $entityConfig
     *
     * @return array
     */
    protected function getFilterFields(EntityConfig $entityConfig): array
    {
        $filterFields = [];
        foreach ($entityConfig->filterFields() as $filterField) {
            $filterFields[] = $filterField->get();
        }

        return $filterFields;
    }

    /**
     * @param $entityService
     * @param $paginator
     * @param $condition
     *
     * @return array
     */
    protected function fetchListItems(
        AbstractEntityService $entityService,
        Paginator $paginator,
        Condition $condition
    ): array {
        $rawItems = [];
        foreach ($entityService->list($paginator, $condition) as $item) {
            $rawItem = $item->mapToArray();
            $rawItem['roles'] = \implode(', ', $rawItem['roles']);
            $rawItems[] = $rawItem;
        }

        return $rawItems;
    }

    /**
     * @return EntityConfig
     */
    private function getEntityConfig(): EntityConfig
    {
        return $this->container->get($this->entityConfigClass);
    }

    /**
     * @return AbstractEntityService
     */
    private function getEntityService(): AbstractEntityService
    {
        return $this->container->get($this->getEntityConfig()->entityServiceClass);
    }
}
