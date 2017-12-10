<?php

namespace modules\admin\controllers;

use modules\admin\assets\AdminAsset;
use modules\admin\classes\Navigation;
use modules\admin\classes\PageRoutes;
use modules\admin\classes\state\SettingsState;
use modules\admin\classes\state\UserState;
use cubes\system\settings\Settings;
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
     * @var SettingsState
     */
    private $settingsState;

    /**
     * @param Request $request
     * @param Response $response
     * @param ViewInterface $view
     * @param Settings $settings
     * @param AdminAsset $adminAsset
     * @param UserService $userService
     * @param UserState $userState
     * @param SettingsState $settingsState
     * @param Navigation $navigation
     * @param PageRoutes $pageRoutes
     */
    public function __construct(
        Request $request,
        Response $response,
        ViewInterface $view,
        Settings $settings,
        AdminAsset $adminAsset,
        UserService $userService,
        UserState $userState,
        SettingsState $settingsState,
        Navigation $navigation,
        PageRoutes $pageRoutes
    ) {
        parent::__construct($request, $response, $view, $settings, $adminAsset, $userService);
        $this->userState = $userState;
        $this->navigation = $navigation;
        $this->pageRoutes = $pageRoutes;
        $this->settingsState = $settingsState;
    }

    /**
     * @throws \Exception
     */
    public function actionApp()
    {
        $settingsState = $this->settingsState->getState();
        $userState = $this->userState->getState();
        $navigation = $this->navigation->get();
        $routesJson = $this->pageRoutes->getRoutesJson();

        return $this->responseHtml('@admin/views/index/app.php', [
            'settingsState' => $settingsState,
            'userState' => $userState,
            'navigation' => $navigation,
            'routesJson' => $routesJson,
        ]);
    }
}
