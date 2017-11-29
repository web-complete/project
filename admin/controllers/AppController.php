<?php

namespace admin\controllers;

use cubes\system\user\User;
use WebComplete\core\condition\Condition;

class AppController extends AbstractAdminController
{

    protected $layout = '@admin/views/layouts/admin.php';

    /**
     * @throws \Exception
     */
    public function actionIndex()
    {
        return $this->responseHtml('@admin/views/App/index.php', []);
    }

    public function actionAuth()
    {
        $login = $this->request->get('login');
        $password = $this->request->get('password');
        if (!$login || !$password) {
            return $this->responseAccessDenied();
        }

        /** @var User $user */
        if (!$user = $this->userService->findOne(new Condition(['login' => $login]))) {
            return $this->responseAccessDenied();
        }

        if (!$user->checkPassword($password)) {
            return $this->responseAccessDenied();
        }

        $this->userService->login($user);
        if ($session = $this->request->getSession()) {
            $session->set('userId', $user->getId());
        }

        return $this->responseJson([
            'result' => true,
            'token' => $user->getToken(),
        ]);
    }
}
