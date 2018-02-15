<?php

namespace modules\admin\controllers;

use cubes\system\multilang\lang\LangService;
use cubes\system\user\UserService;
use modules\admin\classes\Navigation;
use modules\admin\classes\VueRoutes;
use modules\admin\classes\state\SettingsState;
use modules\admin\classes\state\UserState;

class IndexController extends AbstractController
{

    /**
     * @throws \Exception
     */
    public function actionApp()
    {
        $userService = $this->container->get(UserService::class);
        $settingsState = $this->container->get(SettingsState::class);
        $userState = $this->container->get(UserState::class);
        $langState = $this->container->get(LangService::class)->getState();
        $navigation = $this->container->get(Navigation::class);
        $pageRoutes = $this->container->get(VueRoutes::class);

        return $this->responseHtml('@admin/views/index/app.php', [
            'settingsState' => $settingsState->getState(),
            'userState' => $userState->getState(),
            'langState' => $langState,
            'navigation' => $navigation->get($userService->current()),
            'routesJson' => $pageRoutes->getRoutesJson(),
        ]);
    }
}
