<?php

namespace cubes\ecommerce\category;

use cubes\ecommerce\category\assets\AdminAsset;
use cubes\ecommerce\category\migrations\CategoryMigration;
use cubes\ecommerce\category\repository\CategoryRepositoryDb;
use cubes\ecommerce\category\repository\CategoryRepositoryInterface;
use cubes\ecommerce\category\repository\CategoryRepositoryMicro;
use cubes\ecommerce\category\repository\CategoryRepositoryMongo;
use modules\admin\classes\cube\CubeHelper;
use modules\admin\classes\cube\MigrationSelector;
use modules\admin\classes\cube\RepositorySelector;
use WebComplete\core\cube\AbstractCube;
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
        $entityConfig = $container->get(CategoryConfig::class);
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper->defaultCrud($entityConfig);

        $sysName = $entityConfig->getSystemName();
        $cubeHelper->appendAsset($container->get(AdminAsset::class));
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
            CategoryRepositoryDb::class,
            CategoryRepositoryMongo::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        $migrations = [
            'mysql' => ['001_001' => CategoryMigration::class]
        ];
        return MigrationSelector::get($migrations);
    }
}
