<?php

namespace cubes\ecommerce\productOffer;

use cubes\ecommerce\productOffer\repository\ProductOfferItemRepositoryDb;
use cubes\ecommerce\productOffer\repository\ProductOfferItemRepositoryInterface;
use cubes\ecommerce\productOffer\repository\ProductOfferItemRepositoryMicro;
use cubes\ecommerce\productOffer\repository\ProductOfferItemRepositoryMongo;
use modules\admin\classes\cube\MigrationSelector;
use WebComplete\core\cube\AbstractCube;
use cubes\ecommerce\productOffer\migrations\ProductOfferMigration;
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
        $definitions[ProductOfferItemRepositoryInterface::class] = RepositorySelector::get(
            ProductOfferItemRepositoryMicro::class,
            ProductOfferItemRepositoryDb::class,
            ProductOfferItemRepositoryMongo::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        $migrations = [
            'mysql' => ['001_001' => ProductOfferMigration::class]
        ];
        return MigrationSelector::get($migrations);
    }
}
