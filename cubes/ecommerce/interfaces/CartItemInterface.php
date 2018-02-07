<?php

namespace cubes\ecommerce\interfaces;

interface CartItemInterface
{

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return CartInterface
     */
    public function getCart(): CartInterface;

    /**
     * @return ProductOfferInterface|null
     */
    public function getProductOffer();

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
     * @return int
     */
    public function getQty(): int;

    /**
     * @param int $qty
     */
    public function setQty(int $qty);

    /**
     * @return mixed
     */
    public function getTotals();

    /**
     * @param $totals
     */
    public function setTotals($totals);
}
