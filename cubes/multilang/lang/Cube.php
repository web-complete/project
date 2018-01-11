<?php

namespace cubes\multilang\lang;

use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;
use cubes\multilang\lang\migrations\LangMigration;
use modules\admin\classes\CubeHelper;

class Cube extends AbstractCube
{
    /**
     * @param ContainerInterface $container
     */
    public function bootstrap(ContainerInterface $container)
    {
        $entityConfig = $container->get(LangConfig::class);
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
        $definitions[LangRepositoryInterface::class] = \DI\object(LangRepositoryMicro::class);
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        return [
            '001_001' => LangMigration::class
        ];
    }
}
