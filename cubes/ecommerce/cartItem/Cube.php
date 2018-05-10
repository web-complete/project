<?php

namespace cubes\ecommerce\cartItem;

use cubes\ecommerce\cartItem\migrations\CartItemMigration;
use cubes\ecommerce\cartItem\repository\CartItemRepositoryDb;
use cubes\ecommerce\cartItem\repository\CartItemRepositoryInterface;
use cubes\ecommerce\cartItem\repository\CartItemRepositoryMicro;
use cubes\ecommerce\cartItem\repository\CartItemRepositoryMongo;
use cubes\ecommerce\interfaces\ProductOfferServiceInterface;
use cubes\ecommerce\productOffer\ProductOfferItemService;
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
        $definitions[CartItemRepositoryInterface::class] = RepositorySelector::get(
            CartItemRepositoryMicro::class,
            CartItemRepositoryDb::class,
            CartItemRepositoryMongo::class
        );
        $definitions[ProductOfferServiceInterface::class] = \DI\autowire(ProductOfferItemService::class);
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        $migrations = [
            'mysql' => ['001_001' => CartItemMigration::class]
        ];
        return MigrationSelector::get($migrations);
    }
}
