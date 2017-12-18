<?php

namespace cubes\system\settings;

use modules\admin\classes\CubeHelper;
use cubes\system\settings\assets\SettingsAsset;
use cubes\system\settings\admin\Controller;
use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;

class Cube extends AbstractCube
{
    /**
     * @param ContainerInterface $container
     */
    public function bootstrap(ContainerInterface $container)
    {
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper->appendAsset($container->get(SettingsAsset::class))
            ->addBackendRoute(['GET', '/admin/api/settings', [Controller::class, 'actionGet']])
            ->addBackendRoute(['POST', '/admin/api/settings', [Controller::class, 'actionSave']])
            ->addVueRoute(['path' => '/settings', 'component' => 'VuePageSettings'])
            ->addMenuSection('Система', 900)
            ->addMenuItem('Система', 'Настройки', '/settings', 100);
    }
}
