<?php

namespace cubes\system\file;

use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\utils\typecast\Cast;

/**
 * @property string $code
 * @property string $file_name
 * @property string $mime_type
 * @property string $base_dir
 * @property string $url
 * @property int $sort
 * @property array $data
 */
class File extends AbstractEntity
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [
            'code' => Cast::STRING,
            'file_name' => Cast::STRING,
            'mime_type' => Cast::STRING,
            'base_dir' => Cast::STRING,
            'url' => Cast::STRING,
            'sort' => Cast::INT,
            'data' => Cast::ARRAY,
        ];
    }
}
