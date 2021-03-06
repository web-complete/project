<?php

namespace cubes\ecommerce\order;

use cubes\ecommerce\checkout\CheckoutFactory;
use cubes\ecommerce\interfaces\CheckoutInterface;
use cubes\ecommerce\interfaces\OrderInterface;
use cubes\ecommerce\interfaces\OrderItemInterface;
use cubes\ecommerce\orderItem\OrderItem;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\utils\typecast\Cast;

/**
*
* @property $user_id
*/
class Order extends AbstractEntity implements OrderInterface
{
    /**
     * @var OrderItemInterface[]
     */
    protected $items = [];
    /**
     * @var OrderItemInterface[]
     */
    protected $deleted = [];
    /**
     * @var CheckoutFactory
     */
    protected $checkoutFactory;
    /**
     * @var CheckoutInterface
     */
    protected $checkout;

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [
            'user_id' => Cast::INT,
            'checkout_data' => Cast::ARRAY,
            'status' => Cast::INT,
            'totals' => Cast::ARRAY,
        ];
    }

    /**
     * @param CheckoutFactory $checkoutFactory
     */
    public function __construct(CheckoutFactory $checkoutFactory)
    {
        $this->checkoutFactory = $checkoutFactory;
    }

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
        if (!$this->checkout) {
            $this->checkout = $this->checkoutFactory->create();
            $this->checkout->setData((array)$this->get('checkout_data'));
        }
        return $this->checkout;
    }

    /**
     * @return OrderItemInterface[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param OrderItemInterface[]|OrderItem[] $items
     * @throws \RuntimeException
     */
    public function setItems(array $items)
    {
        $this->items = $items;
        foreach ($items as $item) {
            if (!$item->getId()) {
                throw new \RuntimeException('Item without id');
            }
            $item->setOrder($this);
        }
    }

    /**
     * @param $id
     *
     * @return OrderItemInterface|null
     */
    public function getItemById($id)
    {
        foreach ($this->getItems() as $item) {
            if ((string)$item->getId() === (string)$id) {
                return $item;
            }
        }
        return null;
    }

    /**
     * @param $sku
     *
     * @return OrderItemInterface|null
     */
    public function getItemBySku($sku)
    {
        foreach ($this->getItems() as $item) {
            if ($item->getSku() === (string)$sku) {
                return $item;
            }
        }
        return null;
    }

    /**
     * @param OrderItemInterface $item
     * @throws \RuntimeException
     */
    public function addItem(OrderItemInterface $item)
    {
        if (!$item->getId()) {
            throw new \RuntimeException('Item without id');
        }
        $this->items[] = $item;
    }

    /**
     * @param OrderItemInterface $item
     */
    public function deleteItem(OrderItemInterface $item)
    {
        $id = (string)$item->getId();
        foreach ($this->items as $k => $orderItem) {
            if ((string)$orderItem->getId() === $id) {
                $this->deleted[] = $orderItem;
                unset($this->items[$k]);
            }
        }
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return (int)$this->get('status');
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status)
    {
        $this->set('status', $status);
    }

    /**
     * @return mixed
     */
    public function getTotals()
    {
        return $this->get('totals');
    }

    /**
     * @param $totals
     */
    public function setTotals($totals)
    {
        $this->set('totals', $totals);
    }

    /**
     * @param bool $clear
     *
     * @return OrderItemInterface[]
     */
    public function getDeletedItems(bool $clear = true): array
    {
        $deleted = $this->deleted;
        if ($clear) {
            $this->deleted = [];
        }
        return $deleted;
    }

    /**
     * @return array
     */
    public function mapToArray(): array
    {
        $this->set('checkout_data', $this->getCheckout()->getData());
        return parent::mapToArray();
    }
}
