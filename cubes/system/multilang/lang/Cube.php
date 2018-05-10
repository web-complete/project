<?php

namespace cubes\system\multilang\lang;

use cubes\system\multilang\lang\assets\AdminAsset;
use cubes\system\multilang\lang\migrations\mongo\LangMongoMigration;
use cubes\system\multilang\lang\migrations\mysql\LangMigration;
use cubes\system\multilang\lang\repository\LangRepositoryDb;
use cubes\system\multilang\lang\repository\LangRepositoryInterface;
use cubes\system\multilang\lang\repository\LangRepositoryMicro;
use cubes\system\multilang\lang\repository\LangRepositoryMongo;
use modules\admin\classes\cube\MigrationSelector;
use modules\admin\classes\cube\RepositorySelector;
use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;
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
        $entityConfig = $container->get(LangConfig::class);
        $sysName = $entityConfig->getSystemName();
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper->appendAsset($container->get(AdminAsset::class));
        $cubeHelper->defaultCrud($entityConfig);
        $cubeHelper->addVueRoute(['path' => '/detail/' . $sysName . '/:id', 'component' => 'VuePageLangDetail']);
    }

    /**
     * @param $definitions
     *
     * @return void
     */
    public function registerDependencies(array &$definitions)
    {
        $definitions[LangRepositoryInterface::class] = RepositorySelector::get(
            LangRepositoryMicro::class,
            LangRepositoryDb::class,
            LangRepositoryMongo::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        $migrations = [
            'mysql' => ['001_001' => LangMigration::class],
            'mongo' => ['001_001' => LangMongoMigration::class]
        ];
        return MigrationSelector::get($migrations);
    }
}
