<?php

namespace cubes\auth;

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
     * @param string $password
     *
     * @return bool
     */
    public function checkPassword(IdentityInterface $identity, string $password): bool;

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
