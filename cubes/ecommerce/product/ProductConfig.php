<?php

namespace cubes\ecommerce\product;

use cubes\ecommerce\product\admin\Controller;
use modules\admin\classes\cells\CellAbstract;
use modules\admin\classes\cells\CellFactory;
use modules\admin\classes\EntityConfig;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\fields\FieldFactory;
use modules\admin\classes\filter\FilterFactory;
use modules\admin\classes\filter\FilterField;
use modules\admin\classes\form\AdminForm;
use WebComplete\core\utils\typecast\Cast;

class ProductConfig extends EntityConfig
{
    public $namespace = 'ecommerce';
    public $name = 'product';
    public $titleList = 'Товары';
    public $titleDetail = 'Товар';
    public $menuSectionName = 'Магазин';
    public $menuSectionSort = 120;
    public $menuItemSort = 140;
    public $entityServiceClass = ProductService::class;
    public $controllerClass = Controller::class;

    /**
     * @return array
     */
    public static function getFieldTypes(): array
    {
        return [
            'name' => Cast::STRING,
            'price' => Cast::FLOAT,
        ];
    }

    /**
     * @return CellAbstract[]
     */
    public function getListFields(): array
    {
        $cells = CellFactory::build();
        return [
            $cells->string('ID', 'id', \SORT_DESC),
            $cells->string('Название', 'name', \SORT_DESC),
        ];
    }

    /**
     * @return FilterField[]
     */
    public function getFilterFields(): array
    {
        $filters = FilterFactory::build();
        return [
            $filters->string('ID', 'id', FilterFactory::MODE_EQUAL),
            $filters->string('Название', 'name', FilterFactory::MODE_LIKE),
        ];
    }

    /**
     * @return FieldAbstract[]
     */
    public function getDetailFields(): array
    {
        $fields = FieldFactory::build();
        return [
            $fields->string('Название', 'name')->multilang(),
            $fields->number('Цена', 'price'),
        ];
    }

    /**
     * @return AdminForm
     */
    public function getForm(): AdminForm
    {
        return new AdminForm([
            [['name', 'price'], 'required', [], AdminForm::MESSAGE_REQUIRED],
        ]);
    }
}
