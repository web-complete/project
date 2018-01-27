<?php

namespace cubes\seo\redirect;

use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;
use cubes\seo\redirect\migrations\RedirectMigration;
use modules\admin\classes\CubeHelper;

class Cube extends AbstractCube
{
    /**
     * @param ContainerInterface $container
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
        $definitions[RedirectRepositoryInterface::class] = \DI\object(RedirectRepositoryMicro::class);
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
