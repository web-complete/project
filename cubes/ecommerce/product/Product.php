<?php

namespace cubes\ecommerce\product;

use cubes\ecommerce\interfaces\ProductOfferInterface;
use WebComplete\core\entity\AbstractEntity;

/**
*
* @property string $name
* @property string $category_id
* @property float $price
*/
class Product extends AbstractEntity implements ProductOfferInterface
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return ProductConfig::getFieldTypes();
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
