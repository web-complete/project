<?php

namespace cubes\system\search\search;

use WebComplete\core\utils\paginator\Paginator;

interface SearchInterface
{
    /**
     * @param SearchDoc $doc
     */
    public function indexDoc(SearchDoc $doc);

    /**
     * @param string $type
     * @param $itemId
     * @param string|null $langCode
     */
    public function deleteDoc(string $type, $itemId, string $langCode = null);

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
     *
     * @return int
     */
    public function count(string $type = null): int;

    /**
     * @param string|null $type
     */
    public function clear(string $type = null);
}
