<?php

namespace cubes\system\auth;

use cubes\system\auth\migrations\AuthMigration;
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
    }

    public function getMigrations(): array
    {
        return [
            '000_001' => AuthMigration::class
        ];
    }
}
