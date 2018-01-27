<?php

namespace cubes\content\article;

use cubes\multilang\lang\classes\AbstractMultilangEntity;
use cubes\seo\seo\SeoEntityTrait;

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
class Article extends AbstractMultilangEntity
{
    use SeoEntityTrait;

    /**
     * @return array
     */
    public static function fields(): array
    {
        return ArticleConfig::getFieldTypes();
    }
}
