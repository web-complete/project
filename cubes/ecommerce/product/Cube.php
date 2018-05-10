<?php

namespace cubes\ecommerce\product;

use cubes\ecommerce\interfaces\ProductOfferServiceInterface;
use cubes\ecommerce\product\admin\Controller;
use cubes\ecommerce\product\assets\AdminAsset;
use cubes\ecommerce\product\repository\ProductRepositoryDb;
use cubes\ecommerce\product\repository\ProductRepositoryInterface;
use cubes\ecommerce\product\repository\ProductRepositoryMicro;
use cubes\ecommerce\product\repository\ProductRepositoryMongo;
use modules\admin\classes\cube\CubeHelper;
use modules\admin\classes\cube\MigrationSelector;
use WebComplete\core\cube\AbstractCube;
use cubes\ecommerce\product\migrations\ProductMigration;
use modules\admin\classes\cube\RepositorySelector;
use WebComplete\core\utils\container\ContainerInterface;

class Cube extends AbstractCube
{
    /**
     * @param ContainerInterface $container
     *
     * @throws \Exception
     */
    public function bootstrap(ContainerInterface $container)
    {
        $entityConfig = $container->get(ProductConfig::class);
        $sysName = $entityConfig->getSystemName();
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper
            ->defaultCrud($entityConfig)
            ->addBackendRoute(['GET', "/admin/api/entity/$sysName/{productId}/properties/{categoryId}", [
                Controller::class, 'actionProperties'
            ]])
            ->appendAsset($container->get(AdminAsset::class))
            ->addVueRoute(['path' => '/detail/' . $sysName . '/:id', 'component' => 'VuePageProductDetail']);
    }

    /**
     * @param $definitions
     *
     * @return void
     */
    public function registerDependencies(array &$definitions)
    {
        $definitions[ProductRepositoryInterface::class] = RepositorySelector::get(
            ProductRepositoryMicro::class,
            ProductRepositoryDb::class,
            ProductRepositoryMongo::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        $migrations = [
            'mysql' => ['001_001' => ProductMigration::class]
        ];
        return MigrationSelector::get($migrations);
    }
}
