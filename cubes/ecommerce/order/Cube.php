<?php

namespace cubes\ecommerce\order;

use WebComplete\core\cube\AbstractCube;
use cubes\ecommerce\order\migrations\OrderMigration;
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
        $definitions[OrderRepositoryInterface::class] = RepositorySelector::get(
            OrderRepositoryMicro::class,
            OrderRepositoryDb::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        return [
            '001_001' => OrderMigration::class
        ];
    }
}
