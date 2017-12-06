<?php

namespace cubes\system\settings;

use admin\assets\AdminAsset;
use admin\classes\PageRoutes;
use cubes\system\settings\assets\SettingsAsset;
use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;

class Cube extends AbstractCube
{

    /**
     * @param ContainerInterface $container
     */
    public function bootstrap(ContainerInterface $container)
    {
        $adminAsset = $container->get(AdminAsset::class);
        $adminAsset->addAssetAfter($container->get(SettingsAsset::class));
        $pageRoutes = $container->get(PageRoutes::class);
        $pageRoutes->addRoute(1100, ['path' => '/settings', 'component' => 'VuePageSettings']);
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
