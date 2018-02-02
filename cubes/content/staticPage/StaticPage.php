<?php

namespace cubes\content\staticPage;

use cubes\multilang\lang\classes\AbstractMultilangEntity;
use cubes\search\search\Searchable;
use cubes\search\search\SearchDoc;
use cubes\seo\seo\SeoEntityTrait;

/**
*
* @property $title
* @property $content
*/
class StaticPage extends AbstractMultilangEntity implements Searchable
{
    use SeoEntityTrait;

    /**
     * @return array
     */
    public static function fields(): array
    {
        return StaticPageConfig::getFieldTypes();
    }

    /**
     * @param SearchDoc $doc
     */
    public function prepareSearchDoc(SearchDoc $doc)
    {
        $doc->type = 'static-page';
        $doc->item_id = $this->getId();
        $doc->title = $this->title;
        $doc->content = $this->content;
        $doc->url = $this->getUrl();
    }
}
