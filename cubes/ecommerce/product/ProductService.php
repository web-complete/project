<?php

namespace cubes\ecommerce\product;

use cubes\ecommerce\interfaces\ProductOfferInterface;
use cubes\ecommerce\interfaces\ProductOfferServiceInterface;
use cubes\ecommerce\product\repository\ProductRepositoryInterface;
use WebComplete\core\condition\Condition;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;

/**
 * @method Product|ProductOfferInterface create
 */
class ProductService extends AbstractEntityService implements ProductRepositoryInterface
{

    /**
     * @var ProductRepositoryInterface
     */
    protected $repository;

    /**
     * @param ProductRepositoryInterface $repository
     */
    public function __construct(ProductRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

//    /**
//     * @param string $sku
//     *
//     * @return ProductOfferInterface|Product|AbstractEntity|null
//     */
//    public function findBySku(string $sku)
//    {
//        return $this->repository->findOne(new Condition(['sku' => $sku]));
//    }
}
