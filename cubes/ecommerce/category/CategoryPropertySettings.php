<?php

namespace cubes\ecommerce\category;

use WebComplete\core\utils\traits\TraitData;
use WebComplete\core\utils\typecast\Cast;

/**
 *
 * @property array $enabled
 * @property array $for_main
 * @property array $for_list
 * @property array $for_filter
 */
class CategoryPropertySettings
{
    use TraitData;

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [
            'enabled' => Cast::ARRAY,
            'for_main' => Cast::ARRAY,
            'for_list' => Cast::ARRAY,
            'for_filter' => Cast::ARRAY,
        ];
    }
}
