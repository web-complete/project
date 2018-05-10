<?php

namespace cubes\ecommerce\productOffer;

use cubes\ecommerce\interfaces\ProductOfferInterface;
use cubes\ecommerce\interfaces\ProductOfferServiceInterface;
use cubes\ecommerce\productOffer\repository\ProductOfferItemRepositoryInterface;
use WebComplete\core\condition\Condition;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;

class ProductOfferItemService extends AbstractEntityService implements ProductOfferItemRepositoryInterface, ProductOfferServiceInterface
{

    /**
     * @var ProductOfferItemRepositoryInterface
     */
    protected $repository;

    /**
     * @param ProductOfferItemRepositoryInterface $repository
     */
    public function __construct(ProductOfferItemRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param string $sku
     *
     * @return AbstractEntity|ProductOfferInterface|null
     */
    public function findBySku(string $sku)
    {
        return $this->repository->findOne(new Condition(['sku' => $sku]));
    }
}
