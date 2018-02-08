<?php

namespace cubes\ecommerce\interfaces;

interface OrderInterface
{
    /**
     * @return int|string
     */
    public function getId();

    /**
     * @return string|int
     */
    public function getUserId();

    /**
     * @return CheckoutInterface
     */
    public function getCheckout(): CheckoutInterface;

    /**
     * @return OrderItemInterface[]
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
     * @return int
     */
    public function getStatus(): int;

    /**
     * @param int $status
     */
    public function setStatus(int $status);

    /**
     * @return mixed
     */
    public function getTotals();

    /**
     * @param $totals
     */
    public function setTotals($totals);
}
