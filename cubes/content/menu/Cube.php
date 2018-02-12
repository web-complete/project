<?php

namespace cubes\content\menu;

use cubes\content\menu\admin\Controller;
use cubes\content\menu\assets\AdminAsset;
use cubes\content\menu\migrations\MenuMigration;
use modules\admin\classes\cube\CubeHelper;
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
        $entityConfig = $container->get(MenuItemConfig::class);
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper->defaultCrud($entityConfig);
        $permissionView = 'admin:cubes:menu:view';
        $cubeHelper->appendAsset($container->get(AdminAsset::class))
            ->addBackendRoute(['GET', '/admin/api/entity/menu/tree', [Controller::class, 'actionTree']])
            ->addBackendRoute(['POST', '/admin/api/entity/menu/move', [Controller::class, 'actionMove']])
            ->addVueRoute(['path' => '/content/menu', 'component' => 'VuePageContentMenu'])
            ->addMenuSection('Контент', 100)
            ->addMenuItem('Контент', 'Динамическое меню', '/content/menu', 50, $permissionView);
    }

    /**
     * @param $definitions
     *
     * @return void
     */
    public function registerDependencies(array &$definitions)
    {
        $definitions[MenuItemRepositoryInterface::class] = RepositorySelector::get(
            MenuItemRepositoryMicro::class,
            MenuItemRepositoryDb::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        return [
            '001_001' => MenuMigration::class
        ];
    }
}
