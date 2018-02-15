<?php

namespace cubes\system\search\search;

interface Searchable
{
    /**
     * @param SearchDoc $doc
     */
    public function prepareSearchDoc(SearchDoc $doc);
}
