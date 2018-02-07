<?php

namespace cubes\ecommerce\cartItem;

use cubes\ecommerce\interfaces\CartItemInterface;
use cubes\ecommerce\interfaces\ProductOfferInterface;
use WebComplete\core\factory\EntityFactory;

class CartItemFactory extends EntityFactory
{
    protected $objectClass = CartItem::class;

    /**
     * @param ProductOfferInterface $productOffer
     *
     * @return CartItemInterface|CartItem
     */
    public function createFromProductOffer(ProductOfferInterface $productOffer): CartItemInterface
    {
        /** @var CartItem|CartItemInterface $item */
        $item = $this->create();
        $item->setProductOffer($productOffer);
        return $item;
    }
}
