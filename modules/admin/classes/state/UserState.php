<?php

namespace modules\admin\classes\state;

use cubes\system\user\User;
use cubes\system\user\UserService;

class UserState
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
     * @return array
     */
    public function getState(): array
    {
        $currentUser = $this->userService->current();
        return [
            'token' => $currentUser ? $currentUser->token : '',
            'fullName' => $currentUser ? $currentUser->getFullName() : '',
            'permissions' => $this->getUserPermissions($currentUser),
        ];
    }

    /**
     * @param User $user
     *
     * @return array
     */
    protected function getUserPermissions(User $user): array
    {
        $result = [];
        foreach ($user->getRoles() as $role) {
            $permissions = $role->getPermissions(true);
            foreach ($permissions as $permission) {
                $result[$permission->getName()] = true;
            }
        }
        return \array_keys($result);
    }
}
