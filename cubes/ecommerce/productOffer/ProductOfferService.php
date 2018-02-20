<?php

namespace cubes\ecommerce\productOffer;

use WebComplete\core\entity\AbstractEntityService;

class ProductOfferService extends AbstractEntityService implements ProductOfferRepositoryInterface
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
}
