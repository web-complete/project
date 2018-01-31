<?php

namespace cubes\ecommerce\classifier;

use cubes\ecommerce\classifier\admin\Controller;
use cubes\ecommerce\classifier\assets\AdminAsset;
use modules\admin\classes\cube\CubeHelper;
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
        $cubeHelper->appendAsset($container->get(AdminAsset::class))
            ->addBackendRoute(['GET', '/admin/api/classifier/get', [Controller::class, 'actionGet']])
            ->addVueRoute(['path' => '/ecommerce/classifier', 'component' => 'VuePageClassifier'])
            ->addMenuSection('Магазин', 120)
            ->addMenuItem('Магазин', 'Классификатор', '/ecommerce/classifier', 100);
    }
}
