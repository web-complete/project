<?php

namespace cubes\ecommerce\product;

use cubes\ecommerce\interfaces\ProductOfferInterface;
use cubes\ecommerce\interfaces\ProductOfferServiceInterface;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;

/**
 * @method Product|ProductOfferInterface create
 */
class ProductService extends AbstractEntityService implements ProductRepositoryInterface, ProductOfferServiceInterface
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

    /**
     * @param string $sku
     *
     * @return ProductOfferInterface|Product|AbstractEntity|null
     */
    public function findBySku(string $sku)
    {
        return $this->findById($sku);
    }
}
