<?php

namespace cubes\ecommerce\orderItem;

use cubes\ecommerce\orderItem\migrations\OrderItemMigration;
use cubes\ecommerce\orderItem\repository\OrderItemRepositoryDb;
use cubes\ecommerce\orderItem\repository\OrderItemRepositoryInterface;
use cubes\ecommerce\orderItem\repository\OrderItemRepositoryMicro;
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
        $definitions[OrderItemRepositoryInterface::class] = RepositorySelector::get(
            OrderItemRepositoryMicro::class,
            OrderItemRepositoryDb::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        $migrations = [
            'mysql' => ['001_001' => OrderItemMigration::class]
        ];
        return MigrationSelector::get($migrations);
    }
}
