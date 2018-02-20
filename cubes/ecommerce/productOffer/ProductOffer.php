<?php

namespace cubes\ecommerce\productOffer;

use cubes\ecommerce\interfaces\ProductOfferInterface;
use cubes\ecommerce\product\ProductAbstract;
use WebComplete\core\utils\typecast\Cast;

/**
 *
 * @property string $product_id
 */
class ProductOffer extends ProductAbstract implements ProductOfferInterface
{
    /**
     * @return array
     */
    public static function fields(): array
    {
        return \array_merge(parent::fields(), [
            'product_id' => Cast::INT,
        ]);
    }
}
