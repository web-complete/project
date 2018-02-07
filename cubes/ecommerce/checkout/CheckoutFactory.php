<?php

namespace cubes\ecommerce\checkout;

use cubes\ecommerce\interfaces\CheckoutInterface;
use WebComplete\core\factory\AbstractFactory;

class CheckoutFactory extends AbstractFactory
{
    /**
     * @return Checkout|CheckoutInterface
     */
    public function create(): Checkout
    {
        return $this->make(Checkout::class);
    }
}
