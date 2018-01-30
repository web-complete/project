<?php

namespace cubes\multilang\lang;

use cubes\multilang\lang\assets\AdminAsset;
use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;
use cubes\multilang\lang\migrations\LangMigration;
use modules\admin\classes\CubeHelper;

class Cube extends AbstractCube
{
    /**
     * @param ContainerInterface $container
     *
     * @throws \RuntimeException
     */
    public function bootstrap(ContainerInterface $container)
    {
        $entityConfig = $container->get(LangConfig::class);
        $name = $entityConfig->name;
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper->appendAsset($container->get(AdminAsset::class));
        $cubeHelper->defaultCrud($entityConfig);
        $cubeHelper->addVueRoute(['path' => '/detail/' . $name . '/:id', 'component' => 'VuePageLangDetail']);
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
