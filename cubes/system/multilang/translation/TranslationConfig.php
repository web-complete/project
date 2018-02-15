<?php

namespace cubes\system\multilang\translation;

use cubes\system\multilang\lang\LangService;
use cubes\system\multilang\translation\admin\Controller;
use modules\admin\classes\cells\CellFactory;
use modules\admin\classes\cells\CellAbstract;
use modules\admin\classes\EntityConfig;
use modules\admin\classes\fields\FieldFactory;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\filter\FilterFactory;
use modules\admin\classes\filter\FilterField;
use modules\admin\classes\form\AdminForm;
use WebComplete\core\utils\typecast\Cast;

class TranslationConfig extends EntityConfig
{
    public $namespace = 'system';
    public $name = 'translation';
    public $titleList = 'Переводы';
    public $titleDetail = 'Перевод';
    public $menuSectionName = 'Мультиязычность';
    public $menuSectionSort = 600;
    public $menuItemSort = 200;
    public $entityServiceClass = TranslationService::class;
    public $controllerClass = Controller::class;

    /**
     * @return array
     */
    public static function getFieldTypes(): array
    {
        return [
            'namespace' => Cast::STRING,
            'original' => Cast::STRING,
            'translations' => [Cast::STRING],
        ];
    }

    /**
     * @return CellAbstract[]
     */
    public function getListFields(): array
    {
        $cells = CellFactory::build();
        $result = [
            $cells->string('Пространство', 'namespace', \SORT_DESC),
            $cells->string('Оригинал', 'original'),
        ];

        $langService = $this->container->get(LangService::class);
        foreach ($langService->getLangs() as $lang) {
            $result[] = $cells->checkbox($lang->name, 'translations.' . $lang->code);
        }
        return $result;
    }

    /**
     * @return FilterField[]
     */
    public function getFilterFields(): array
    {
        $filters = FilterFactory::build();
        return [
            $filters->string('Пространство', 'namespace', FilterFactory::MODE_LIKE),
            $filters->string('Оригинал', 'original', FilterFactory::MODE_LIKE),
        ];
    }

    /**
     * @return FieldAbstract[]
     */
    public function getDetailFields(): array
    {
        $fields = FieldFactory::build();
        $result = [
            $fields->string('Пространство', 'namespace'),
            $fields->textarea('Оригинал', 'original')->rows(5),
        ];

        $langService = $this->container->get(LangService::class);
        foreach ($langService->getLangs() as $lang) {
            $result[] = $fields->textarea($lang->name, 'translations.' . $lang->code)->rows(5);
        }
        return $result;
    }

    /**
     * @return AdminForm
     */
    public function getForm(): AdminForm
    {
        return new AdminForm([
            [['namespace'], 'required', [], AdminForm::MESSAGE_REQUIRED],
            [['original'], 'required', [], AdminForm::MESSAGE_REQUIRED],
            [['translations']]
        ]);
    }
}
