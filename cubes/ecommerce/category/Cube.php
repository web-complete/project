<?php

namespace cubes\ecommerce\category;

use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;
use cubes\ecommerce\category\migrations\CategoryMigration;
use modules\admin\classes\cube\CubeHelper;
use modules\admin\classes\cube\RepositorySelector;
use cubes\ecommerce\category\assets\AdminAsset;

class Cube extends AbstractCube
{
    /**
     * @param ContainerInterface $container
     *
     * @throws \Exception
     */
    public function bootstrap(ContainerInterface $container)
    {
        $entityConfig = $container->get(CategoryConfig::class);
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper->defaultCrud($entityConfig);

        $sysName = $entityConfig->getSystemName();
        $cubeHelper->appendAsset($container->get(AdminAsset::class));
        $cubeHelper->addVueRoute(['path' => '/list/' . $sysName, 'component' => 'VuePageCategoryList']);
        $cubeHelper->addVueRoute(['path' => '/detail/' . $sysName . '/:id', 'component' => 'VuePageCategoryDetail']);
    }

    /**
     * @param $definitions
     *
     * @return void
     */
    public function registerDependencies(array &$definitions)
    {
        $definitions[CategoryRepositoryInterface::class] = RepositorySelector::get(
            CategoryRepositoryMicro::class,
            CategoryRepositoryDb::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        return [
            '001_001' => CategoryMigration::class
        ];
    }
}
