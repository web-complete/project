<?php

namespace cubes\ecommerce\checkout;

use cubes\ecommerce\interfaces\CheckoutInterface;
use WebComplete\core\utils\traits\TraitData;

class Checkout implements CheckoutInterface
{
    use TraitData;

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->mapToArray();
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->mapFromArray($data);
    }
}
