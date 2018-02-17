<?php

namespace cubes\ecommerce\product;

use cubes\ecommerce\interfaces\ProductOfferServiceInterface;
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
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper->defaultCrud($entityConfig);

        $sysName = $entityConfig->getSystemName();
        $cubeHelper->appendAsset($container->get(AdminAsset::class));
        $cubeHelper->addVueRoute(['path' => '/detail/' . $sysName . '/:id', 'component' => 'VuePageProductDetail']);
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
