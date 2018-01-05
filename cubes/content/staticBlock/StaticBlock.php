<?php

namespace cubes\content\staticBlock;

use WebComplete\core\entity\AbstractEntity;

/**
 *
 * @property $code
 * @property $type
 * @property $description
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
