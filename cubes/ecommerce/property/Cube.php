<?php

namespace cubes\ecommerce\property;

use cubes\ecommerce\property\admin\AdminAsset;
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
            ->addVueRoute(['path' => '/ecommerce/property', 'component' => 'VuePageEcommerceProperty'])
            ->addPermission($permission, 'Товарные свойства')
            ->addMenuSection('Магазин', 120)
            ->addMenuItem('Магазин', 'Свойства', '/ecommerce/property', 110, $permission);
    }
}
