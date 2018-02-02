<?php

namespace cubes\content\staticPage;

use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;
use cubes\content\staticPage\migrations\StaticPageMigration;
use modules\admin\classes\cube\CubeHelper;
use modules\admin\classes\cube\RepositorySelector;

class Cube extends AbstractCube
{
    /**
     * @param ContainerInterface $container
     *
     * @throws \RuntimeException
     */
    public function bootstrap(ContainerInterface $container)
    {
        $entityConfig = $container->get(StaticPageConfig::class);
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
        $definitions[StaticPageRepositoryInterface::class] = RepositorySelector::get(
            StaticPageRepositoryMicro::class,
            StaticPageRepositoryDb::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        return [
            '001_001' => StaticPageMigration::class
        ];
    }
}
