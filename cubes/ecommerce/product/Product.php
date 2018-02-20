<?php

namespace cubes\ecommerce\product;

use cubes\system\search\search\Searchable;
use cubes\system\search\search\SearchDoc;
use cubes\system\seo\seo\SeoEntityTrait;

class Product extends ProductAbstract implements Searchable
{
    use SeoEntityTrait;

    /**
     * @param SearchDoc $doc
     */
    public function prepareSearchDoc(SearchDoc $doc)
    {
        $doc->type = 'product';
        $doc->item_id = $this->getId();
        $doc->title = $this->name;
        $doc->url = $this->getUrl();
        $doc->weight = 1;
    }
}
