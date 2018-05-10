<?php

namespace cubes\system\user;

use cubes\system\user\migrations\mongo\UserMongoMigration;
use cubes\system\user\migrations\mysql\UserMigration;
use cubes\system\user\repository\UserRepositoryDb;
use cubes\system\user\repository\UserRepositoryInterface;
use cubes\system\user\repository\UserRepositoryMicro;
use cubes\system\user\repository\UserRepositoryMongo;
use modules\admin\classes\cube\CubeHelper;
use modules\admin\classes\cube\MigrationSelector;
use modules\admin\classes\cube\RepositorySelector;
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
        $definitions[UserRepositoryInterface::class] = RepositorySelector::get(
            UserRepositoryMicro::class,
            UserRepositoryDb::class,
            UserRepositoryMongo::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        $migrations = [
            'mysql' => ['001_001' => UserMigration::class],
            'mongo' => ['001_001' => UserMongoMigration::class]
        ];
        return MigrationSelector::get($migrations);
    }
}
