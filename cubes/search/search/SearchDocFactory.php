<?php

namespace cubes\search\search;

class SearchDocFactory
{

    /**
     * @return SearchDoc
     */
    public function create(): SearchDoc
    {
        return new SearchDoc();
    }

    /**
     * @param array $data
     *
     * @return SearchDoc
     */
    public function createFromData(array $data): SearchDoc
    {
        $doc = $this->create();
        $doc->mapFromArray($data);
        return $doc;
    }
}
