<?php

namespace cubes\ecommerce\order;

use cubes\ecommerce\interfaces\CartInterface;
use cubes\ecommerce\interfaces\CheckoutInterface;
use cubes\ecommerce\interfaces\OrderInterface;
use cubes\ecommerce\interfaces\OrderServiceInterface;
use cubes\system\user\User;
use WebComplete\core\condition\Condition;
use WebComplete\core\entity\AbstractEntityService;

class OrderService extends AbstractEntityService implements OrderRepositoryInterface, OrderServiceInterface
{

    /**
     * @var OrderRepositoryInterface
     */
    protected $repository;

    /**
     * @param OrderRepositoryInterface $repository
     */
    public function __construct(OrderRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param CartInterface $cart
     * @param CheckoutInterface $checkout
     *
     * @return OrderInterface
     */
    public function createOrder(CartInterface $cart, CheckoutInterface $checkout): OrderInterface
    {
        $user = $this->getOrCreateUser($cart);
        /** @var Order|OrderInterface $order */
        $order = $this->create();
        $order->user_id = $user->getId();
        $order
        $this->save($order);
        return $order;
    }

    /**
     * @param $id
     *
     * @return OrderInterface[]
     */
    public function findOrdersByUserId($id): array
    {
        // TODO: Implement findOrdersByUserId() method.
    }

    /**
     * @param $id
     *
     * @return OrderInterface|null
     */
    public function findOrderById($id)
    {
        // TODO: Implement findOrderById() method.
    }

    protected function getOrCreateUser(CartInterface $cart): User
    {
        // TODO: Implement findOrderById() method.
    }
}
