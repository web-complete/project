<?php

namespace cubes\content\menu;

use cubes\multilang\lang\classes\AbstractMultilangEntity;

/**
 *
 * @property $parent_id
 * @property $sort
 * @property $title
 * @property $type
 * @property $url
 * @property $page
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
