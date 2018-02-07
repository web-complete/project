<?php

namespace cubes\ecommerce\cart;

use WebComplete\core\cube\AbstractCube;
use cubes\ecommerce\cart\migrations\CartMigration;
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
        $definitions[CartRepositoryInterface::class] = RepositorySelector::get(
            CartRepositoryMicro::class,
            CartRepositoryDb::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        return [
            '001_001' => CartMigration::class
        ];
    }
}
