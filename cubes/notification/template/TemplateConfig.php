<?php

namespace cubes\notification\template;

use cubes\notification\template\admin\Controller;
use modules\admin\classes\cells\CellFactory;
use modules\admin\classes\cells\CellAbstract;
use modules\admin\classes\EntityConfig;
use modules\admin\classes\fields\FieldFactory;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\filter\FilterFactory;
use modules\admin\classes\filter\FilterField;
use modules\admin\classes\form\AdminForm;
use WebComplete\core\utils\typecast\Cast;

class TemplateConfig extends EntityConfig
{
    public $name = 'template';
    public $titleList = 'Шаблоны';
    public $titleDetail = 'Шаблон';
    public $menuSectionName = 'Оповещения';
    public $menuSectionSort = 200;
    public $entityServiceClass = TemplateService::class;
    public $controllerClass = Controller::class;

    /**
     * @return array
     */
    public static function getFieldTypes(): array
    {
        return [
            'code'    => Cast::STRING,
            'subject' => Cast::STRING,
            'html'    => Cast::STRING,
            'text'    => Cast::STRING,
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
            $cells->string('Код', 'code', \SORT_ASC),
            $cells->string('Тема', 'subject', \SORT_ASC),
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
            $fields->string('Тема', 'subject')->multilang(true),
            $fields->html('Шаблон html', 'html')->multilang(true),
            $fields->textarea('Шаблон text', 'text')->multilang(true),
        ];
    }

    /**
     * @return AdminForm
     */
    public function getForm(): AdminForm
    {
        return new AdminForm([
            [['code', 'subject', 'html'], 'required', [], AdminForm::MESSAGE_REQUIRED],
            [['text']],
        ]);
    }
}
