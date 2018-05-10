<?php

namespace cubes\system\seo\redirect;

use cubes\system\seo\redirect\repository\RedirectRepositoryDb;
use cubes\system\seo\redirect\repository\RedirectRepositoryInterface;
use cubes\system\seo\redirect\repository\RedirectRepositoryMicro;
use cubes\system\seo\redirect\repository\RedirectRepositoryMongo;
use modules\admin\classes\cube\MigrationSelector;
use modules\admin\classes\cube\RepositorySelector;
use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;
use cubes\system\seo\redirect\migrations\RedirectMigration;
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
        $entityConfig = $container->get(RedirectConfig::class);
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper->defaultCrud($entityConfig);
        $frontControllerObserver = $container->get(FrontControllerObserver::class);
        $frontControllerObserver->listen();
    }

    /**
     * @param $definitions
     *
     * @return void
     */
    public function registerDependencies(array &$definitions)
    {
        $definitions[RedirectRepositoryInterface::class] = RepositorySelector::get(
            RedirectRepositoryMicro::class,
            RedirectRepositoryDb::class,
            RedirectRepositoryMongo::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        $migrations = [
            'mysql' => ['001_001' => RedirectMigration::class]
        ];
        return MigrationSelector::get($migrations);
    }
}
