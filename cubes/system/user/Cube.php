<?php

namespace cubes\system\user;

use cubes\system\user\controllers\UserController;
use cubes\system\user\migrations\UserMigration;
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
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper
            ->addBackendRoute(['POST', '/admin/api/entity/user/:id', [UserController::class, 'actionSave']])
            ->addBackendRoute(['GET', '/admin/api/entity/user/:id', [UserController::class, 'actionDetail']])
            ->addBackendRoute(['GET', '/admin/api/entity/user', [UserController::class, 'actionList']])
            ->addMenuSection('Система', 900)
            ->addMenuItem('Система', 'Пользователи', '/list/user', 110);
    }

    /**
     * @param $definitions
     *
     * @return void
     */
    public function registerDependencies(array &$definitions)
    {
        $definitions[UserRepositoryInterface::class] = \DI\object(UserRepositoryMicro::class);
    }

    public function getMigrations(): array
    {
        return [
            '001_001' => UserMigration::class
        ];
    }
}
