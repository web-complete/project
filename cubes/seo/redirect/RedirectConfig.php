<?php

namespace cubes\seo\redirect;

use cubes\seo\redirect\admin\Controller;
use modules\admin\classes\cells\CellFactory;
use modules\admin\classes\cells\CellAbstract;
use modules\admin\classes\EntityConfig;
use modules\admin\classes\fields\FieldFactory;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\filter\FilterFactory;
use modules\admin\classes\filter\FilterField;
use modules\admin\classes\form\AdminForm;
use WebComplete\core\utils\typecast\Cast;

class RedirectConfig extends EntityConfig
{
    public $name = 'redirect';
    public $titleList = '301 редиректы';
    public $titleDetail = '301 редирект';
    public $menuSectionName = 'SEO';
    public $menuSectionSort = 700;
    public $menuItemSort = 200;
    public $entityServiceClass = RedirectService::class;
    public $controllerClass = Controller::class;

    /**
     * @return array
     */
    public static function getFieldTypes(): array
    {
        return [
            'name' => Cast::STRING,
            'url_from' => Cast::STRING,
            'url_to' => Cast::STRING,
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
            $cells->string('Откуда', 'url_from', \SORT_DESC),
            $cells->string('Куда', 'url_to', \SORT_DESC),
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
            $filters->string('Откуда', 'url_from', FilterFactory::MODE_LIKE),
            $filters->string('Куда', 'url_to', FilterFactory::MODE_LIKE),
        ];
    }

    /**
     * @return FieldAbstract[]
     */
    public function getDetailFields(): array
    {
        $fields = FieldFactory::build();
        return [
            $fields->string('Url откуда', 'url_from'),
            $fields->string('Url куда', 'url_to'),
        ];
    }

    /**
     * @return AdminForm
     */
    public function getForm(): AdminForm
    {
        return new AdminForm([
            [['url_from', 'url_to'], 'required', [], AdminForm::MESSAGE_REQUIRED],
        ], [
            [['url_from', 'url_to'], function ($value) {
                return '/' . \trim($value, '/');
            }]
        ]);
    }
}
