<?php

namespace cubes\ecommerce\productOffer;

use WebComplete\core\entity\AbstractEntityService;

class ProductOfferItemService extends AbstractEntityService implements ProductOfferItemRepositoryInterface
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
}
