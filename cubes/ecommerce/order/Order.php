<?php

namespace cubes\ecommerce\order;

use cubes\ecommerce\interfaces\CheckoutInterface;
use cubes\ecommerce\interfaces\OrderInterface;
use cubes\ecommerce\interfaces\OrderItemInterface;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\utils\typecast\Cast;

/**
*
* @property $user_id
*/
class Order extends AbstractEntity implements OrderInterface
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [
            'user_id' => Cast::STRING,
            'checkout_data' => Cast::ARRAY,
        ];
    }

    public function __construct() { }

    /**
     * @return string|int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return CheckoutInterface
     */
    public function getCheckout(): CheckoutInterface
    {
        // TODO: Implement getCheckout() method.
    }

    /**
     * @param CheckoutInterface $checkout
     */
    public function setCheckout(CheckoutInterface $checkout)
    {
        // TODO: Implement setCheckout() method.
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        // TODO: Implement getItems() method.
    }

    /**
     * @param $id
     *
     * @return OrderItemInterface|null
     */
    public function getItemById($id)
    {
        // TODO: Implement getItemById() method.
    }

    /**
     * @param $sku
     *
     * @return OrderItemInterface|null
     */
    public function getItemBySku($sku)
    {
        // TODO: Implement getItemBySku() method.
    }

    /**
     * @param OrderItemInterface $item
     */
    public function addItem(OrderItemInterface $item)
    {
        // TODO: Implement addItem() method.
    }

    /**
     * @param OrderItemInterface $item
     */
    public function deleteItem(OrderItemInterface $item)
    {
        // TODO: Implement deleteItem() method.
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        // TODO: Implement getStatus() method.
    }

    /**
     * @param $status
     */
    public function setStatus($status)
    {
        // TODO: Implement setStatus() method.
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
