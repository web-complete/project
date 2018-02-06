<?php

namespace cubes\ecommerce\catalog;

interface CartInterface
{
    /**
     * @param ProductOfferInterface $productOffer
     *
     * @return CartItemInterface
     */
    public function addProductOffer(ProductOfferInterface $productOffer): CartItemInterface;

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
