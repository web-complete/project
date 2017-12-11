<?php

namespace cubes\system\file;

use cubes\system\file\controllers\FileController;
use cubes\system\file\migrations\FileMigration;
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
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper
            ->addBackendRoute(['POST', '/admin/api/upload-file', [FileController::class, 'actionUploadFile']])
            ->addBackendRoute(['POST', '/admin/api/upload-image', [FileController::class, 'actionUploadImage']])
            ->addBackendRoute(['POST', '/admin/api/delete-file', [FileController::class, 'actionDeleteFile']])
            ->addBackendRoute(['POST', '/admin/api/update-image', [FileController::class, 'actionUpdateImage']]);
    }

    /**
     * @param $definitions
     *
     * @return void
     */
    public function registerDependencies(array &$definitions)
    {
        $definitions[FileRepositoryInterface::class] = \DI\object(FileRepositoryMicro::class);
    }

    public function getMigrations(): array
    {
        return [
            '001_001' => FileMigration::class
        ];
    }
}