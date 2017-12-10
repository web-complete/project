<?php

namespace cubes\system\file;

use WebComplete\core\entity\AbstractEntityRepositoryDb;

class FileRepositoryDb extends AbstractEntityRepositoryDb implements FileRepositoryInterface
{

    protected $table = 'file';
    protected $serializeFields = ['data'];
}
