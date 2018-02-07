<?php

namespace cubes\ecommerce\interfaces;

interface OrderItemInterface
{
    /**
     * @return int|string
     */
    public function getId();

    /**
     * @return OrderInterface
     */
    public function getOrder(): OrderInterface;

    /**
     * @return string
     */
    public function getSku(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return int
     */
    public function getQty(): int;

    /**
     * @return float
     */
    public function getPrice(): float;

    /**
     * @return array
     */
    public function getProductData(): array;

    /**
     * @return mixed
     */
    public function getTotals();
}
