<?php

namespace cubes\content\staticBlock;

use cubes\content\staticBlock\admin\Controller;
use modules\admin\classes\cells\CellFactory;
use modules\admin\classes\cells\CellAbstract;
use modules\admin\classes\EntityConfig;
use modules\admin\classes\fields\FieldFactory;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\filter\FilterFactory;
use modules\admin\classes\filter\FilterField;
use modules\admin\classes\form\AdminForm;
use WebComplete\core\utils\typecast\Cast;
use WebComplete\form\AbstractForm;

class StaticBlockConfig extends EntityConfig
{
    public $name = 'static-block';
    public $titleList = 'Статические блоки';
    public $titleDetail = 'Статический блок';
    public $menuItemSort = 50;
    public $menuSectionName = 'Контент';
    public $entityServiceClass = StaticBlockService::class;
    public $controllerClass = Controller::class;

    /**
     * @return array
     */
    public static function getFieldTypes(): array
    {
        return [
            'code' => Cast::STRING,
            'type' => Cast::INT,
            'description' => Cast::STRING,
            'content' => Cast::STRING,
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
            $cells->string('Код', 'code', \SORT_DESC),
            $cells->string('Описание', 'description'),
            $cells->string('Тип', 'type', \SORT_DESC),
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
            $filters->string('Код', 'code', FilterFactory::MODE_LIKE),
        ];
    }

    /**
     * @return FieldAbstract[]
     */
    public function getDetailFields(): array
    {
        $fields = FieldFactory::build();
        return [
            $fields->string('Код', 'code'),
            // TODO it
        ];
    }

    /**
     * @return AbstractForm
     */
    public function getForm(): AbstractForm
    {
        return new AdminForm([
            [['code'], 'required', [], AdminForm::MESSAGE_REQUIRED],
            // TODO it
        ]);
    }
}
