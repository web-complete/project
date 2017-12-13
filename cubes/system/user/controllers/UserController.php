<?php

namespace cubes\system\user\controllers;

use cubes\system\user\UserConfig;
use cubes\system\user\UserService;
use modules\admin\controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\core\condition\Condition;
use WebComplete\core\entity\AbstractEntityService;
use WebComplete\core\utils\paginator\Paginator;

class UserController extends AbstractController
{

    protected $titleList = 'Пользователи';
    protected $itemsPerPage = 10;
    protected $entityServiceClass = UserService::class;

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionList(): Response
    {
        /** @var AbstractEntityService $entityService */
        $entityService = $this->container->get($this->entityServiceClass);
        $entityConfig = $this->container->get(UserConfig::class);
//        for ($i=1; $i<30; $i++) {
//            $item = $entityService->create();
//            $item->mapFromArray([
//                'login' => 'login' . $i,
//                'email' => 'login' . $i . '@example.com',
//                'first_name' => 'First' . $i,
//                'last_name' => 'Last' . $i,
//                'sex' => ($i % 2) ? 'M' : 'F',
//                'is_active' => (bool)($i % 2),
//            ]);
//            $entityService->save($item);
//        }
        $page = $this->request->get('page', 1);
        $sortField = $this->request->get('sortField', 'id');
        $sortDir = $this->request->get('sortDir', 'desc');

        /** @var Condition $condition */
        $condition = $this->container->make(Condition::class);
        $condition->addSort($sortField, $sortDir === 'desc' ? \SORT_DESC : \SORT_ASC);
        /** @var Paginator $paginator */
        $paginator = $this->container->make(Paginator::class);
        $paginator->setItemsPerPage($this->itemsPerPage);
        $paginator->setCurrentPage($page);
        $rawItems = [];
        foreach ($entityService->list($paginator, $condition) as $item) {
            $rawItem = $item->mapToArray();
            $rawItem['roles'] = \implode(', ', $rawItem['roles']);
            $rawItems[] = $rawItem;
        }

        return $this->responseJsonSuccess([
            'title' => $this->titleList,
            'page' => $paginator->getCurrentPage(),
            'itemsPerPage' => $paginator->getItemsPerPage(),
            'itemsTotal' => $paginator->getTotal(),
            'fields' => $entityConfig->listFields(),
            'items' => $rawItems
        ]);
    }
}