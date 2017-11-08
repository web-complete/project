<?php

namespace cubes\system\auth;

interface IdentityInterface
{

    /**
     * @return mixed
     */
    public function getId();

    /**
     * Check access rights by rbac permission
     * @param string $permissionName
     * @param null $ruleParams
     *
     * @return bool
     */
    public function can(string $permissionName, $ruleParams = null): bool;
}
