<?php

namespace cubes\ecommerce\interfaces;

interface ProductOfferServiceInterface
{
    /**
     * @param string $sku
     *
     * @return ProductOfferInterface|null
     */
    public function findBySku(string $sku);
}
