<?php

namespace cubes\content\article;

use cubes\multilang\lang\classes\AbstractMultilangEntity;
use cubes\search\search\Searchable;
use cubes\search\search\SearchDoc;
use cubes\seo\seo\SeoEntityTrait;
use cubes\system\file\ImageHelper;

/**
 *
 * @property $title
 * @property $description
 * @property $text
 * @property $viewed
 * @property $tags
 * @property $image_list
 * @property $image_detail
 * @property $is_active
 * @property $created_on
 * @property $updated_on
 * @property $published_on
 */
class Article extends AbstractMultilangEntity implements Searchable
{
    use SeoEntityTrait;

    /**
     * @return array
     */
    public static function fields(): array
    {
        return ArticleConfig::getFieldTypes();
    }

    /**
     * @param SearchDoc $doc
     *
     * @throws \RuntimeException
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \Symfony\Component\Cache\Exception\InvalidArgumentException
     */
    public function prepareSearchDoc(SearchDoc $doc)
    {
        $doc->setId($this->getId());
        $doc->type = 'article';
        $doc->title = $this->title;
        $doc->content = $this->text;
        $doc->image = $this->image_detail ? ImageHelper::getUrl($this->image_detail) : '';
        $doc->url = $this->getUrl();
        $doc->weight = 1;
    }
}
