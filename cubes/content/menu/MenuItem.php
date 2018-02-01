<?php

namespace cubes\content\menu;

use cubes\multilang\lang\classes\AbstractMultilangEntity;

/**
 *
 * @property $parent_id
 * @property $sort
 * @property $title
 */
class MenuItem extends AbstractMultilangEntity
{
    /**
     * @return array
     */
    public static function fields(): array
    {
        return MenuItemConfig::getFieldTypes();
    }
}
