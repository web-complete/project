<?php

namespace cubes\system\settings;

use admin\assets\AdminAsset;
use admin\classes\Navigation;
use admin\classes\PageRoutes;
use cubes\system\settings\assets\SettingsAsset;
use cubes\system\settings\controllers\SettingsController;
use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;
use WebComplete\mvc\ApplicationConfig;

class Cube extends AbstractCube
{

    /**
     * @param ContainerInterface $container
     */
    public function bootstrap(ContainerInterface $container)
    {
        // register asset
        $adminAsset = $container->get(AdminAsset::class);
        $adminAsset->addAssetAfter($container->get(SettingsAsset::class));

        // register backend route
        $config = $container->get(ApplicationConfig::class);
        $config['routes']->addRoute(['GET', '/admin/settings', [SettingsController::class, 'actionIndex']]);

        // register frontend route
        $pageRoutes = $container->get(PageRoutes::class);
        $pageRoutes->addRoute(1100, ['path' => '/settings', 'component' => 'VuePageSettings']);

        // register navigation item
        $navigation = $container->get(Navigation::class);
        $navigation->addSection('Система', 900);
        $navigation->addItem('Система', 'Настройки', '/settings');
    }

    /**
     * @param $definitions
     *
     * @return void
     */
    public function registerDependencies(array &$definitions)
    {
    }
}
