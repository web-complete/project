<?php

namespace cubes\search\search;

use WebComplete\core\utils\paginator\Paginator;

class SearchService
{

    public function search(Paginator $paginator, string $query, string $langCode = null)
    {

    }

    public function indexDoc(
        $id,
        string $url,
        string $title,
        string $content,
        array $extra = [],
        string $langCode = null
    ) {

    }

    public function deleteDoc($id)
    {

    }

    public function clear()
    {

    }
}
