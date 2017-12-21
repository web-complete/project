<?php

namespace cubes\system\tags;

use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\utils\typecast\Cast;

/**
 *
 * @property string $name
 * @property string $slug
 * @property string $namespace
 * @property array $ids
 */
class Tag extends AbstractEntity
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [
            'name' => Cast::STRING,
            'slug' => Cast::STRING,
            'namespace' => Cast::STRING,
            'ids' => Cast::ARRAY,
        ];
    }
}