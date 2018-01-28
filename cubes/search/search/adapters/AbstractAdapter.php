<?php

namespace cubes\search\search\adapters;

use cubes\search\search\SearchDocFactory;
use cubes\search\search\SearchInterface;

abstract class AbstractAdapter implements SearchInterface
{
    /**
     * @var SearchDocFactory
     */
    protected $factory;

    /**
     * @param SearchDocFactory $factory
     */
    public function __construct(SearchDocFactory $factory)
    {
        $this->factory = $factory;
    }
}
