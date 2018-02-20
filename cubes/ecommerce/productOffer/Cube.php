<?php

namespace cubes\ecommerce\productOffer;

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
            ProductOfferRepositoryDb::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        return [
            '001_001' => ProductOfferMigration::class
        ];
    }
}
