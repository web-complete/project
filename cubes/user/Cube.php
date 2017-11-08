<?php

namespace cubes\user;

use cubes\user\migrations\UserMigration;
use WebComplete\core\cube\AbstractCube;

class Cube extends AbstractCube
{

    /**
     * @param $definitions
     *
     * @return void
     */
    public function registerDependencies(array &$definitions)
    {
        $definitions[UserRepositoryInterface::class] = \DI\object(UserRepositoryDb::class);
    }

    public function getMigrations(): array
    {
        return [
            '001_001' => UserMigration::class
        ];
    }
}
