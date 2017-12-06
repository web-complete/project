<?php

namespace admin\controllers;

use admin\assets\AdminAsset;
use admin\classes\Navigation;
use admin\classes\PageRoutes;
use admin\classes\state\UserState;
use cubes\system\user\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\mvc\view\ViewInterface;

class IndexController extends AbstractController
{
    /**
     * @var UserState
     */
    private $userState;
    /**
     * @var Navigation
     */
    private $navigation;
    /**
     * @var PageRoutes
     */
    private $pageRoutes;

    /**
     * @param Request $request
     * @param Response $response
     * @param ViewInterface $view
     * @param AdminAsset $adminAsset
     * @param UserService $userService
     * @param UserState $userState
     * @param Navigation $navigation
     * @param PageRoutes $pageRoutes
     */
    public function __construct(
        Request $request,
        Response $response,
        ViewInterface $view,
        AdminAsset $adminAsset,
        UserService $userService,
        UserState $userState,
        Navigation $navigation,
        PageRoutes $pageRoutes
    ) {
        parent::__construct($request, $response, $view, $adminAsset, $userService);
        $this->userState = $userState;
        $this->navigation = $navigation;
        $this->pageRoutes = $pageRoutes;
    }

    /**
     * @throws \Exception
     */
    public function actionIndex()
    {
        $userState = $this->userState->getState();
        $navigation = $this->navigation->get();
        $routesJson = $this->pageRoutes->getRoutesJson();

        return $this->responseHtml('@admin/views/index/index.php', [
            'userState' => $userState,
            'navigation' => $navigation,
            'routesJson' => $routesJson,
        ]);
    }
}
