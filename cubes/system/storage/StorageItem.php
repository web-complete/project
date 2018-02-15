<?php

namespace cubes\system\storage;

use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\utils\typecast\Cast;

/**
*
* @property $key
* @property $value
*/
class StorageItem extends AbstractEntity
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [
            'key' => Cast::STRING,
            'value' => Cast::STRING
        ];
    }
}
