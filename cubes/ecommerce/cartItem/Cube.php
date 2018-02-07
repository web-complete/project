<?php

namespace cubes\ecommerce\cartItem;

use WebComplete\core\cube\AbstractCube;
use cubes\ecommerce\cartItem\migrations\CartItemMigration;
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
        $definitions[CartItemRepositoryInterface::class] = RepositorySelector::get(
            CartItemRepositoryMicro::class,
            CartItemRepositoryDb::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        return [
            '001_001' => CartItemMigration::class
        ];
    }
}
