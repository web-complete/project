<?php

namespace modules\admin\controllers;

use modules\admin\assets\AdminAuthAsset;
use modules\admin\classes\state\SettingsState;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\core\utils\container\ContainerInterface;

class AuthController extends AbstractController
{
    /**
     * @var SettingsState
     */
    private $settingsState;

    /**
     * @param ContainerInterface $container
     * @throws \RuntimeException
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->adminAsset = $this->container->get(AdminAuthAsset::class);
        $this->settingsState = $this->container->get(SettingsState::class);
    }

    /**
     * @return bool
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     * @throws \InvalidArgumentException
     */
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
