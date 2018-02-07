<?php

namespace cubes\ecommerce\interfaces;

interface OrderInterface
{
    /**
     * @return string|int
     */
    public function getUserId();

    /**
     * @return CheckoutInterface
     */
    public function getCheckout(): CheckoutInterface;

    /**
     * @param CheckoutInterface $checkout
     */
    public function setCheckout(CheckoutInterface $checkout);

    /**
     * @return array
     */
    public function getItems(): array;

    /**
     * @param $id
     *
     * @return OrderItemInterface|null
     */
    public function getItemById($id);

    /**
     * @param $sku
     *
     * @return OrderItemInterface|null
     */
    public function getItemBySku($sku);

    /**
     * @param OrderItemInterface $item
     */
    public function addItem(OrderItemInterface $item);

    /**
     * @param OrderItemInterface $item
     */
    public function deleteItem(OrderItemInterface $item);

    /**
     * @return mixed
     */
    public function getStatus();

    /**
     * @param $status
     */
    public function setStatus($status);

    /**
     * @return mixed
     */
    public function getTotals();

    /**
     * @param $totals
     */
    public function setTotals($totals);
}
