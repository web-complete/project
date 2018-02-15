<?php

namespace cubes\social\uLogin\api;

use cubes\social\uLogin\ULoginService;
use cubes\system\user\UserService;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\mvc\controller\AbstractController;

class Controller extends AbstractController
{

    /**
     * @return Response|string
     * @throws \InvalidArgumentException
     */
    public function actionAuth()
    {
        $userService = $this->container->get(UserService::class);
        $uLoginService = $this->container->get(ULoginService::class);

        $token = $this->request->get('token');
        $host = $this->request->server->get('HTTP_HOST');
        if (!$token || !$host) {
            return $this->responseAccessDenied();
        }

        $data = $uLoginService->fetchData($token, $host);
        if (!empty($data['error'])) {
            return $this->responseAccessDenied();
        }

        if ($user = $uLoginService->findOrCreate((array)$data)) {
            $userService->login($user);
        }

        return $this->responseRedirect('/');
    }
}
