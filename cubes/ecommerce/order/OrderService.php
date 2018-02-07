<?php

namespace cubes\ecommerce\order;

use cubes\ecommerce\cartItem\CartItem;
use cubes\ecommerce\checkout\Checkout;
use cubes\ecommerce\interfaces\CartInterface;
use cubes\ecommerce\interfaces\CheckoutInterface;
use cubes\ecommerce\interfaces\OrderInterface;
use cubes\ecommerce\interfaces\OrderItemInterface;
use cubes\ecommerce\interfaces\OrderServiceInterface;
use cubes\ecommerce\orderItem\OrderItem;
use cubes\ecommerce\orderItem\OrderItemFactory;
use cubes\ecommerce\orderItem\OrderItemService;
use cubes\system\user\User;
use cubes\system\user\UserService;
use WebComplete\core\condition\Condition;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;

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
     * @var UserService
     */
    protected $userService;

    /**
     * @param OrderRepositoryInterface $repository
     * @param OrderItemService $orderItemService
     * @param OrderItemFactory $orderItemFactory
     * @param UserService $userService
     */
    public function __construct(
        OrderRepositoryInterface $repository,
        OrderItemService $orderItemService,
        OrderItemFactory $orderItemFactory,
        UserService $userService
    ) {
        parent::__construct($repository);
        $this->orderItemService = $orderItemService;
        $this->orderItemFactory = $orderItemFactory;
        $this->userService = $userService;
    }

    /**
     * @param CartInterface $cart
     * @param CheckoutInterface $checkout
     *
     * @return OrderInterface
     */
    public function createOrder(CartInterface $cart, CheckoutInterface $checkout): OrderInterface
    {
        $user = $this->getOrCreateUser($cart, $checkout);
        /** @var Order|OrderInterface $order */
        $order = $this->create();
        $order->user_id = $user->getId();
        $order->setCheckout($checkout);
        $order->setStatus(OrderStatus::NEW);
        $this->save($order);
        if ($order->getId()) {
            /** @var CartItem $cartItem */
            foreach ($cart->getItems() as $cartItem) {
                $orderItem = $this->orderItemFactory->createFromCartItem($cartItem);
                $orderItem->setOrder($order);
            }
            $this->save($order);
        }

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
     * @param CheckoutInterface|Checkout $checkout
     *
     * @return User
     */
    protected function getOrCreateUser(CartInterface $cart, $checkout): User
    {
        $user = null;
        if ($userId = $cart->getUserId()) {
            $user = $this->userService->findById($userId);
        }

        if (!$user) {
            $user = $this->userService->create();
            $user->first_name = $checkout->get('first_name');
            $user->last_name = $checkout->get('last_name');
            $user->email = $checkout->get('email');
            $this->userService->save($user);
        }

        return $user;
    }
}
