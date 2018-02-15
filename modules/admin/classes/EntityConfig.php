<?php

namespace modules\admin\classes;

use modules\admin\classes\cells\CellAbstract;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\filter\FilterField;
use modules\admin\classes\form\AdminForm;
use WebComplete\core\utils\container\ContainerInterface;

abstract class EntityConfig
{
    /**
     * entity namespace in snake-case (not necessary)
     * @var string
     */
    public $namespace;
    /**
     * entity name in snake-case
     * @var string
     */
    public $name = null;
    public $titleList = null;
    public $titleDetail = null;
    public $entityServiceClass = null;
    public $controllerClass = null;
    public $entitySeoClass = null;
    public $menuEnabled = true;
    public $menuSectionName = null;
    public $menuSectionSort = 100;
    public $menuItemSort = 100;
    public $tagField = null;
    public $searchable = false;
    public $rbac = true;

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
     * @return string
     */
    public function getSystemName(): string
    {
        return trim(implode('-', [$this->namespace, $this->name]), '-');
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
     * @return AdminForm
     */
    abstract public function getForm(): AdminForm;
}