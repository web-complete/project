<?php

namespace cubes\system\seo\redirect;

use WebComplete\core\entity\AbstractEntity;

/**
*
* @property $name
* @property $url_from
* @property $url_to
*/
class Redirect extends AbstractEntity
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return RedirectConfig::getFieldTypes();
    }
}
