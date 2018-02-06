<?php

namespace cubes\ecommerce\catalog;

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
