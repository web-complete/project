<?php

namespace cubes\system\search\search\adapters;

use cubes\system\search\search\SearchDocFactory;
use cubes\system\search\search\SearchInterface;

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
