<?php

namespace admin\controllers;

use admin\assets\AdminAuthAsset;
use cubes\system\user\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\mvc\view\ViewInterface;

class AuthController extends AbstractController
{

    /**
     * @param Request $request
     * @param Response $response
     * @param ViewInterface $view
     * @param UserService $userService
     * @param AdminAuthAsset $authAsset
     * @throws \Exception
     */
    public function __construct(
        Request $request,
        Response $response,
        ViewInterface $view,
        UserService $userService,
        AdminAuthAsset $authAsset
    ) {
        parent::__construct($request, $response, $view, $userService);
        $view->getAssetManager()->registerAsset($authAsset);
    }

    public function beforeAction(): bool
    {
        $this->assets = [AdminAuthAsset::class];
        $this->needAuth = false;
        return parent::beforeAction();
    }

    /**
     * @throws \Exception
     */
    public function actionLogin()
    {
        $this->userService->logout($this->request->getSession());
        return $this->responseHtml('@admin/views/auth/login.php');
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
