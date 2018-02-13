<?php

namespace cubes\system\auth;

use WebComplete\mvc\ApplicationConfig;
use WebComplete\rbac\entity\Permission;
use WebComplete\rbac\entity\Role;
use WebComplete\rbac\Rbac;

class RbacLoader
{
    /**
     * @var Rbac
     */
    private $rbac;
    /**
     * @var ApplicationConfig
     */
    private $config;

    /**
     * @param Rbac $rbac
     * @param ApplicationConfig $config
     */
    public function __construct(Rbac $rbac, ApplicationConfig $config)
    {
        $this->rbac = $rbac;
        $this->config = $config;
    }

    /**
     * @throws \WebComplete\rbac\exception\RbacException
     */
    public function initRbacPermissions()
    {
        if ($this->config['rbac']) {
            $permissionsConfig = (array)($this->config['rbac']['permissions'] ?? []);
            $this->addPermissions($permissionsConfig);
        }
    }

    /**
     */
    public function initRbacRoles()
    {
        if ($this->config['rbac']) {
            $rolesConfig = (array)($this->config['rbac']['roles'] ?? []);
            $this->addRoles($rolesConfig);
        }
    }

    /**
     * @param array $permissionsConfig
     * @param Permission|null $parent
     *
     * @throws \WebComplete\rbac\exception\RbacException
     */
    protected function addPermissions(array $permissionsConfig, Permission $parent = null)
    {
        foreach ($permissionsConfig as $name => $config) {
            $permission = $this->rbac->createPermission($name, $config['description'] ?? '');
            if ($parent) {
                $parent->addChild($permission);
            }
            if (!empty($config['permissions'])) {
                $this->addPermissions($config['permissions'], $permission);
            }
        }
    }

    /**
     * @param array $rolesConfig
     * @param Role|null $parent
     *
     * @throws \RuntimeException
     */
    protected function addRoles(array $rolesConfig, Role $parent = null)
    {
        foreach ($rolesConfig as $name => $config) {
            $role = $this->rbac->createRole($name, $config['description'] ?? '');
            if (!empty($config['permissions'])) {
                foreach ((array)$config['permissions'] as $permissionName) {
                    if ($permission = $this->rbac->getPermission($permissionName)) {
                        $role->addPermission($permission);
                    } else {
                        throw new \RuntimeException('Permission not found: ' . $permissionName);
                    }
                }
            }
            if ($parent) {
                $parent->addChild($role);
            }
            if (!empty($config['roles'])) {
                $this->addRoles($config['roles'], $role);
            }
        }
    }
}
