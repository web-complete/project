<?php

namespace cubes\ecommerce\classifier;

use cubes\ecommerce\classifier\admin\Controller;
use cubes\ecommerce\classifier\assets\AdminAsset;
use cubes\ecommerce\classifier\migrations\ClassifierMigration;
use cubes\ecommerce\classifier\repository\ClassifierItemRepositoryDb;
use cubes\ecommerce\classifier\repository\ClassifierItemRepositoryInterface;
use cubes\ecommerce\classifier\repository\ClassifierItemRepositoryMicro;
use cubes\ecommerce\classifier\repository\ClassifierItemRepositoryMongo;
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
        $entityConfig = $container->get(ClassifierItemConfig::class);
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper->defaultCrud($entityConfig);
        $permissionView = 'admin:cubes:ecommerce-classifier:view';
        $cubeHelper->appendAsset($container->get(AdminAsset::class))
            ->addBackendRoute(['GET', '/admin/api/entity/ecommerce-classifier/tree', [Controller::class, 'actionTree']])
            ->addBackendRoute(['POST', '/admin/api/entity/ecommerce-classifier/move', [Controller::class, 'actionMove']])
            ->addVueRoute(['path' => '/ecommerce/classifier', 'component' => 'VuePageEcommerceClassifier'])
            ->addMenuSection('Магазин', 120)
            ->addMenuItem('Магазин', 'Классификатор', '/ecommerce/classifier', 130, $permissionView);
    }

    /**
     * @param $definitions
     *
     * @return void
     */
    public function registerDependencies(array &$definitions)
    {
        $definitions[ClassifierItemRepositoryInterface::class] = RepositorySelector::get(
            ClassifierItemRepositoryMicro::class,
            ClassifierItemRepositoryDb::class,
            ClassifierItemRepositoryMongo::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        $migrations = [
            'mysql' => ['001_001' => ClassifierMigration::class]
        ];
        return MigrationSelector::get($migrations);
    }
}
