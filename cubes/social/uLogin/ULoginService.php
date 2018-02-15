<?php

namespace cubes\social\uLogin;

use cubes\system\user\User;
use cubes\system\user\UserService;

class ULoginService
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param $token
     * @param $host
     *
     * @return mixed|array
     */
    public function fetchData($token, $host)
    {
        $response = file_get_contents('http://ulogin.ru/token.php?token=' . $token . '&host=' . $host);
        return json_decode($response, true);
    }

    /**
     * @param array $data
     *
     * @return User
     * @throws \InvalidArgumentException
     */
    public function findOrCreate(array $data): User
    {
        if (!$network = $data['network'] ?? null) {
            throw new \InvalidArgumentException('network is not defined');
        }
        if (!$uid = $data['uid'] ?? null) {
            throw new \InvalidArgumentException('uid is not defined');
        }

        $login = $network . '_' . $uid;
        if (!$user = $this->userService->findByLogin($login)) {
            $user = $this->userService->create();
            $user->login = $login;
            $user->email = $data['email'] ?? '';
            $user->first_name = $data['first_name'] ?? '';
            $user->last_name = $data['last_name'] ?? '';
            $user->roles = ['user'];
            $this->userService->save($user);
        }

        return $user;
    }
}
