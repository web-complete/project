<?php

namespace cubes\system\user;

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
        $entityConfig = $container->get(UserConfig::class);
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper->defaultCrud($entityConfig);
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
