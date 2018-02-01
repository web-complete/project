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
    /** @var MenuItem[] */
    protected $children;

    /**
     * @return array
     */
    public static function fields(): array
    {
        return MenuItemConfig::getFieldTypes();
    }

    /**
     * @param MenuItem $item
     */
    public function addChild(MenuItem $item)
    {
        $this->children[$item->getId()] = $item;
    }

    /**
     * @return MenuItem[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }
}
