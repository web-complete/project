<?php

namespace modules\admin\controllers;

use cubes\multilang\lang\LangService;
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
        $settingsState = $this->container->get(SettingsState::class);
        $userState = $this->container->get(UserState::class);
        $langState = $this->container->get(LangService::class)->getState();
        $navigation = $this->container->get(Navigation::class);
        $pageRoutes = $this->container->get(VueRoutes::class);

        return $this->responseHtml('@admin/views/index/app.php', [
            'settingsState' => $settingsState->getState(),
            'userState' => $userState->getState(),
            'langState' => $langState,
            'navigation' => $navigation->get(),
            'routesJson' => $pageRoutes->getRoutesJson(),
        ]);
    }
}
