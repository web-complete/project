<?php

namespace cubes\ecommerce\productOffer;

use cubes\ecommerce\productOffer\repository\ProductOfferRepositoryDb;
use cubes\ecommerce\productOffer\repository\ProductOfferRepositoryInterface;
use cubes\ecommerce\productOffer\repository\ProductOfferRepositoryMicro;
use cubes\ecommerce\productOffer\repository\ProductOfferRepositoryMongo;
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
        $definitions[ProductOfferRepositoryInterface::class] = RepositorySelector::get(
            ProductOfferRepositoryMicro::class,
            ProductOfferRepositoryDb::class,
            ProductOfferRepositoryMongo::class
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
