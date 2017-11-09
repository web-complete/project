<?php

namespace cubes\system\user;

use cubes\system\auth\IdentityInterface;
use cubes\system\auth\IdentityServiceInterface;
use WebComplete\core\entity\AbstractEntityService;

class UserService extends AbstractEntityService implements UserRepositoryInterface, IdentityServiceInterface
{

    /**
     * @var UserRepositoryInterface
     */
    protected $repository;
    /**
     * @var User|null
     */
    protected $currentUser;

    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(
        UserRepositoryInterface $repository
    ) {
        parent::__construct($repository);
    }

    /**
     * @return User|null
     */
    public function current()
    {
        return $this->currentUser;
    }

    /**
     * @param User $user
     */
    public function login(IdentityInterface $user)
    {
        $this->currentUser = $user;
    }

    /**
     */
    public function logout()
    {
        $this->currentUser = null;
    }

    /**
     * @param string $token
     *
     * @return User|IdentityInterface|null
     */
    public function findByToken(string $token)
    {
        return $this->repository->findByToken($token);
    }
}
