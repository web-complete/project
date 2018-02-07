<?php

namespace cubes\ecommerce\interfaces;

interface CheckoutInterface
{
    /**
     * @return array
     */
    public function getData(): array;

    /**
     * @param array $data
     */
    public function setData(array $data);
}
