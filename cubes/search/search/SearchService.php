<?php

namespace cubes\search\search;

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
        return $doc->isToDelete()
            ? $this->deleteDoc($doc->getId())
            : $this->adapter->indexDoc($doc);
    }

    /**
     * @param $id
     */
    public function deleteDoc($id)
    {
        return $this->adapter->deleteDoc($id);
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
     */
    public function clear(string $type = null)
    {
        return $this->adapter->clear($type);
    }
}
