<?php

namespace cubes\ecommerce\cart;

use cubes\ecommerce\cartItem\CartItem;
use cubes\ecommerce\cartItem\CartItemFactory;
use cubes\ecommerce\interfaces\CartInterface;
use cubes\ecommerce\interfaces\CartItemInterface;
use cubes\ecommerce\interfaces\ProductOfferInterface;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\utils\typecast\Cast;

/**
*
* @property $user_id
* @property $hash
*/
class Cart extends AbstractEntity implements CartInterface
{

    /**
     * @var CartItemInterface[]
     */
    protected $items = [];
    /**
     * @var CartItemInterface[]
     */
    protected $deleted = [];
    /**
     * @var CartItemFactory
     */
    protected $cartItemFactory;
    protected $totals = [];

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [
            'user_id' => Cast::STRING,
            'hash' => Cast::STRING,
        ];
    }

    /**
     * @param CartItemFactory $cartItemFactory
     */
    public function __construct(CartItemFactory $cartItemFactory)
    {
        $this->cartItemFactory = $cartItemFactory;
    }

    /**
     * @return string|int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param ProductOfferInterface $productOffer
     * @param int $qty
     *
     * @return CartItemInterface
     */
    public function addProductOffer(ProductOfferInterface $productOffer, int $qty = 1): CartItemInterface
    {
        $item = $this->cartItemFactory->createFromProductOffer($productOffer);
        $item->setCart($this);
        $item->setQty($qty);
        $this->items[] = $item;
        return $item;
    }

    /**
     * @return CartItemInterface[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param CartItemInterface[]|CartItem[] $items
     */
    public function setItems(array $items)
    {
        $this->items = $items;
        foreach ($items as $item) {
            $item->setCart($this);
        }
    }

    /**
     * @param $id
     *
     * @return CartItemInterface|null
     */
    public function getItemById($id)
    {
        foreach ($this->items as $item) {
            if ((string)$item->getId() === (string)$id) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @param $sku
     *
     * @return CartItemInterface|null
     */
    public function getItemBySku($sku)
    {
        foreach ($this->items as $item) {
            if (($productOffer = $item->getProductOffer()) && (string)$productOffer->getSku() === (string)$sku) {
                return $item;
            }
        }
        return null;
    }

    /**
     * @param CartItemInterface $item
     */
    public function deleteItem(CartItemInterface $item)
    {
        $id = (string)$item->getId();
        foreach ($this->items as $k => $cartItem) {
            if ((string)$cartItem->getId() === $id) {
                $this->deleted[] = $cartItem;
                unset($this->items[$k]);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getTotals()
    {
        return (array)$this->totals;
    }

    /**
     * @param $totals
     */
    public function setTotals($totals)
    {
        $this->totals = $totals ? (array)$totals : [];
    }

    /**
     * @param bool $clear
     *
     * @return CartItemInterface[]
     */
    public function getDeletedItems(bool $clear = true): array
    {
        $deleted = $this->deleted;
        if ($clear) {
            $this->deleted = [];
        }
        return $deleted;
    }
}
