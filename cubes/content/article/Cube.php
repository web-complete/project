<?php

namespace cubes\content\article;

use cubes\content\article\migrations\ArticleMigration;
use cubes\content\article\repository\ArticleRepositoryDb;
use cubes\content\article\repository\ArticleRepositoryInterface;
use cubes\content\article\repository\ArticleRepositoryMicro;
use cubes\content\article\repository\ArticleRepositoryMongo;
use modules\admin\classes\cube\CubeHelper;
use modules\admin\classes\cube\MigrationSelector;
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
        $entityConfig = $container->get(ArticleConfig::class);
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
        $definitions[ArticleRepositoryInterface::class] = RepositorySelector::get(
            ArticleRepositoryMicro::class,
            ArticleRepositoryDb::class,
            ArticleRepositoryMongo::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        $migrations = [
            'mysql' => ['001_001' => ArticleMigration::class]
        ];
        return MigrationSelector::get($migrations);
    }
}
