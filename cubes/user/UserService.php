<?php

namespace cubes\user;

use WebComplete\core\entity\AbstractEntityService;

class UserService extends AbstractEntityService implements UserRepositoryInterface
{

    public function __construct(UserRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
