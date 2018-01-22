<?php

namespace cubes\multilang\translation;

use WebComplete\core\entity\AbstractEntity;

/**
*
* @property $namespace
* @property $original
* @property $translations
*/
class Translation extends AbstractEntity
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return TranslationConfig::getFieldTypes();
    }
}
