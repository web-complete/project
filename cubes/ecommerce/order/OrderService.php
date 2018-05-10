<?php

namespace cubes\ecommerce\order;

use cubes\ecommerce\cart\Cart;
use cubes\ecommerce\cart\CartService;
use cubes\ecommerce\cartItem\CartItem;
use cubes\ecommerce\interfaces\CartInterface;
use cubes\ecommerce\interfaces\CheckoutInterface;
use cubes\ecommerce\interfaces\OrderInterface;
use cubes\ecommerce\interfaces\OrderItemInterface;
use cubes\ecommerce\interfaces\OrderServiceInterface;
use cubes\ecommerce\order\repository\OrderRepositoryInterface;
use cubes\ecommerce\orderItem\OrderItem;
use cubes\ecommerce\orderItem\OrderItemFactory;
use cubes\ecommerce\orderItem\OrderItemService;
use cubes\system\user\User;
use cubes\system\user\UserService;
use WebComplete\core\condition\Condition;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;
use WebComplete\core\utils\traits\TraitData;

/**
 * @method OrderInterface|Order create()
 */
class OrderService extends AbstractEntityService implements OrderRepositoryInterface, OrderServiceInterface
{

    /**
     * @var OrderRepositoryInterface
     */
    protected $repository;
    /**
     * @var OrderItemService
     */
    protected $orderItemService;
    /**
     * @var OrderItemFactory
     */
    protected $orderItemFactory;
    /**
     * @var CartService
     */
    protected $cartService;
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @param OrderRepositoryInterface $repository
     * @param OrderItemService $orderItemService
     * @param OrderItemFactory $orderItemFactory
     * @param CartService $cartService
     * @param UserService $userService
     */
    public function __construct(
        OrderRepositoryInterface $repository,
        OrderItemService $orderItemService,
        OrderItemFactory $orderItemFactory,
        CartService $cartService,
        UserService $userService
    ) {
        parent::__construct($repository);
        $this->orderItemService = $orderItemService;
        $this->orderItemFactory = $orderItemFactory;
        $this->cartService = $cartService;
        $this->userService = $userService;
    }

    /**
     * @param CartInterface|Cart $cart
     *
     * @return OrderInterface
     */
    public function createOrder(CartInterface $cart): OrderInterface
    {
        $user = $this->getOrCreateUser($cart);
        /** @var Order|OrderInterface $order */
        $order = $this->create();
        $order->user_id = $user->getId();
        $order->getCheckout()->setData($cart->getCheckout()->getData());
        $order->setStatus(OrderStatus::NEW);
        $this->save($order);
        if ($order->getId()) {
            $orderItems = [];
            /** @var CartItem $cartItem */
            foreach ($cart->getItems() as $cartItem) {
                $orderItem = $this->orderItemFactory->createFromCartItem($cartItem);
                $orderItem->setOrder($order);
                $this->orderItemService->save($orderItem);
                $orderItems[] = $orderItem;
            }
            $order->setItems($orderItems);
            $this->save($order);
        }

        $this->cartService->delete($cart->getId(), $cart);
        return $order;
    }

    /**
     * @param $id
     *
     * @return null|AbstractEntity|Order|OrderInterface
     */
    public function findById($id)
    {
        if ($order = parent::findById($id)) {
            $this->loadOrderItems($order);
        }
        return $order;
    }

    /**
     * @param Condition $condition
     *
     * @return null|AbstractEntity|Order|OrderInterface
     */
    public function findOne(Condition $condition)
    {
        if ($order = parent::findOne($condition)) {
            $this->loadOrderItems($order);
        }
        return $order;
    }

    /**
     * @param AbstractEntity|OrderInterface|Order $order
     * @param array $oldData
     */
    public function save(AbstractEntity $order, array $oldData = [])
    {
        parent::save($order, $oldData);
        $this->saveOrderItems($order);
    }

    /**
     * @param Order|AbstractEntity $order
     */
    public function loadOrderItems(Order $order)
    {
        $condition = $this->orderItemService->createCondition(['order_id' => $order->getId()]);
        $items = $this->orderItemService->findAll($condition);
        $order->setItems(\array_values($items));
    }

    /**
     * @param Order $order
     */
    protected function saveOrderItems(Order $order)
    {
        /** @var AbstractEntity|OrderItemInterface|OrderItem $orderItem */
        foreach ($order->getItems() as $orderItem) {
            $orderItem->order_id = $order->getId();
            $this->orderItemService->save($orderItem);
        }

        foreach ($order->getDeletedItems() as $deletedItem) {
            $this->orderItemService->delete($deletedItem->getId(), $deletedItem);
        }
    }

    /**
     * @param CartInterface $cart
     *
     * @return User
     */
    protected function getOrCreateUser(CartInterface $cart): User
    {
        $user = null;
        if ($userId = $cart->getUserId()) {
            $user = $this->userService->findById($userId);
        }

        if (!$user) {
            /** @var TraitData|CheckoutInterface $checkout */
            $checkout = $cart->getCheckout();
            $user = $this->userService->create();
            $user->first_name = $checkout->get('first_name');
            $user->last_name = $checkout->get('last_name');
            $user->email = $checkout->get('email');
            $this->userService->save($user);
        }

        return $user;
    }
}
