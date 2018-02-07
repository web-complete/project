<?php

namespace cubes\ecommerce\interfaces;

interface OrderItemInterface
{
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
     * @return float
     */
    public function getPrice(): float;

    /**
     * @return mixed
     */
    public function getTotals();

    /**
     * @param $totals
     */
    public function setTotals($totals);
}
