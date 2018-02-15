<?php

namespace cubes\social\uLogin;

use cubes\social\uLogin\api\Controller;
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
        $cubeHelper->addBackendRoute(['POST', '/api/social-auth', [Controller::class, 'actionAuth']]);
    }
}
