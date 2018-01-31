<?php

namespace cubes\seo\slug;

use cubes\seo\slug\admin\Controller;
use modules\admin\classes\cells\CellFactory;
use modules\admin\classes\cells\CellAbstract;
use modules\admin\classes\EntityConfig;
use modules\admin\classes\fields\FieldFactory;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\filter\FilterFactory;
use modules\admin\classes\filter\FilterField;
use modules\admin\classes\form\AdminForm;
use WebComplete\core\utils\typecast\Cast;

class SlugConfig extends EntityConfig
{
    public $name = 'slug';
    public $titleList = 'Slugs';
    public $titleDetail = 'Slug';
    public $menuSectionName = 'SEO';
    public $menuSectionSort = 700;
    public $menuItemSort = 400;
    public $menuEnabled = false;
    public $entityServiceClass = SlugService::class;
    public $controllerClass = Controller::class;

    /**
     * @return array
     */
    public static function getFieldTypes(): array
    {
        return [
            'name' => Cast::STRING,
            'item_class' => Cast::STRING,
            'item_id' => Cast::STRING,
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
            $cells->string('Slug', 'name', \SORT_DESC),
            $cells->string('ItemClass', 'item_class', \SORT_DESC),
            $cells->string('ItemId', 'item_id', \SORT_DESC),
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
            $filters->string('ItemClass', 'item_class', FilterFactory::MODE_LIKE),
            $filters->string('ItemId', 'item_id', FilterFactory::MODE_EQUAL),
        ];
    }

    /**
     * @return FieldAbstract[]
     */
    public function getDetailFields(): array
    {
        $fields = FieldFactory::build();
        return [
            $fields->string('Slug', 'name'),
            $fields->string('ItemClass', 'item_class'),
            $fields->string('ItemId', 'item_id'),
        ];
    }

    /**
     * @return AdminForm
     */
    public function getForm(): AdminForm
    {
        return new AdminForm([
            [['name', 'item_class', 'item_id'], 'required', [], AdminForm::MESSAGE_REQUIRED],
        ]);
    }
}
