<?php

namespace cubes\ecommerce\cartItem;

use cubes\ecommerce\interfaces\CartItemInterface;
use WebComplete\core\entity\AbstractEntityService;

/**
 * @method CartItem|CartItemInterface create
 */
class CartItemService extends AbstractEntityService implements CartItemRepositoryInterface
{

    /**
     * @var CartItemRepositoryInterface
     */
    protected $repository;

    /**
     * @param CartItemRepositoryInterface $repository
     */
    public function __construct(CartItemRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
