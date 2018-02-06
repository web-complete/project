<?php

namespace cubes\ecommerce\catalog;

interface CartItemInterface
{
    /**
     * @return CartInterface
     */
    public function getCart(): CartInterface;

    /**
     * @return ProductOfferInterface|null
     */
    public function getProductOffer();

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
