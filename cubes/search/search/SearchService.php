<?php

namespace cubes\search\search;

use WebComplete\core\utils\helpers\StringHelper;
use WebComplete\core\utils\paginator\Paginator;

class SearchService implements SearchInterface
{

    /**
     * @var SearchInterface
     */
    protected $adapter;
    /**
     * @var SearchDocFactory
     */
    protected $factory;

    /**
     * @param SearchInterface $adapter
     * @param SearchDocFactory $factory
     */
    public function __construct(SearchInterface $adapter, SearchDocFactory $factory)
    {
        $this->adapter = $adapter;
        $this->factory = $factory;
    }

    /**
     * @return SearchDoc
     */
    public function createDoc(): SearchDoc
    {
        return $this->factory->create();
    }

    /**
     * @param SearchDoc $doc
     */
    public function indexDoc(SearchDoc $doc)
    {
        if ($doc->isToDelete()) {
            return $this->deleteDoc($doc->type, $doc->item_id);
        }

        $doc->weight = $doc->weight ?: 1;
        $doc->content = StringHelper::html2text($doc->content);
        return $this->adapter->indexDoc($doc);
    }

    /**
     * @param string $type
     * @param string|int $itemId
     * @param string $langCode
     */
    public function deleteDoc(string $type, $itemId, string $langCode = null)
    {
        return $this->adapter->deleteDoc($type, $itemId, $langCode);
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
        return $this->adapter->search($paginator, $query, $type, $langCode);
    }

    /**
     * @param string|null $type
     *
     * @return int
     */
    public function count(string $type = null): int
    {
        return $this->adapter->count($type);
    }

    /**
     * @param string|null $type
     */
    public function clear(string $type = null)
    {
        return $this->adapter->clear($type);
    }
}
