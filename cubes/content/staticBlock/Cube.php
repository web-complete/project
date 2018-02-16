<?php

namespace cubes\content\staticBlock;

use cubes\content\staticBlock\assets\AdminAsset;
use cubes\content\staticBlock\migrations\StaticBlockMigration;
use modules\admin\classes\cube\CubeHelper;
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
        $entityConfig = $container->get(StaticBlockConfig::class);
        $sysName = $entityConfig->getSystemName();
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper->appendAsset($container->get(AdminAsset::class));
        $cubeHelper->defaultCrud($entityConfig);
        $cubeHelper->addVueRoute(['path' => '/list/' . $sysName, 'component' => 'VuePageStaticBlockList']);
        $cubeHelper->addVueRoute(['path' => '/detail/' . $sysName . '/:id', 'component' => 'VuePageStaticBlockDetail']);
    }

    /**
     * @param $definitions
     *
     * @return void
     */
    public function registerDependencies(array &$definitions)
    {
        $definitions[StaticBlockRepositoryInterface::class] = RepositorySelector::get(
            StaticBlockRepositoryMicro::class,
            StaticBlockRepositoryDb::class
        );
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
