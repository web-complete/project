<?php

namespace cubes\system\seo\redirect;

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
            RedirectRepositoryDb::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        return [
            '001_001' => RedirectMigration::class
        ];
    }
}
