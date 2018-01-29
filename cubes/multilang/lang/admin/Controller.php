<?php

namespace cubes\multilang\lang\admin;

use cubes\multilang\lang\LangConfig;
use cubes\multilang\lang\LangService;
use modules\admin\controllers\AbstractEntityController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = LangConfig::class;
    protected $defaultSortField = 'sort';
    protected $defaultSortDir = 'asc';

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionSave(): Response
    {
        $id = (int)$this->request->get('id');
        $data = (array)$this->request->request->all();
        $entityConfig = $this->getEntityConfig();
        /** @var LangService $entityService */
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
                'state' => $entityService->getState(),
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
        /** @var LangService $entityService */
        $entityService = $this->getEntityService();

        if ($id = (int)$this->request->get('id')) {
            $entityService = $this->getEntityService();
            if ($this->beforeDelete($id)) {
                $entityService->delete($id);
                $this->afterDelete($id);
            }
        }
        return $this->responseJsonSuccess([
            'state' => $entityService->getState(),
        ]);
    }
}
