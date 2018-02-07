<?php

namespace cubes\ecommerce\product;

use cubes\ecommerce\interfaces\ProductOfferInterface;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\utils\typecast\Cast;

/**
*
* @property string $name
* @property float $price
*/
class Product extends AbstractEntity implements ProductOfferInterface
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [
            'name' => Cast::STRING,
            'price' => Cast::FLOAT,
        ];
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return (string)$this->getId();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return (string)$this->name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return (float)$this->price;
    }
}
