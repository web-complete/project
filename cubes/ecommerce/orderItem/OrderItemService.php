<?php

namespace cubes\ecommerce\orderItem;

use cubes\ecommerce\interfaces\OrderItemInterface;
use cubes\ecommerce\orderItem\repository\OrderItemRepositoryInterface;
use WebComplete\core\entity\AbstractEntityService;

/**
 * @method OrderItemInterface|OrderItem create()
 */
class OrderItemService extends AbstractEntityService implements OrderItemRepositoryInterface
{

    /**
     * @var OrderItemRepositoryInterface
     */
    protected $repository;

    /**
     * @param OrderItemRepositoryInterface $repository
     */
    public function __construct(OrderItemRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
