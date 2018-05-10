<?php

namespace cubes\content\staticBlock;

use cubes\content\staticBlock\repository\StaticBlockRepositoryInterface;
use WebComplete\core\entity\AbstractEntityService;

class StaticBlockService extends AbstractEntityService implements StaticBlockRepositoryInterface
{

    const TYPE_STRING = 1;
    const TYPE_TEXT = 2;
    const TYPE_HTML = 3;
    const TYPE_IMAGE = 4;
    const TYPE_IMAGES = 5;

    static public $typeMap = [
        self::TYPE_STRING => 'Строка',
        self::TYPE_TEXT => 'Текст',
        self::TYPE_HTML => 'Html',
        self::TYPE_IMAGE => 'Изображение',
        self::TYPE_IMAGES => 'Изображения',
    ];

    /**
     * @var StaticBlockRepositoryInterface
     */
    protected $repository;

    /**
     * @param StaticBlockRepositoryInterface $repository
     */
    public function __construct(StaticBlockRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
