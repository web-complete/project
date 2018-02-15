<?php

namespace cubes\content\staticBlock;

use cubes\system\multilang\lang\classes\AbstractMultilangEntity;

/**
 *
 * @property $namespace
 * @property $name
 * @property $type
 * @property $content
 */
class StaticBlock extends AbstractMultilangEntity
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return StaticBlockConfig::getFieldTypes();
    }
}
