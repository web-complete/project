<?php

namespace cubes\content\article;

use WebComplete\core\entity\AbstractEntity;

/**
 *
 * @property $title
 * @property $description
 * @property $text
 * @property $viewed
 * @property $is_active
 * @property $created_on
 * @property $updated_on
 * @property $published_on
 */
class Article extends AbstractEntity
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return ArticleConfig::getFieldTypes();
    }
}
