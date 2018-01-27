<?php

namespace cubes\seo\meta;

use cubes\seo\meta\admin\Controller;
use modules\admin\classes\cells\CellFactory;
use modules\admin\classes\cells\CellAbstract;
use modules\admin\classes\EntityConfig;
use modules\admin\classes\fields\FieldFactory;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\filter\FilterFactory;
use modules\admin\classes\filter\FilterField;
use modules\admin\classes\form\AdminForm;
use WebComplete\core\utils\typecast\Cast;

class MetaConfig extends EntityConfig
{
    public $name = 'meta';
    public $titleList = 'Мета теги страниц';
    public $titleDetail = 'Мета теги страницы';
    public $menuSectionName = 'SEO';
    public $entityServiceClass = MetaService::class;
    public $controllerClass = Controller::class;

    /**
     * @return array
     */
    public static function getFieldTypes(): array
    {
        return [
            'url' => Cast::STRING,
            'title' => Cast::STRING,
            'description' => Cast::STRING,
            'keywords' => Cast::STRING,
        ];
    }

    /**
     * @return CellAbstract[]
     */
    public function getListFields(): array
    {
        $cells = CellFactory::build();
        return [
            $cells->string('URL', 'url', \SORT_DESC),
            $cells->checkbox('title', 'title'),
            $cells->checkbox('description', 'description'),
            $cells->checkbox('keywords', 'keywords'),
        ];
    }

    /**
     * @return FilterField[]
     */
    public function getFilterFields(): array
    {
        $filters = FilterFactory::build();
        return [
            $filters->string('URL', 'url', FilterFactory::MODE_LIKE),
        ];
    }

    /**
     * @return FieldAbstract[]
     */
    public function getDetailFields(): array
    {
        $fields = FieldFactory::build();
        return [
            $fields->string('URL', 'url'),
            $fields->string('title', 'title'),
            $fields->string('description', 'description'),
            $fields->string('keywords', 'keywords'),
        ];
    }

    /**
     * @return AdminForm
     */
    public function getForm(): AdminForm
    {
        return new AdminForm([
            [['url'], 'required', [], AdminForm::MESSAGE_REQUIRED],
            [['title', 'description', 'keywords']],
        ], [
            [['url'], function ($value) {
                return '/' . \trim($value, '/');
            }]
        ]);
    }
}
