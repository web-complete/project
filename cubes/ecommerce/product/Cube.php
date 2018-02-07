<?php

namespace cubes\ecommerce\product;

use cubes\ecommerce\interfaces\ProductOfferServiceInterface;
use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;
use cubes\ecommerce\product\migrations\ProductMigration;
use modules\admin\classes\cube\CubeHelper;
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
        $definitions[ProductOfferServiceInterface::class] = \DI\object(ProductService::class);
        $definitions[ProductRepositoryInterface::class] = RepositorySelector::get(
            ProductRepositoryMicro::class,
            ProductRepositoryDb::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        return [
            '001_001' => ProductMigration::class
        ];
    }
}
