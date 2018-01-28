<?php

namespace cubes\search\search\adapters;

use cubes\search\search\SearchDoc;
use cubes\search\search\SearchInterface;
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
     * @param $id
     *
     * @return null
     */
    public function deleteDoc($id)
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
     * @return null
     */
    public function clear(string $type = null)
    {
        return null;
    }
}
