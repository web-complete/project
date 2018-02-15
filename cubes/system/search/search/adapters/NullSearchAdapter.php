<?php

namespace cubes\system\search\search\adapters;

use cubes\system\search\search\SearchDoc;
use cubes\system\search\search\SearchInterface;
use WebComplete\core\utils\paginator\Paginator;

class NullSearchAdapter implements SearchInterface
{
    /**
     * @param SearchDoc $doc
     *
     * @return null
     */
    public function indexDoc(SearchDoc $doc)
    {
        return null;
    }

    /**
     * @param string $type
     * @param string|int $itemId
     * @param string $langCode
     *
     * @return null
     */
    public function deleteDoc(string $type, $itemId, string $langCode = null)
    {
        return null;
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
        return [];
    }

    /**
     * @param string|null $type
     *
     * @return int
     */
    public function count(string $type = null): int
    {
        return 0;
    }

    /**
     * @param string|null $type
     *
     * @return null
     */
    public function clear(string $type = null)
    {
        return null;
    }
}
