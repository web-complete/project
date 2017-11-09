<?php

namespace cubes\system\user;

use WebComplete\core\entity\AbstractEntityService;

class UserService extends AbstractEntityService implements UserRepositoryInterface
{

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
    public function login(User $user)
    {
        $this->currentUser = $user;
    }

    /**
     */
    public function logout()
    {
        $this->currentUser = null;
    }
}
