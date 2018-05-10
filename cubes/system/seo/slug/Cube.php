<?php

namespace cubes\system\seo\slug;

use cubes\system\seo\slug\repository\SlugRepositoryDb;
use cubes\system\seo\slug\repository\SlugRepositoryInterface;
use cubes\system\seo\slug\repository\SlugRepositoryMicro;
use cubes\system\seo\slug\repository\SlugRepositoryMongo;
use modules\admin\classes\cube\MigrationSelector;
use modules\admin\classes\cube\RepositorySelector;
use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;
use cubes\system\seo\slug\migrations\SlugMigration;
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
        $entityConfig = $container->get(SlugConfig::class);
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
        $definitions[SlugRepositoryInterface::class] = RepositorySelector::get(
            SlugRepositoryMicro::class,
            SlugRepositoryDb::class,
            SlugRepositoryMongo::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        $migrations = [
            'mysql' => ['001_001' => SlugMigration::class]
        ];
        return MigrationSelector::get($migrations);
    }
}
