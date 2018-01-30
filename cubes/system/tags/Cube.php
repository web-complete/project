<?php

namespace cubes\system\tags;

use cubes\system\tags\migrations\TagMigration;
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
            TagRepositoryDb::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        return [
            '001_001' => TagMigration::class
        ];
    }
}
