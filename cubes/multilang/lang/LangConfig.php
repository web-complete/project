<?php

namespace cubes\multilang\lang;

use cubes\multilang\lang\admin\Controller;
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

class LangConfig extends EntityConfig
{
    public $name = 'lang';
    public $titleList = 'Языки';
    public $titleDetail = 'Язык';
    public $menuSectionName = 'Мультиязычность';
    public $entityServiceClass = LangService::class;
    public $controllerClass = Controller::class;

    /**
     * @return array
     */
    public static function getFieldTypes(): array
    {
        return [
            'code' => Cast::STRING,
            'name' => Cast::STRING,
            'sort' => Cast::INT,
            'is_main' => Cast::BOOL,
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
            $cells->string('Название', 'name', \SORT_DESC),
            $cells->string('Сортировка', 'sort', \SORT_DESC),
            $cells->checkbox('Основной', 'is_main', \SORT_DESC),
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
            $filters->string('Код', 'code', FilterFactory::MODE_EQUAL),
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
            $fields->string('Код', 'code'),
            $fields->string('Название', 'name'),
            $fields->number('Сортировка', 'sort'),
            $fields->checkbox('Основной', 'is_main'),
        ];
    }

    /**
     * @return AbstractForm
     */
    public function getForm(): AdminForm
    {
        return new AdminForm([
            [['code', 'name'], 'required', [], AdminForm::MESSAGE_REQUIRED],
            [['sort', 'is_main']],
        ]);
    }
}
