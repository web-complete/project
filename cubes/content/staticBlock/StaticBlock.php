<?php

namespace cubes\content\staticBlock;

use WebComplete\core\entity\AbstractEntity;

/**
 *
 * @property $namespace
 * @property $name
 * @property $type
 * @property $content
 */
class StaticBlock extends AbstractEntity
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return StaticBlockConfig::getFieldTypes();
    }
}
