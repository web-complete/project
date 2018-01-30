<?php

namespace cubes\search\search\tests;

use cubes\search\search\elastic\ElasticSearchDocIndex;

class ElasticTestingDocIndex extends ElasticSearchDocIndex
{
    protected $refresh = 'wait_for'; // true | wait_for
}
