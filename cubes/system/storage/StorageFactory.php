<?php

namespace cubes\system\storage;

use WebComplete\core\factory\EntityFactory;

class StorageFactory extends EntityFactory
{
    protected $objectClass = StorageItem::class;
}
