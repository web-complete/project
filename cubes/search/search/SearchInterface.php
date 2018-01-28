<?php

namespace cubes\search\search;

use WebComplete\core\utils\paginator\Paginator;

interface SearchInterface
{
    /**
     * @param SearchDoc $doc
     */
    public function indexDoc(SearchDoc $doc);

    /**
     * @param $id
     */
    public function deleteDoc($id);

    /**
     * @param Paginator $paginator
     * @param string $query
     * @param string|null $type
     * @param string|null $langCode
     *
     * @return SearchDoc[]
     */
    public function search(Paginator $paginator, string $query, string $type = null, string $langCode = null): array;

    /**
     * @param string|null $type
     */
    public function clear(string $type = null);
}
