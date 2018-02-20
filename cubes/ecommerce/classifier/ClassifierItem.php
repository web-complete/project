<?php

namespace cubes\ecommerce\classifier;

use cubes\system\multilang\lang\classes\AbstractMultilangEntity;

/**
 *
 * @property $parent_id
 * @property $sort
 * @property $title
 */
class ClassifierItem extends AbstractMultilangEntity
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return ClassifierItemConfig::getFieldTypes();
    }
}
