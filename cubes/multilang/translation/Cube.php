<?php

namespace cubes\multilang\translation;

use cubes\multilang\translation\admin\TranslationController;
use modules\admin\classes\cube\RepositorySelector;
use modules\pub\assets\PubAsset;
use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;
use cubes\multilang\translation\migrations\TranslationMigration;
use modules\admin\classes\cube\CubeHelper;
use cubes\multilang\translation\assets\AdminAsset;
use cubes\multilang\translation\assets\PubAsset as MultilangPubAsset;

class Cube extends AbstractCube
{
    /**
     * @param ContainerInterface $container
     *
     * @throws \RuntimeException
     */
    public function bootstrap(ContainerInterface $container)
    {
        require 'functions.php';
        $entityConfig = $container->get(TranslationConfig::class);
        $name = $entityConfig->name;
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper
            ->defaultCrud($entityConfig)
            ->appendAsset($container->get(AdminAsset::class))
            ->addVueRoute(['path' => '/list/' . $name, 'component' => 'VuePageTranslationList'])
            ->addVueRoute(['path' => '/detail/' . $name . '/:id', 'component' => 'VuePageTranslationDetail'])
            ->addBackendRoute(['POST', '/admin/api/translation/create',
                [TranslationController::class, 'actionCreateTranslation']]);

        $container->get(PubAsset::class)->addAssetAfter($container->get(MultilangPubAsset::class));
    }

    /**
     * @param $definitions
     *
     * @return void
     */
    public function registerDependencies(array &$definitions)
    {
        $definitions[TranslationRepositoryInterface::class] = RepositorySelector::get(
            TranslationRepositoryMicro::class,
            TranslationRepositoryDb::class
        );
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
