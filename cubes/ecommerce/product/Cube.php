<?php

namespace cubes\ecommerce\product;

use cubes\ecommerce\interfaces\ProductOfferServiceInterface;
use cubes\ecommerce\product\admin\Controller;
use cubes\ecommerce\product\assets\AdminAsset;
use modules\admin\classes\cube\CubeHelper;
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
