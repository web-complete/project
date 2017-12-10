<?php

namespace cubes\system\file;

use WebComplete\core\entity\AbstractEntityRepositoryMicro;

class FileRepositoryMicro extends AbstractEntityRepositoryMicro implements FileRepositoryInterface
{
    protected $collectionName = 'file';
}
