<?php

namespace cubes\system\multilang\translation;

use cubes\system\multilang\translation\admin\TranslationController;
use cubes\system\multilang\translation\repository\TranslationRepositoryDb;
use cubes\system\multilang\translation\repository\TranslationRepositoryInterface;
use cubes\system\multilang\translation\repository\TranslationRepositoryMicro;
use cubes\system\multilang\translation\repository\TranslationRepositoryMongo;
use modules\admin\classes\cube\MigrationSelector;
use modules\admin\classes\cube\RepositorySelector;
use modules\pub\assets\PubAsset;
use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;
use cubes\system\multilang\translation\migrations\TranslationMigration;
use modules\admin\classes\cube\CubeHelper;
use cubes\system\multilang\translation\assets\PubAsset as MultilangPubAsset;

class Cube extends AbstractCube
{
    /**
     * @param ContainerInterface $container
     *
     * @throws \Exception
     */
    public function bootstrap(ContainerInterface $container)
    {
        require 'functions.php';
        $entityConfig = $container->get(TranslationConfig::class);
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper
            ->defaultCrud($entityConfig)
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
            TranslationRepositoryDb::class,
            TranslationRepositoryMongo::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        $migrations = [
            'mysql' => ['001_001' => TranslationMigration::class]
        ];
        return MigrationSelector::get($migrations);
    }
}
