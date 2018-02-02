<?php

namespace cubes\content\staticPage;

use cubes\content\staticPage\admin\Controller;
use modules\admin\classes\cells\CellFactory;
use modules\admin\classes\cells\CellAbstract;
use modules\admin\classes\EntityConfig;
use modules\admin\classes\fields\FieldFactory;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\filter\FilterFactory;
use modules\admin\classes\filter\FilterField;
use modules\admin\classes\form\AdminForm;
use WebComplete\core\utils\typecast\Cast;

class StaticPageConfig extends EntityConfig
{
    public $name = 'static-page';
    public $titleList = 'Статические страницы';
    public $titleDetail = 'Статическая страница';
    public $menuItemSort = 60;
    public $menuSectionName = 'Контент';
    public $entityServiceClass = StaticPageService::class;
    public $controllerClass = Controller::class;
    public $searchable = true;
    public $entitySeoClass = StaticPageSeo::class;

    /**
     * @return array
     */
    public static function getFieldTypes(): array
    {
        return [
            'title' => Cast::STRING,
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
            $cells->string('Заголовок', 'title', \SORT_DESC),
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
            $filters->string('Заголовок', 'title', FilterFactory::MODE_LIKE),
        ];
    }

    /**
     * @return FieldAbstract[]
     */
    public function getDetailFields(): array
    {
        $fields = FieldFactory::build();
        return [
            $fields->string('Заголовок', 'title')->multilang(),
            $fields->redactor('Контент', 'content')->multilang(),
        ];
    }

    /**
     * @return AdminForm
     */
    public function getForm(): AdminForm
    {
        return new AdminForm([
            [['title'], 'required', [], AdminForm::MESSAGE_REQUIRED],
            [['content']],
        ]);
    }
}
