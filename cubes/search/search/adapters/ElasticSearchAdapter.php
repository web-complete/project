<?php

namespace cubes\search\search\adapters;

use cubes\search\search\elastic\ElasticSearchDocIndex;
use cubes\search\search\SearchDoc;
use cubes\search\search\SearchDocFactory;
use WebComplete\core\utils\paginator\Paginator;

class ElasticSearchAdapter extends AbstractAdapter
{
    /**
     * @var ElasticSearchDocIndex
     */
    protected $index;

    /**
     * @param SearchDocFactory $factory
     * @param ElasticSearchDocIndex $index
     */
    public function __construct(SearchDocFactory $factory, ElasticSearchDocIndex $index)
    {
        parent::__construct($factory);
        $this->index = $index;
    }

    /**
     * @param SearchDoc $doc
     */
    public function indexDoc(SearchDoc $doc)
    {
        // TODO: Implement indexDoc() method.
    }

    /**
     * @param string $type
     * @param $itemId
     * @param string|null $langCode
     */
    public function deleteDoc(string $type, $itemId, string $langCode = null)
    {
        // TODO: Implement deleteDoc() method.
    }

    /**
     * @param Paginator $paginator
     * @param string $query
     * @param string|null $type
     * @param string|null $langCode
     *
     * @return SearchDoc[]
     */
    public function search(Paginator $paginator, string $query, string $type = null, string $langCode = null): array
    {
        // TODO: Implement search() method.
    }

    /**
     * @param string|null $type
     *
     * @return int
     */
    public function count(string $type = null): int
    {
        // TODO: Implement count() method.
    }

    /**
     * @param string|null $type
     */
    public function clear(string $type = null)
    {
        if ($type) {
            // TODO: Implement clear() method.
        } else {
            $this->index->createIndex();
        }
    }
}
