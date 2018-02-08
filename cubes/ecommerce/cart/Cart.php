<?php

namespace cubes\ecommerce\cart;

use cubes\ecommerce\cartItem\CartItem;
use cubes\ecommerce\cartItem\CartItemFactory;
use cubes\ecommerce\checkout\Checkout;
use cubes\ecommerce\checkout\CheckoutFactory;
use cubes\ecommerce\interfaces\CartInterface;
use cubes\ecommerce\interfaces\CartItemInterface;
use cubes\ecommerce\interfaces\CheckoutInterface;
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
    /**
     * @var CheckoutFactory
     */
    protected $checkoutFactory;
    /**
     * @var CheckoutInterface
     */
    protected $checkout;
    protected $totals = [];

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [
            'user_id' => Cast::STRING,
            'hash' => Cast::STRING,
            'checkout_data' => Cast::ARRAY,
            'totals' => Cast::ARRAY,
        ];
    }

    /**
     * @param CartItemFactory $cartItemFactory
     * @param CheckoutFactory $checkoutFactory
     */
    public function __construct(CartItemFactory $cartItemFactory, CheckoutFactory $checkoutFactory)
    {
        $this->cartItemFactory = $cartItemFactory;
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
     * @return CheckoutInterface|Checkout
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
     * @throws \RuntimeException
     */
    public function setItems(array $items)
    {
        $this->items = $items;
        foreach ($items as $item) {
            if (!$item->getId()) {
                throw new \RuntimeException('Item without id');
            }
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

    /**
     * @return array
     */
    public function mapToArray(): array
    {
        $this->set('checkout_data', $this->getCheckout()->getData());
        return parent::mapToArray();
    }
}
