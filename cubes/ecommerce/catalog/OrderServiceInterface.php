<?php

namespace cubes\ecommerce\catalog;

interface OrderServiceInterface
{
    /**
     * @param CartInterface $cart
     * @param CheckoutInterface $checkout
     *
     * @return OrderInterface
     */
    public function createOrder(CartInterface $cart, CheckoutInterface $checkout): OrderInterface;

    /**
     * @param $id
     *
     * @return OrderInterface[]
     */
    public function findOrdersByUserId($id): array;

    /**
     * @param $id
     *
     * @return OrderInterface|null
     */
    public function findOrderById($id);

    /**
     * @param OrderInterface $order
     */
    public function save(OrderInterface $order);
}
