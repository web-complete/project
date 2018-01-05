<?php

namespace cubes\content\staticBlock;

/**
 *
 * @property $code
 * @property $type
 * @property $description
 * @property $content
 */
class StaticBlock
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return StaticBlockConfig::getFieldTypes();
    }
}
