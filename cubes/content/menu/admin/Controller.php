<?php

namespace cubes\content\menu\admin;

use cubes\content\menu\MenuItem;
use cubes\content\menu\MenuItemConfig;
use cubes\content\menu\MenuService;
use modules\admin\controllers\AbstractEntityController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = MenuItemConfig::class;

    /**
     * @return Response
     * @throws \Exception
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function actionTree(): Response
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
        $menuService = $this->container->get(MenuService::class);
        $menuService->move((int)$parentId, $childrenIds);
        return $this->responseJsonSuccess();
    }
}
