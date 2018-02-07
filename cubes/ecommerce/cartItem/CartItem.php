<?php

namespace cubes\ecommerce\cartItem;

use cubes\ecommerce\cart\Cart;
use cubes\ecommerce\interfaces\CartInterface;
use cubes\ecommerce\interfaces\CartItemInterface;
use cubes\ecommerce\interfaces\ProductOfferInterface;
use cubes\ecommerce\interfaces\ProductOfferServiceInterface;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\utils\typecast\Cast;

/**
*
* @property string $cart_id
*/
class CartItem extends AbstractEntity implements CartItemInterface
{

    /**
     * @var CartInterface|Cart
     */
    protected $cart;
    /**
     * @var ProductOfferServiceInterface
     */
    protected $productOfferService;
    /**
     * @var ProductOfferInterface
     */
    protected $productOffer;
    /**
     * @var array
     */
    protected $totals = [];

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [
            'cart_id' => Cast::STRING,
            'sku' => Cast::STRING,
            'name' => Cast::STRING,
            'price' => Cast::FLOAT,
            'qty' => Cast::INT,
        ];
    }

    /**
     * @param ProductOfferServiceInterface $productOfferService
     */
    public function __construct(ProductOfferServiceInterface $productOfferService)
    {
        $this->productOfferService = $productOfferService;
    }

    /**
     * @param CartInterface|Cart $cart
     */
    public function setCart(CartInterface $cart)
    {
        $this->cart = $cart;
        $this->cart_id = $cart->getId();
    }

    /**
     * @return CartInterface|Cart
     */
    public function getCart(): CartInterface
    {
        return $this->cart;
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
     * @return ProductOfferInterface|null
     */
    public function getProductOffer()
    {
        if (!$this->productOffer && ($productOffer = $this->productOfferService->findBySku($this->getSku()))) {
            $this->setProductOffer($productOffer);
        }
        return $this->productOffer;
    }

    /**
     * @param ProductOfferInterface $productOffer
     */
    public function setProductOffer(ProductOfferInterface $productOffer)
    {
        $this->set('sku', $productOffer->getSku());
        $this->set('name', $productOffer->getName());
        $this->set('price', $productOffer->getPrice());
        $this->productOffer = $productOffer;
    }

    /**
     * @return int
     */
    public function getQty(): int
    {
        return (int)$this->get('qty');
    }

    /**
     * @param int $qty
     */
    public function setQty(int $qty)
    {
        $this->set('qty', $qty);
    }

    /**
     * @return mixed
     */
    public function getTotals()
    {
        return $this->totals;
    }

    /**
     * @param $totals
     */
    public function setTotals($totals)
    {
        $this->totals = $totals;
    }
}
