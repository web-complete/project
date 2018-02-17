<?php

namespace cubes\ecommerce\classifier;

use cubes\ecommerce\classifier\admin\Controller;
use modules\admin\classes\cells\CellFactory;
use modules\admin\classes\cells\CellAbstract;
use modules\admin\classes\EntityConfig;
use modules\admin\classes\fields\FieldFactory;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\filter\FilterFactory;
use modules\admin\classes\filter\FilterField;
use modules\admin\classes\form\AdminForm;
use WebComplete\core\utils\typecast\Cast;

class ClassifierItemConfig extends EntityConfig
{
    public $namespace = 'ecommerce';
    public $name = 'classifier';
    public $titleList = 'Классификатор';
    public $titleDetail = 'Раздел';
    public $menuSectionName = 'Магазин';
    public $menuSectionSort = 120;
    public $menuItemSort = 130;
    public $menuEnabled = false;
    public $entityServiceClass = ClassifierService::class;
    public $controllerClass = Controller::class;

    /**
     * @return array
     */
    public static function getFieldTypes(): array
    {
        return [
            'parent_id' => Cast::INT,
            'sort' => Cast::INT,
            'title' => Cast::STRING,
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
            $cells->string('Название', 'title', \SORT_DESC),
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
            $filters->string('Название', 'title', FilterFactory::MODE_LIKE),
        ];
    }

    /**
     * @return FieldAbstract[]
     */
    public function getDetailFields(): array
    {
        $fields = FieldFactory::build();
        return [
            $fields->string('Название', 'title')->multilang(),
        ];
    }

    /**
     * @return AdminForm
     */
    public function getForm(): AdminForm
    {
        return new AdminForm([
            [['parent_id', 'title'], 'required', [], AdminForm::MESSAGE_REQUIRED],
        ]);
    }
}
