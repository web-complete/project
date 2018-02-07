<?php

namespace cubes\ecommerce\orderItem;

use WebComplete\core\cube\AbstractCube;
use cubes\ecommerce\orderItem\migrations\OrderItemMigration;
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
        return [
            '001_001' => OrderItemMigration::class
        ];
    }
}
