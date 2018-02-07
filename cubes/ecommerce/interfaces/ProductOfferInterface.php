<?php

namespace cubes\ecommerce\interfaces;

interface ProductOfferInterface
{
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
}
