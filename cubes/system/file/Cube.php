<?php

namespace cubes\system\file;

use cubes\system\file\admin\Controller;
use cubes\system\file\migrations\FileMigration;
use modules\admin\classes\cube\CubeHelper;
use modules\admin\classes\cube\RepositorySelector;
use WebComplete\core\cube\AbstractCube;
use WebComplete\core\utils\container\ContainerInterface;

class Cube extends AbstractCube
{

    /**
     * @param ContainerInterface $container
     */
    public function bootstrap(ContainerInterface $container)
    {
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper
            ->addBackendRoute(['POST', '/admin/api/upload-file', [Controller::class, 'actionUploadFile']])
            ->addBackendRoute(['POST', '/admin/api/delete-file', [Controller::class, 'actionDeleteFile']])
            ->addBackendRoute(['POST', '/admin/api/update-image', [Controller::class, 'actionUpdateImage']]);
    }

    /**
     * @param $definitions
     *
     * @return void
     */
    public function registerDependencies(array &$definitions)
    {
        $definitions[FileRepositoryInterface::class] = RepositorySelector::get(
            FileRepositoryMicro::class,
            FileRepositoryDb::class
        );
    }

    /**
     * @return array
     */
    public function getMigrations(): array
    {
        return [
            '001_001' => FileMigration::class
        ];
    }
}
