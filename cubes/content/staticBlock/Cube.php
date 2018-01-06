<?php

namespace cubes\content\staticBlock;

use cubes\content\staticBlock\assets\StaticBlockAsset;
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
        $name = $entityConfig->name;
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper->appendAsset($container->get(StaticBlockAsset::class));
        $cubeHelper->defaultCrud($entityConfig);
        $cubeHelper->addVueRoute(['path' => '/list/' . $name, 'component' => 'VuePageStaticBlockList']);
        $cubeHelper->addVueRoute(['path' => '/detail/' . $name . '/:id', 'component' => 'VuePageStaticBlockDetail']);
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
