<?php

namespace cubes\system\auth;

interface IdentityInterface
{

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param string $password
     *
     * @return bool
     */
    public function checkPassword(string $password): bool;
}
