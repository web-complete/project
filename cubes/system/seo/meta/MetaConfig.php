<?php

namespace cubes\system\seo\meta;

use cubes\system\seo\meta\admin\Controller;
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
    public $namespace = 'system';
    public $name = 'meta';
    public $titleList = 'Метатеги страниц';
    public $titleDetail = 'Метатеги страницы';
    public $menuSectionName = 'SEO';
    public $menuSectionSort = 700;
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
            'canonical' => Cast::STRING,
            'noindex' => Cast::BOOL,
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
            $cells->checkbox('canonical', 'canonical'),
            $cells->checkbox('noindex', 'noindex'),
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
            $fields->string('canonical', 'canonical'),
            $fields->checkbox('noindex', 'noindex'),
        ];
    }

    /**
     * @return AdminForm
     */
    public function getForm(): AdminForm
    {
        return new AdminForm([
            [['url'], 'required', [], AdminForm::MESSAGE_REQUIRED],
            [['title', 'description', 'keywords', 'canonical', 'noindex']],
        ], [
            [['url'], function ($value) {
                return '/' . \trim($value, '/');
            }]
        ]);
    }
}
