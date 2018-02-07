<?php

namespace cubes\ecommerce\interfaces;

interface OrderServiceInterface
{
    /**
     * @param CartInterface $cart
     * @param CheckoutInterface $checkout
     *
     * @return OrderInterface
     */
    public function createOrder(CartInterface $cart, CheckoutInterface $checkout): OrderInterface;
}
