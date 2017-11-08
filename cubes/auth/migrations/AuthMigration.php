<?php

namespace cubes\auth\migrations;

use WebComplete\core\utils\alias\AliasService;
use WebComplete\core\utils\migration\MigrationInterface;
use WebComplete\rbac\Rbac;

class AuthMigration implements MigrationInterface
{

    protected $permissions = [
        'admin:login' => 'Доступ к административной панели',
    ];

    protected $roles = [
        'admin' => ['admin:login'],
    ];

    /**
     * @var AliasService
     */
    private $aliasService;

    /**
     * @var Rbac
     */
    private $rbac;

    /**
     * @param AliasService $aliasService
     * @param Rbac $rbac
     */
    public function __construct(AliasService $aliasService, Rbac $rbac)
    {
        $this->aliasService = $aliasService;
        $this->rbac = $rbac;
    }

    public function up()
    {
        $permissions = [];
        foreach ($this->permissions as $permissionName => $description) {
            $permissions[$permissionName] = $this->rbac->createPermission($permissionName, $description);
        }

        foreach ($this->roles as $roleName => $permissionNames) {
            $role = $this->rbac->createRole($roleName);
            foreach ($permissionNames as $permissionName) {
                $role->addPermission($permissions[$permissionName]);
            }
        }

        $this->rbac->save();
    }

    public function down()
    {
        $this->rbac->clear();
        $this->rbac->save();
    }
}
