<?php

namespace cubes\content\staticBlock;

use cubes\content\staticBlock\migrations\StaticBlockMigration;
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
        $entityConfig = $container->get(StaticBlockConfig::class);
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
        $definitions[StaticBlockRepositoryInterface::class] = \DI\object(StaticBlockRepositoryMicro::class);
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        return [
            '001_001' => StaticBlockMigration::class
        ];
    }
}
