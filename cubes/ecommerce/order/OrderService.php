<?php

namespace cubes\ecommerce\order;

use cubes\ecommerce\interfaces\CartInterface;
use cubes\ecommerce\interfaces\CheckoutInterface;
use cubes\ecommerce\interfaces\OrderInterface;
use cubes\ecommerce\interfaces\OrderServiceInterface;
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
        // TODO: Implement createOrder() method.
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
}
