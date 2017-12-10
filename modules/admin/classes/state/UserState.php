<?php

namespace modules\admin\classes\state;

use cubes\system\user\UserService;

class UserState
{

    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return array
     */
    public function getState(): array
    {
        $currentUser = $this->userService->current();
        return [
            'token' => $currentUser ? $currentUser->getToken() : '',
            'fullName' => $currentUser ? $currentUser->getFullName() : ''
        ];
    }
}