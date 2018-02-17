<?php

namespace cubes\ecommerce\classifier\admin;

use cubes\ecommerce\classifier\ClassifierItem;
use cubes\ecommerce\classifier\ClassifierItemConfig;
use cubes\ecommerce\classifier\ClassifierService;
use modules\admin\controllers\AbstractEntityController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = ClassifierItemConfig::class;

    /**
     * @return Response
     * @throws \Exception
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function actionTree(): Response
    {
        $classifierService = $this->container->get(ClassifierService::class);
        $classifierTree = $classifierService->getTree();
        $dataTree = [];
        foreach ($classifierTree->getAllItems() as $item) {
            /** @var ClassifierItem $item */
            $dataTree[] = ['id' => $item->getId(), 'parent' => (int)$item->parent_id, 'text' => $item->title];
        }

        return $this->responseJsonSuccess([
            'tree' => $dataTree,
        ]);
    }

    /**
     * @return Response
     * @throws \Exception
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \WebComplete\mvc\router\exception\NotAllowedException
     */
    public function actionMove(): Response
    {
        $this->checkPermission($this->getPermissions()['edit']);
        $parentId = $this->request->get('parent_id');
        $childrenIds = (array)$this->request->get('children_ids');
        if ($parentId === null || !$childrenIds) {
            return $this->responseJsonFail('Ошибка параметров');
        }
        $classifierService = $this->container->get(ClassifierService::class);
        $classifierService->move((int)$parentId, $childrenIds);
        return $this->responseJsonSuccess();
    }
}
