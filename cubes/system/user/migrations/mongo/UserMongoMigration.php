<?php

namespace cubes\system\user\migrations\mongo;

use cubes\system\mongo\Mongo;
use cubes\system\user\User;
use cubes\system\user\UserService;
use WebComplete\core\utils\migration\MigrationInterface;
use WebComplete\rbac\Rbac;

class UserMongoMigration implements MigrationInterface
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var Rbac
     */
    private $rbac;
    /**
     * @var Mongo
     */
    private $mongo;

    /**
     * @param UserService $userService
     * @param Rbac $rbac
     * @param Mongo $mongo
     */
    public function __construct(
        UserService $userService,
        Rbac $rbac,
        Mongo $mongo
    ) {
        $this->userService = $userService;
        $this->rbac = $rbac;
        $this->mongo = $mongo;
    }

    public function up()
    {
        $this->createAdmin();
    }

    public function down()
    {
        $this->mongo->selectCollection('user')->deleteMany([]);
    }

    protected function createAdmin()
    {
        /** @var User $user */
        $user = $this->userService->create();
        $user->first_name = 'Administrator';
        $user->login = 'admin';
        $user->is_active = true;
        $user->roles = ['admin'];
        $user->setNewPassword('123qwe4');
        $this->userService->save($user);
    }
}
