<?php

namespace cubes\system\seo\meta;

use cubes\system\seo\meta\repository\MetaRepositoryDb;
use cubes\system\seo\meta\repository\MetaRepositoryInterface;
use cubes\system\seo\meta\repository\MetaRepositoryMicro;
use cubes\system\seo\meta\repository\MetaRepositoryMongo;
use modules\admin\classes\cube\MigrationSelector;
use modules\admin\classes\cube\RepositorySelector;
use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;
use cubes\system\seo\meta\migrations\MetaMigration;
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
        $entityConfig = $container->get(MetaConfig::class);
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
        $definitions[MetaRepositoryInterface::class] = RepositorySelector::get(
            MetaRepositoryMicro::class,
            MetaRepositoryDb::class,
            MetaRepositoryMongo::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        $migrations = [
            'mysql' => ['001_001' => MetaMigration::class]
        ];
        return MigrationSelector::get($migrations);
    }
}
