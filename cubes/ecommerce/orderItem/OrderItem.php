<?php

namespace cubes\ecommerce\orderItem;

use cubes\ecommerce\interfaces\OrderInterface;
use cubes\ecommerce\interfaces\OrderItemInterface;
use WebComplete\core\entity\AbstractEntity;

/**
*
* @property $name
*/
class OrderItem extends AbstractEntity implements OrderItemInterface
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [];
    }

    /**
     * @return OrderInterface
     */
    public function getOrder(): OrderInterface
    {
        // TODO: Implement getOrder() method.
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        // TODO: Implement getSku() method.
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        // TODO: Implement getName() method.
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        // TODO: Implement getPrice() method.
    }

    /**
     * @return mixed
     */
    public function getTotals()
    {
        // TODO: Implement getTotals() method.
    }

    /**
     * @param $totals
     */
    public function setTotals($totals)
    {
        // TODO: Implement setTotals() method.
    }
}
