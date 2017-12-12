<?php

namespace modules\admin\controllers;

use modules\admin\classes\Navigation;
use modules\admin\classes\PageRoutes;
use modules\admin\classes\state\SettingsState;
use modules\admin\classes\state\UserState;

class IndexController extends AbstractController
{

    /**
     * @throws \Exception
     */
    public function actionApp()
    {
        $settingsState = $this->container->get(SettingsState::class);
        $userState = $this->container->get(UserState::class);
        $navigation = $this->container->get(Navigation::class);
        $pageRoutes = $this->container->get(PageRoutes::class);

        return $this->responseHtml('@admin/views/index/app.php', [
            'settingsState' => $settingsState->getState(),
            'userState' => $userState->getState(),
            'navigation' => $navigation->get(),
            'routesJson' => $pageRoutes->getRoutesJson(),
        ]);
    }
}
