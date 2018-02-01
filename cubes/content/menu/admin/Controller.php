<?php

namespace cubes\content\menu\admin;

use cubes\content\menu\MenuItem;
use cubes\content\menu\MenuItemConfig;
use cubes\content\menu\MenuService;
use modules\admin\controllers\AbstractEntityController;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = MenuItemConfig::class;

    public function actionTree()
    {
        $menuService = $this->container->get(MenuService::class);
        $menuTree = $menuService->getTree();
        $dataTree = [];
        foreach ($menuTree->getAllItems() as $item) {
            /** @var MenuItem $item */
            $dataTree[] = ['id' => $item->getId(), 'parent' => (int)$item->parent_id, 'text' => $item->title];
        }

        return $this->responseJsonSuccess([
            'tree' => $dataTree,
        ]);
    }

    public function actionMove()
    {
        $parentId = (int)$this->request->get('parent_id');
        $childrenIds = (array)$this->request->get('children_ids');
        if (!$parentId || !$childrenIds) {
            return $this->responseJsonFail('Ошибка параметров');
        }
        $menuService = $this->container->get(MenuService::class);
        $menuService->move($parentId, $childrenIds);
        return $this->responseJsonSuccess();
    }
}
