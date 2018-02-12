<?php

namespace cubes\system\settings;

use modules\admin\classes\cube\CubeHelper;
use cubes\system\settings\assets\AdminAsset;
use cubes\system\settings\admin\Controller;
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
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper->appendAsset($container->get(AdminAsset::class))
            ->addBackendRoute(['GET', '/admin/api/settings', [Controller::class, 'actionGet']])
            ->addBackendRoute(['POST', '/admin/api/settings', [Controller::class, 'actionSave']])
            ->addVueRoute(['path' => '/settings', 'component' => 'VuePageSettings'])
            ->addPermission('admin:cubes:settings', 'Настройки')
            ->addMenuSection('Система', 1000)
            ->addMenuItem('Система', 'Настройки', '/settings', 500, 'admin:cubes:settings');
    }
}
