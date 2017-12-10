<?php

namespace cubes\system\file;

use cubes\system\file\migrations\FileMigration;
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
        $definitions[FileRepositoryInterface::class] = \DI\object(FileRepositoryMicro::class);
    }

    public function getMigrations(): array
    {
        return [
            '001_001' => FileMigration::class
        ];
    }
}