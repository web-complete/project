<?php

namespace cubes\ecommerce\orderItem;

use cubes\ecommerce\interfaces\OrderInterface;
use cubes\ecommerce\interfaces\OrderItemInterface;
use cubes\ecommerce\order\Order;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\utils\typecast\Cast;

/**
*
* @property $order_id
*/
class OrderItem extends AbstractEntity implements OrderItemInterface
{
    /**
     * @var OrderInterface|Order
     */
    protected $order;

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [
            'order_id' => Cast::STRING,
            'product_data' => Cast::ARRAY,
            'sku' => Cast::STRING,
            'name' => Cast::STRING,
            'price' => Cast::FLOAT,
            'qty' => Cast::INT,
            'totals' => Cast::ARRAY
        ];
    }

    /**
     * @param OrderInterface|Order $order
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;
    }

    /**
     * @return OrderInterface
     */
    public function getOrder(): OrderInterface
    {
        return $this->order;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return (string)$this->get('sku');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return (string)$this->get('name');
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return (float)$this->get('price');
    }

    /**
     * @return int
     */
    public function getQty(): int
    {
        return (int)$this->get('qty');
    }

    /**
     * @return array
     */
    public function getProductData(): array
    {
        return (array)$this->get('product_data');
    }

    /**
     * @return mixed|array
     */
    public function getTotals()
    {
        return (array)$this->get('totals');
    }
}
