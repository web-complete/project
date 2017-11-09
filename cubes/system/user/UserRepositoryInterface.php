<?php

namespace cubes\system\user;

use WebComplete\core\entity\EntityRepositoryInterface;

interface UserRepositoryInterface extends EntityRepositoryInterface
{

    /**
     * @param string $token
     *
     * @return User|null
     */
    public function findByToken(string $token);
}
