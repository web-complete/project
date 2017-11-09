<?php

namespace cubes\system\auth;

interface IdentityServiceInterface
{
    /**
     * @param $id
     *
     * @return IdentityInterface|null
     */
    public function findById($id);

    /**
     * @param string $token
     *
     * @return IdentityInterface|null
     */
    public function findByToken(string $token);

    /**
     * @param IdentityInterface $identity
     */
    public function login(IdentityInterface $identity);

    /**
     */
    public function logout();

    /**
     * @return IdentityInterface|null
     */
    public function current();
}
