<?php

namespace cubes\ecommerce\productOffer;

use cubes\ecommerce\interfaces\ProductOfferInterface;
use cubes\ecommerce\interfaces\ProductOfferServiceInterface;
use cubes\ecommerce\productOffer\repository\ProductOfferRepositoryInterface;
use WebComplete\core\condition\Condition;
use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\entity\AbstractEntityService;

class ProductOfferService extends AbstractEntityService implements ProductOfferRepositoryInterface, ProductOfferServiceInterface
{

    /**
     * @var ProductOfferRepositoryInterface
     */
    protected $repository;

    /**
     * @param ProductOfferRepositoryInterface $repository
     */
    public function __construct(ProductOfferRepositoryInterface $repository)
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
