<?php

namespace cubes\system\seo\meta;

use WebComplete\core\entity\AbstractEntity;

/**
*
* @property $url
* @property $title
* @property $description
* @property $keywords
* @property $canonical
* @property $noindex
*/
class Meta extends AbstractEntity
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return MetaConfig::getFieldTypes();
    }
}
