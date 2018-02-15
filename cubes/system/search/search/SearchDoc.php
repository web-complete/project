<?php

namespace cubes\system\search\search;

use WebComplete\core\entity\AbstractEntity;
use WebComplete\core\utils\typecast\Cast;

/**
 *
 * @property string $item_id
 * @property string $type
 * @property string $title
 * @property string $content
 * @property string $image
 * @property string $url
 * @property string $extra
 * @property float $weight
 * @property string $lang_code
 */
class SearchDoc extends AbstractEntity
{

    protected $toDelete = false;

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [
            'item_id' => Cast::STRING,
            'type' => Cast::STRING,
            'title' => Cast::STRING,
            'content' => Cast::STRING,
            'image' => Cast::STRING,
            'url' => Cast::STRING,
            'extra' => Cast::STRING,
            'weight' => Cast::FLOAT,
            'lang_code' => Cast::STRING,
        ];
    }

    /**
     */
    public function markToDelete()
    {
        $this->toDelete = true;
    }

    /**
     * @return bool
     */
    public function isToDelete(): bool
    {
        return (bool)$this->toDelete;
    }
}
