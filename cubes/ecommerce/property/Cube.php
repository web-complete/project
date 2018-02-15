<?php

namespace cubes\ecommerce\property;

use cubes\ecommerce\property\admin\Controller;
use cubes\ecommerce\property\assets\AdminAsset;
use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;
use modules\admin\classes\cube\CubeHelper;

class Cube extends AbstractCube
{
    /**
     * @param ContainerInterface $container
     *
     * @throws \Exception
     */
    public function bootstrap(ContainerInterface $container)
    {
        $permission = 'admin:cubes:ecommerce-property';
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper->appendAsset($container->get(AdminAsset::class))
            ->addBackendRoute(['GET', '/admin/api/ecommerce-properties', [Controller::class, 'actionGetProperties']])
            ->addBackendRoute(['POST', '/admin/api/ecommerce-properties', [Controller::class, 'actionSaveProperties']])
            ->addVueRoute(['path' => '/ecommerce/property', 'component' => 'VuePageEcommerceProperty'])
            ->addPermission($permission, 'Товарные свойства')
            ->addMenuSection('Магазин', 120)
            ->addMenuItem('Магазин', 'Свойства', '/ecommerce/property', 110, $permission);
    }
}
