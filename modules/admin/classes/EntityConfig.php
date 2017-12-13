<?php

namespace modules\admin\classes;

use modules\admin\classes\cells\CellAbstract;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\filter\FilterField;
use WebComplete\core\utils\container\ContainerInterface;

abstract class EntityConfig
{
    public $name = null;
    public $titleList = null;
    public $titleDetail = null;
    public $entityServiceClass = null;
    public $controllerClass = null;
    public $menuSectionName = null;
    public $menuSectionSort = 100;
    public $menuItemSort = 100;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    abstract public static function fieldTypes(): array;

    /**
     * @return CellAbstract[]
     */
    abstract public function listFields(): array;

    /**
     * @return FilterField[]
     */
    abstract public function filterFields(): array;

    /**
     * @return FieldAbstract[]
     */
    abstract public function detailFields(): array;

    abstract public function form();
}