<?php

namespace cubes\system\auth;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
     * @param SessionInterface|null $session
     *
     * @return
     */
    public function logout($session);

    /**
     * @return IdentityInterface|null
     */
    public function current();
}
