<?php

namespace cubes\ecommerce\classifier;

use WebComplete\core\entity\AbstractEntity;

/**
 *
 * @property $parent_id
 * @property $sort
 * @property $title
 */
class ClassifierItem extends AbstractEntity
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return ClassifierItemConfig::getFieldTypes();
    }
}
