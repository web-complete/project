<?php

namespace cubes\system\tags;

use cubes\system\tags\migrations\TagMigration;
use cubes\system\tags\repository\TagRepositoryDb;
use cubes\system\tags\repository\TagRepositoryInterface;
use cubes\system\tags\repository\TagRepositoryMicro;
use cubes\system\tags\repository\TagRepositoryMongo;
use modules\admin\classes\cube\MigrationSelector;
use modules\admin\classes\cube\RepositorySelector;
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
        $definitions[TagRepositoryInterface::class] = RepositorySelector::get(
            TagRepositoryMicro::class,
            TagRepositoryDb::class,
            TagRepositoryMongo::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        $migrations = [
            'mysql' => ['001_001' => TagMigration::class]
        ];
        return MigrationSelector::get($migrations);
    }
}
