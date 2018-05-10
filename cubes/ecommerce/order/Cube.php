<?php

namespace cubes\ecommerce\order;

use cubes\ecommerce\order\migrations\OrderMigration;
use cubes\ecommerce\order\repository\OrderRepositoryDb;
use cubes\ecommerce\order\repository\OrderRepositoryInterface;
use cubes\ecommerce\order\repository\OrderRepositoryMicro;
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
        $definitions[OrderRepositoryInterface::class] = RepositorySelector::get(OrderRepositoryMicro::class,
            OrderRepositoryDb::class);
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        $migrations['mysql'] = [
            '001_001' => OrderMigration::class,
        ];

        return MigrationSelector::get($migrations);
    }

}
