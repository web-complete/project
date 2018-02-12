<?php

namespace cubes\system\auth;

use DI\Container;
use WebComplete\core\cube\AbstractCube;
use WebComplete\mvc\ApplicationConfig;
use WebComplete\rbac\entity\Permission;
use WebComplete\rbac\entity\Role;
use WebComplete\rbac\Rbac;
use WebComplete\rbac\resource\RuntimeResource;

class Cube extends AbstractCube
{

    /**
     * @param $definitions
     *
     * @return void
     */
    public function registerDependencies(array &$definitions)
    {
        $definitions[Rbac::class] = function (Container $container) {
            $config = $container->get(ApplicationConfig::class);
            $rbac = new Rbac(new RuntimeResource());
            $this->initRbac($rbac, $config);
            return $rbac;
        };
    }

    /**
     * @param Rbac $rbac
     * @param ApplicationConfig $config
     *
     * @throws \WebComplete\rbac\exception\RbacException
     */
    protected function initRbac(Rbac $rbac, ApplicationConfig $config)
    {
        if ($config['rbac']) {
            $permissionsConfig = (array)($config['rbac']['permissions'] ?? []);
            $rolesConfig = (array)($config['rbac']['roles'] ?? []);
            $this->addPermissions($rbac, $permissionsConfig);
            $this->addRoles($rbac, $rolesConfig);
        }
    }

    /**
     * @param Rbac $rbac
     * @param array $permissionsConfig
     * @param Permission|null $parent
     *
     * @throws \WebComplete\rbac\exception\RbacException
     */
    protected function addPermissions(Rbac $rbac, array $permissionsConfig, Permission $parent = null)
    {
        foreach ($permissionsConfig as $name => $config) {
            $permission = $rbac->createPermission($name, $config['description'] ?? '');
            if ($parent) {
                $parent->addChild($permission);
            }
            if (!empty($config['permissions'])) {
                $this->addPermissions($rbac, $config['permissions'], $permission);
            }
        }
    }

    /**
     * @param Rbac $rbac
     * @param array $rolesConfig
     * @param Role|null $parent
     *
     * @throws \RuntimeException
     */
    protected function addRoles(Rbac $rbac, array $rolesConfig, Role $parent = null)
    {
        foreach ($rolesConfig as $name => $config) {
            $role = $rbac->createRole($name, $config['description'] ?? '');
            if (!empty($config['permissions'])) {
                foreach ((array)$config['permissions'] as $permissionName) {
                    if ($permission = $rbac->getPermission($permissionName)) {
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
                $this->addRoles($rbac, $config['roles'], $role);
            }
        }
    }
}
