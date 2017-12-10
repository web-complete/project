<?php

namespace modules\admin\controllers;

use modules\admin\assets\AdminAsset;
use modules\admin\assets\AdminAuthAsset;
use cubes\system\settings\Settings;
use cubes\system\user\UserService;
use modules\admin\classes\state\SettingsState;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\mvc\view\ViewInterface;

class AuthController extends AbstractController
{
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
     * @param AdminAuthAsset $authAsset
     * @param SettingsState $settingsState
     */
    public function __construct(
        Request $request,
        Response $response,
        ViewInterface $view,
        Settings $settings,
        AdminAsset $adminAsset,
        UserService $userService,
        AdminAuthAsset $authAsset,
        SettingsState $settingsState
    ) {
        parent::__construct($request, $response, $view, $settings, $adminAsset, $userService);
        $this->adminAsset = $authAsset;
        $this->settingsState = $settingsState;
    }

    public function beforeAction(): bool
    {
        $this->needAuth = false;
        return parent::beforeAction();
    }

    /**
     * @throws \Exception
     */
    public function actionLogin()
    {
        $settingsState = $this->settingsState->getState();
        $this->userService->logout($this->request->getSession());
        return $this->responseHtml('@admin/views/auth/login.php', [
            'settingsState' => $settingsState
        ]);
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionAuth(): Response
    {
        $login = $this->request->get('login');
        $password = $this->request->get('password');
        if (!$user = $this->userService->authByLoginPassword($login, $password, $this->request->getSession())) {
            return $this->responseAccessDenied();
        }

        return $this->responseJson([
            'result' => true,
            'token' => $user->getMaskedToken(),
            'fullName' => $user->getFullName(),
        ]);
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function actionLogout(): Response
    {
        $this->userService->logout($this->request->getSession());
        return $this->responseJson([
            'result' => true,
        ]);
    }
}
