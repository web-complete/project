<?php

namespace cubes\system\search\search\tests;

use cubes\system\search\search\elastic\ElasticSearchDocIndex;

class ElasticTestingDocIndex extends ElasticSearchDocIndex
{
    protected $refresh = 'wait_for'; // true | wait_for
}
