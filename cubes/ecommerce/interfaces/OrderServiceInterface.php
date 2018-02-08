<?php

namespace cubes\ecommerce\interfaces;

interface OrderServiceInterface
{
    /**
     * @param CartInterface $cart
     *
     * @return OrderInterface
     */
    public function createOrder(CartInterface $cart): OrderInterface;
}
