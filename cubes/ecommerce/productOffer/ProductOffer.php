<?php

namespace cubes\ecommerce\productOffer;

use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\utils\typecast\Cast;

/**
*
* @property $name
*/
class ProductOffer extends AbstractEntity
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [
            'product_id' => Cast::INT,
            'sku' => Cast::STRING,
            'name' => Cast::STRING,
            'price' => Cast::STRING,
            'properties' => Cast::ARRAY,
            'properties_multilang' => Cast::ARRAY,
        ];
    }
}
