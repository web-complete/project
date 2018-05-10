<?php

namespace cubes\ecommerce\productOffer;

use cubes\ecommerce\interfaces\ProductOfferInterface;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\utils\typecast\Cast;

/**
*
* @property $name
* @property $sku
* @property $product_id
* @property $price
*/
class ProductOffer extends AbstractEntity implements ProductOfferInterface
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

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
