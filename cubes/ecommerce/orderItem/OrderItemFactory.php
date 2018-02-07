<?php

namespace cubes\ecommerce\orderItem;

use cubes\ecommerce\cartItem\CartItem;
use cubes\ecommerce\interfaces\OrderItemInterface;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\factory\EntityFactory;

class OrderItemFactory extends EntityFactory
{
    protected $objectClass = OrderItem::class;

    /**
     * @param CartItem $cartItem
     *
     * @return OrderItemInterface|OrderItem
     */
    public function createFromCartItem(CartItem $cartItem)
    {
        /** @var OrderItemInterface|OrderItem $item */
        $item = $this->create();
        $productData = [];
            /** @var AbstractEntity $productOffer */
        if ($productOffer = $cartItem->getProductOffer()) {
            $productData = $productOffer->mapToArray();
        }
        $item->set('sku', $item->getSku());
        $item->set('name', $item->getName());
        $item->set('price', $item->getPrice());
        $item->set('totals', $item->getTotals());
        $item->set('product_data', $productData);
        return $item;
    }
}
