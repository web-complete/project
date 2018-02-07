<?php

namespace cubes\ecommerce\interfaces;

interface CartInterface
{
    /**
     * @param ProductOfferInterface $productOffer
     *
     * @param int $qty
     *
     * @return CartItemInterface
     */
    public function addProductOffer(ProductOfferInterface $productOffer, int $qty = 1): CartItemInterface;

    /**
     * @return CartItemInterface[]
     */
    public function getItems(): array;

    /**
     * @param $id
     *
     * @return CartItemInterface|null
     */
    public function getItemById($id);

    /**
     * @param $sku
     *
     * @return CartItemInterface|null
     */
    public function getItemBySku($sku);

    /**
     * @param CartItemInterface $item
     */
    public function deleteItem(CartItemInterface $item);

    /**
     * @return mixed
     */
    public function getTotals();

    /**
     * @param $totals
     */
    public function setTotals($totals);
}
