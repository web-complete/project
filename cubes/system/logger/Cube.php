<?php 

namespace cubes\system\logger;

use cubes\system\logger\controllers\Controller;
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
        $cubeHelper->addBackendRoute(['POST', '/api/log', [Controller::class, 'actionLog']]);
    }
}
