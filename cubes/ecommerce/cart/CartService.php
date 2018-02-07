<?php

namespace cubes\ecommerce\cart;

use cubes\ecommerce\cartItem\CartItem;
use cubes\ecommerce\cartItem\CartItemService;
use cubes\ecommerce\interfaces\CartInterface;
use cubes\ecommerce\interfaces\CartItemInterface;
use cubes\ecommerce\interfaces\CartServiceInterface;
use WebComplete\core\condition\Condition;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;

/**
 * @method CartInterface|Cart create
 */
class CartService extends AbstractEntityService implements CartRepositoryInterface, CartServiceInterface
{

    /**
     * @var CartRepositoryInterface
     */
    protected $repository;
    /**
     * @var CartHelper
     */
    protected $cartHelper;
    /**
     * @var CartItemService
     */
    protected $cartItemService;
    /**
     * @var Cart|CartInterface
     */
    protected $currentUserCart;

    /**
     * @param CartRepositoryInterface $repository
     * @param CartHelper $cartHelper
     * @param CartItemService $cartItemService
     */
    public function __construct(
        CartRepositoryInterface $repository,
        CartHelper $cartHelper,
        CartItemService $cartItemService
    ) {
        parent::__construct($repository);
        $this->cartHelper = $cartHelper;
        $this->cartItemService = $cartItemService;
    }

    /**
     * @return Cart|CartInterface
     */
    public function current()
    {
        if (!$this->currentUserCart) {
            $this->currentUserCart = $this->findOrCreateCurrentCart();
        }
        return $this->currentUserCart;
    }

    /**
     * @param $id
     *
     * @return null|AbstractEntity|Cart|CartInterface
     */
    public function findById($id)
    {
        if ($cart = parent::findById($id)) {
            $this->loadCartItems($cart);
        }
        return $cart;
    }

    /**
     * @param Condition $condition
     *
     * @return null|AbstractEntity|Cart|CartInterface
     */
    public function findOne(Condition $condition)
    {
        if ($cart = parent::findOne($condition)) {
            $this->loadCartItems($cart);
        }
        return $cart;
    }

    /**
     * @param $id
     *
     * @return CartInterface|Cart|AbstractEntity|null
     */
    public function findByUserId($id)
    {
        $condition = $this->createCondition(['user_id' => $id]);
        return $this->findOne($condition);
    }

    /**
     * @param string $hash
     *
     * @return CartInterface|Cart|AbstractEntity|null
     */
    public function findByHash(string $hash)
    {
        $condition = $this->createCondition(['hash' => $hash]);
        return $this->findOne($condition);
    }

    /**
     * @param AbstractEntity|CartInterface|Cart $cart
     * @param array $oldData
     */
    public function save(AbstractEntity $cart, array $oldData = [])
    {
        parent::save($cart, $oldData);
        $this->saveCartItems($cart);
    }

    /**
     * @param Cart|AbstractEntity $cart
     */
    public function loadCartItems(Cart $cart)
    {
        $condition = $this->cartItemService->createCondition(['cart_id' => $cart->getId()]);
        $items = $this->cartItemService->findAll($condition);
        $cart->setItems(\array_values($items));
    }

    /**
     * @param Cart $cart
     */
    protected function saveCartItems(Cart $cart)
    {
        /** @var AbstractEntity|CartItemInterface|CartItem $cartItem */
        foreach ($cart->getItems() as $cartItem) {
            $cartItem->cart_id = $cartItem->getCart()->getId();
            $this->cartItemService->save($cartItem);
        }

        foreach ($cart->getDeletedItems() as $deletedItem) {
            $this->cartItemService->delete($deletedItem->getId(), $deletedItem);
        }
    }

    /**
     * @return Cart|CartInterface|null|AbstractEntity
     */
    protected function findOrCreateCurrentCart(): Cart
    {
        $hash = $this->cartHelper->currentHash();
        $hashCart = $this->findByHash($hash);

        $userCart = null;
        if ($userId = $this->cartHelper->currentUserId()) {
            if (!$userCart = $this->findByUserId($userId)) {
                /** @var Cart|CartInterface $userCart */
                $userCart = $this->create();
                $userCart->user_id = $userId;
                $this->save($userCart);
            }
            if ($hashCart) {
                $this->merge($userCart, $hashCart, true);
            }
        }

        if (!$userId && !$hashCart) {
            /** @var Cart|CartInterface $hashCart */
            $hashCart = $this->create();
            $hashCart->hash = $hash;
            $this->save($hashCart);
        }

        return $userCart ?: $hashCart;
    }

    /**
     * @param Cart|CartInterface $cartTo
     * @param Cart|CartInterface $cartFrom
     * @param bool $deleteCartFrom
     */
    protected function merge(Cart $cartTo, Cart $cartFrom, bool $deleteCartFrom)
    {
        $hasChanges = false;
        foreach ($cartFrom->getItems() as $item) {
            if (($productOffer = $item->getProductOffer()) && !$cartTo->getItemBySku($productOffer->getSku())) {
                $cartTo->addProductOffer($productOffer, $item->getQty());
                $hasChanges = true;
            }
        }

        if ($hasChanges) {
            $this->save($cartTo);
        }

        if ($deleteCartFrom) {
            $this->delete($cartFrom->getId(), $cartFrom);
        }
    }
}
