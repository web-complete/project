<?php

namespace cubes\multilang\lang;

use WebComplete\core\entity\AbstractEntity;

/**
*
* @property $code
* @property $name
* @property $sort
* @property $is_main
*/
class Lang extends AbstractEntity
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return LangConfig::getFieldTypes();
    }
}
