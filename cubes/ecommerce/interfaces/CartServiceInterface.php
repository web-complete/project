<?php

namespace cubes\ecommerce\interfaces;

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
}
