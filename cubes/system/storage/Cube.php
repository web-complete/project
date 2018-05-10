<?php

namespace cubes\system\storage;

use cubes\system\storage\repository\StorageRepositoryDb;
use cubes\system\storage\repository\StorageRepositoryInterface;
use cubes\system\storage\repository\StorageRepositoryMicro;
use cubes\system\storage\repository\StorageRepositoryMongo;
use WebComplete\core\cube\AbstractCube;
use cubes\system\storage\migrations\StorageMigration;
use modules\admin\classes\cube\RepositorySelector;

class Cube extends AbstractCube
{
    /**
     * @param $definitions
     *
     * @return void
     */
    public function registerDependencies(array &$definitions)
    {
        $definitions[StorageRepositoryInterface::class] = RepositorySelector::get(
            StorageRepositoryMicro::class,
            StorageRepositoryDb::class,
            StorageRepositoryMongo::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        $migrations = [
            'mysql' => ['001_001' => StorageMigration::class]
        ];
        return MigrationSelector::get($migrations);
    }
}
