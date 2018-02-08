<?php

namespace cubes\ecommerce\checkout;

use cubes\ecommerce\interfaces\CheckoutInterface;
use WebComplete\core\utils\traits\TraitData;
use WebComplete\core\utils\typecast\Cast;

class Checkout implements CheckoutInterface
{
    use TraitData;

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [
            'first_name' => Cast::STRING,
            'last_name' => Cast::STRING,
            'email' => Cast::STRING,
        ];
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
