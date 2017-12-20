<?php

namespace cubes\content\article;

use cubes\content\article\migrations\ArticleMigration;
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
        $definitions[ArticleRepositoryInterface::class] = \DI\object(ArticleRepositoryMicro::class);
    }

    public function getMigrations(): array
    {
        return [
            '001_001' => ArticleMigration::class
        ];
    }
}
