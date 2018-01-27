<?php

namespace cubes\seo\slug;

use WebComplete\core\entity\AbstractEntity;

/**
*
* @property $name
* @property $item_class
* @property $item_id
*/
class Slug extends AbstractEntity
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return SlugConfig::getFieldTypes();
    }
}
