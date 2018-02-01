<?php

namespace cubes\content\menu;

use cubes\content\menu\admin\Controller;
use modules\admin\classes\cells\CellAbstract;
use modules\admin\classes\EntityConfig;
use modules\admin\classes\fields\FieldFactory;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\filter\FilterField;
use modules\admin\classes\form\AdminForm;
use WebComplete\core\utils\typecast\Cast;

class MenuItemConfig extends EntityConfig
{
    public $name = 'menu';
    public $titleList = 'Элементы меню';
    public $titleDetail = 'Элемент меню';
    public $menuSectionName = 'Контент';
    public $menuEnabled = false;
    public $entityServiceClass = MenuService::class;
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
        return [];
    }

    /**
     * @return FilterField[]
     */
    public function getFilterFields(): array
    {
        return [];
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
