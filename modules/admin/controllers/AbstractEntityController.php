<?php

namespace modules\admin\controllers;

use cubes\system\multilang\lang\classes\AbstractMultilangEntity;
use modules\admin\classes\EntityConfig;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\fields\FieldService;
use modules\admin\classes\filter\FilterFactory;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\core\condition\Condition;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;
use WebComplete\core\utils\helpers\ArrayHelper;
use WebComplete\core\utils\paginator\Paginator;
use WebComplete\form\AbstractForm;

class AbstractEntityController extends AbstractController
{

    protected $entityConfigClass;
    protected $messageFormError = 'Ошибка валидации формы';
    protected $itemsPerPage = 25;
    protected $defaultSortField = 'id';
    protected $defaultSortDir = 'desc';

    /**
     * @return bool|string|Response
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     * @throws \WebComplete\mvc\router\exception\NotAllowedException
     */
    public function beforeAction()
    {
        $result = parent::beforeAction();
        $this->checkPermission($this->getPermissions()['view']);
        return $result;
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionList(): Response
    {
        $page = $this->request->get('page', 1);
        $filter = (array)$this->request->get('filter', []);

        $entityConfig = $this->getEntityConfig();
        $entityService = $this->getEntityService();

        /** @var Condition $condition */
        $condition = $entityService->createCondition();
        FilterFactory::build()->parse($entityConfig->getFilterFields(), $filter, $condition);
        $this->prepareListCondition($condition);

        /** @var Paginator $paginator */
        $paginator = $this->container->make(Paginator::class);
        $paginator->setItemsPerPage($this->itemsPerPage);
        $paginator->setCurrentPage($page);
        $items = $this->fetchRawListItems($entityService, $paginator, $condition);

        $listFields = [];
        foreach ($entityConfig->getListFields() as $field) {
            $listFields[] = $field->get();
        }

        return $this->responseJsonSuccess([
            'title' => $entityConfig->titleList,
            'page' => $paginator->getCurrentPage(),
            'itemsPerPage' => $paginator->getItemsPerPage(),
            'itemsTotal' => $paginator->getTotal(),
            'listFields' => $listFields,
            'filterFields' => $this->getFilterFields($entityConfig),
            'permissions' => $this->getPermissions(),
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

        $detailFields = $this->detailFieldsProcess($entityConfig->getDetailFields(), $item);

        return $this->responseJsonSuccess([
            'title' => $entityConfig->titleDetail,
            'detailFields' => $detailFields,
            'isMultilang' => $item instanceof AbstractMultilangEntity,
            'permissions' => $this->getPermissions(),
        ]);
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionSave(): Response
    {
        $this->checkPermission($this->getPermissions()['edit']);
        $id = (int)$this->request->get('id');
        $data = (array)$this->request->request->all();
        $entityConfig = $this->getEntityConfig();
        $entityService = $this->getEntityService();
        if (!$id || !($item = $entityService->findById($id))) {
            $item = $entityService->create();
        }

        $itemOldData = $item->mapToArray();
        $form = $entityConfig->getForm();
        $form->setData($this->processNestedData($data['data'] ?? []));
        if ($form->validate() && $this->beforeSave($item, $form)) {
            $entityService->save($item, $itemOldData);
            $this->afterSave($item, $form);
            return $this->responseJsonSuccess([
                'id' => $item->getId(),
                'data' => $item->mapToArray(),
            ]);
        }

        return $this->responseJsonFail($this->messageFormError, [
            'errors' => $form->getFirstErrors(),
            'multilangErrors' => $form->getMultilangErrors(),
        ]);
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionDelete(): Response
    {
        $this->checkPermission($this->getPermissions()['edit']);
        if ($id = (int)$this->request->get('id')) {
            $entityService = $this->getEntityService();
            if ($this->beforeDelete($id)) {
                $entityService->delete($id);
                $this->afterDelete($id);
            }
        }
        return $this->responseJsonSuccess();
    }

    /**
     * @param EntityConfig $entityConfig
     *
     * @return array
     */
    protected function getFilterFields(EntityConfig $entityConfig): array
    {
        $filterFields = [];
        foreach ($entityConfig->getFilterFields() as $filterField) {
            $filterFields[] = $filterField->get();
        }

        return $filterFields;
    }

    /**
     * @param Condition $condition
     */
    protected function prepareListCondition(Condition $condition)
    {
        $sortField = $this->request->get('sortField', $this->defaultSortField) ?: $this->defaultSortField;
        $sortDir = $this->request->get('sortDir', $this->defaultSortDir) ?: $this->defaultSortDir;
        $condition->addSort($sortField, $sortDir === 'desc' ? \SORT_DESC : \SORT_ASC);
    }

    /**
     * @param $entityService
     * @param $paginator
     * @param $condition
     *
     * @return array
     */
    protected function fetchRawListItems(
        AbstractEntityService $entityService,
        Paginator $paginator,
        Condition $condition
    ): array {
        $rawItems = [];
        foreach ($entityService->list($paginator, $condition) as $item) {
            $rawItem = $item->mapToArray();
            $rawItems[] = $rawItem;
        }

        return $rawItems;
    }

    /**
     * @param FieldAbstract[] $detailFields
     * @param AbstractEntity $item
     *
     * @return array
     */
    protected function detailFieldsProcess(array $detailFields, AbstractEntity $item): array
    {
        $fieldService = $this->container->get(FieldService::class);
        return $fieldService->populateEntityFields($detailFields, $item);
    }

    /**
     * @return array
     */
    protected function getPermissions(): array
    {
        $result = [
            'view' => '',
            'edit' => ''
        ];
        $entityConfig = $this->getEntityConfig();
        if ($entityConfig->rbac) {
            $result['view'] = 'admin:cubes:' . $entityConfig->getSystemName() . ':view';
            $result['edit'] = 'admin:cubes:' . $entityConfig->getSystemName() . ':edit';
        }
        return $result;
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    protected function beforeDelete($id): bool
    {
        return (bool)$id;
    }

    /**
     * @param int $id
     */
    protected function afterDelete($id)
    {
    }

    /**
     * @param AbstractEntity $item
     * @param AbstractForm $form
     *
     * @return bool
     */
    protected function beforeSave(AbstractEntity $item, AbstractForm $form): bool
    {
        if ($item->getId()) {
            if ($item->has('updated_on')) {
                $item->set('updated_on', \date('Y-m-d H:i:s'));
            }
        } else {
            if ($item->has('created_on')) {
                $item->set('created_on', \date('Y-m-d H:i:s'));
            }
        }
        $item->mapFromArray($form->getData(), true);
        return true;
    }

    /**
     * @param AbstractEntity $item
     * @param AbstractForm $form
     */
    protected function afterSave(AbstractEntity $item, AbstractForm $form)
    {
    }

    /**
     * @return EntityConfig
     */
    protected function getEntityConfig(): EntityConfig
    {
        return $this->container->get($this->entityConfigClass);
    }

    /**
     * @return AbstractEntityService
     */
    protected function getEntityService(): AbstractEntityService
    {
        return $this->container->get($this->getEntityConfig()->entityServiceClass);
    }

    /**
     * Process nested field values by "dot delimiter" and convert it to array.
     * Example: "preferences.user.property1" will be converted to: ['preferences']['user']['property1']
     * @param array $data
     *
     * @return array
     */
    protected function processNestedData(array $data): array
    {
        foreach ($data as $field => $value) {
            if (\strrpos($field, '.') !== false) {
                ArrayHelper::setValue($data, $field, $value);
                unset($data[$field]);
            }
        }
        return $data;
    }
}
