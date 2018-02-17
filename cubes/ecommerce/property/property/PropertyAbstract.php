<?php

namespace cubes\ecommerce\property\property;

use WebComplete\core\utils\traits\TraitData;
use WebComplete\core\utils\typecast\Cast;

/**
 *
 * @property $uid
 * @property $code
 * @property $name
 * @property $type
 * @property $sort
 * @property $global
 * @property $enabled
 * @property array $data
 */
abstract class PropertyAbstract
{
    use TraitData;

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [
            'uid' => Cast::STRING,
            'code' => Cast::STRING,
            'name' => Cast::STRING,
            'type' => Cast::STRING,
            'sort' => Cast::INT,
            'global' => Cast::INT,
            'enabled' => Cast::INT,
            'data' => Cast::ARRAY,
        ];
    }

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->mapFromArray($data);
    }
}
