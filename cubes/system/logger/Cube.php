<?php

namespace cubes\system\logger;

use cubes\system\logger\assets\AdminAsset;
use cubes\system\logger\controllers\Controller;
use cubes\system\logger\controllers\LogController;
use modules\admin\classes\cube\CubeHelper;
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
            ->addBackendRoute(['POST', '/api/log', [LogController::class, 'actionLog']])
            ->addBackendRoute(['DELETE', '/admin/api/log', [Controller::class, 'actionClear']])
            ->addBackendRoute(['GET', '/admin/api/log/last/{num:\d+}', [Controller::class, 'actionLast']])
            ->addVueRoute(['path' => '/log', 'component' => 'VuePageLog'])
            ->addPermission('admin:cubes:logger', 'Журнал')
            ->addMenuSection('Система', 1000)
            ->addMenuItem('Система', 'Журнал ошибок', '/log', 450, 'admin:cubes:logger');
    }
}
