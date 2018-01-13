<?php

namespace modules\admin\classes;

use modules\admin\classes\cells\CellAbstract;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\filter\FilterField;
use modules\admin\classes\form\AdminForm;
use WebComplete\core\utils\container\ContainerInterface;
use WebComplete\form\AbstractForm;

abstract class EntityConfig
{
    /**
     * entity name in snake-case
     * @var string
     */
    public $name = null;
    public $titleList = null;
    public $titleDetail = null;
    public $entityServiceClass = null;
    public $controllerClass = null;
    public $menuSectionName = null;
    public $menuSectionSort = 100;
    public $menuItemSort = 100;
    public $tagField = null;

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
    abstract public static function getFieldTypes(): array;

    /**
     * @return CellAbstract[]
     */
    abstract public function getListFields(): array;

    /**
     * @return FilterField[]
     */
    abstract public function getFilterFields(): array;

    /**
     * @return FieldAbstract[]
     */
    abstract public function getDetailFields(): array;

    /**
     * @return AbstractForm
     */
    abstract public function getForm(): AdminForm;
}