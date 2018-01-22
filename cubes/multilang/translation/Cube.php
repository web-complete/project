<?php

namespace cubes\multilang\translation;

use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;
use cubes\multilang\translation\migrations\TranslationMigration;
use modules\admin\classes\CubeHelper;
use cubes\multilang\translation\assets\TranslationAsset;

class Cube extends AbstractCube
{
    /**
     * @param ContainerInterface $container
     */
    public function bootstrap(ContainerInterface $container)
    {
        $entityConfig = $container->get(TranslationConfig::class);
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper->defaultCrud($entityConfig);

        $name = $entityConfig->name;
        $cubeHelper->appendAsset($container->get(TranslationAsset::class));
        $cubeHelper->addVueRoute(['path' => '/list/' . $name, 'component' => 'VuePageTranslationList']);
        $cubeHelper->addVueRoute(['path' => '/detail/' . $name . '/:id', 'component' => 'VuePageTranslationDetail']);
    }

    /**
     * @param $definitions
     *
     * @return void
     */
    public function registerDependencies(array &$definitions)
    {
        $definitions[TranslationRepositoryInterface::class] = \DI\object(TranslationRepositoryMicro::class);
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        return [
            '001_001' => TranslationMigration::class
        ];
    }
}
