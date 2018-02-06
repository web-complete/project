<?php

namespace cubes\ecommerce\catalog;

interface CartServiceInterface
{
    /**
     * @param $id
     *
     * @return CartInterface|null
     */
    public function findByUserId($id);

    /**
     * @param string $hash
     *
     * @return CartInterface|null
     */
    public function findByHash(string $hash);

    /**
     * @param CartInterface $cart
     */
    public function save(CartInterface $cart);

    /**
     * @param CartInterface $cart
     */
    public function delete(CartInterface $cart);

    /**
     * @param CartInterface $cartTo
     * @param CartInterface $cartFrom
     * @param bool $deleteCartFrom
     */
    public function merge(CartInterface $cartTo, CartInterface $cartFrom, bool $deleteCartFrom = true);
}
