<?php

namespace cubes\ecommerce\cart;

use cubes\ecommerce\cart\repository\CartRepositoryDb;
use cubes\ecommerce\cart\repository\CartRepositoryInterface;
use cubes\ecommerce\cart\repository\CartRepositoryMicro;
use cubes\ecommerce\cart\repository\CartRepositoryMongo;
use modules\admin\classes\cube\MigrationSelector;
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
            CartRepositoryDb::class,
            CartRepositoryMongo::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        $migrations = [
            'mysql' => ['001_001' => CartMigration::class]
        ];
        return MigrationSelector::get($migrations);
    }
}
