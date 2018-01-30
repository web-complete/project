<?php

namespace cubes\system\roles;

use cubes\system\roles\admin\Controller;
use cubes\system\roles\assets\AdminAsset;
use modules\admin\classes\CubeHelper;
use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;

class Cube extends AbstractCube
{
    /**
     * @param ContainerInterface $container
     */
    public function bootstrap(ContainerInterface $container)
    {
        $controllerClass = Controller::class;
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper
            ->appendAsset($container->get(AdminAsset::class))
            ->addBackendRoute(['GET', '/admin/api/roles', [$controllerClass, 'actionList']])
            ->addBackendRoute(['GET', "/admin/api/roles/{id:\w+}", [$controllerClass, 'actionDetail']])
            ->addBackendRoute(['POST', "/admin/api/roles/{id:\w+}", [$controllerClass, 'actionSave']])
            ->addBackendRoute(['DELETE', "/admin/api/roles/{id:\w+}", [$controllerClass, 'actionDelete']])
            ->addVueRoute(['path' => '/roles/:id', 'component' => 'VuePageRolesDetail'], 800)
            ->addVueRoute(['path' => '/roles', 'component' => 'VuePageRolesList'], 810)
            ->addMenuSection('Система', 1000)
            ->addMenuItem('Система', 'Роли', '/roles', 105);
    }
}
