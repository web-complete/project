<?php

namespace cubes\ecommerce\orderItem;

use WebComplete\core\entity\AbstractEntityService;

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
