<?php

namespace cubes\content\article;

use cubes\content\article\admin\Controller;
use modules\admin\classes\AdminCast;
use modules\admin\classes\cells\Cell;
use modules\admin\classes\cells\CellAbstract;
use modules\admin\classes\EntityConfig;
use modules\admin\classes\fields\Field;
use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\filter\Filter;
use modules\admin\classes\filter\FilterField;
use modules\admin\classes\form\AdminForm;
use WebComplete\core\utils\typecast\Cast;
use WebComplete\form\AbstractForm;

class ArticleConfig extends EntityConfig
{
    public $name = 'article';
    public $titleList = 'Статьи';
    public $titleDetail = 'Статья';
    public $entityServiceClass = ArticleService::class;
    public $controllerClass = Controller::class;
    public $menuSectionName = 'Контент';

    /**
     * @return array
     */
    public static function getFieldTypes(): array
    {
        return [
            'title' => Cast::STRING,
            'image' => Cast::STRING,
            'images' => Cast::ARRAY,
            'description' => Cast::STRING,
            'text' => Cast::STRING,
            'viewed' => Cast::INT,
            'is_active' => Cast::BOOL,
            'created_on' => Cast::STRING,
            'updated_on' => Cast::STRING,
            'published_on' => [AdminCast::class, 'date'],
        ];
    }

    /**
     * @return CellAbstract[]
     */
    public function getListFields(): array
    {
        return [
            Cell::string('ID', 'id', \SORT_DESC),
            Cell::string('Заголовок', 'title', \SORT_DESC),
            Cell::string('Просмотры', 'viewed', \SORT_DESC),
            Cell::checkbox('Активность', 'is_active', \SORT_DESC),
            Cell::date('Дата публикации', 'published_on', \SORT_DESC),
        ];
    }

    /**
     * @return FilterField[]
     */
    public function getFilterFields(): array
    {
        return [
            Filter::string('ID', 'id', Filter::MODE_EQUAL),
            Filter::string('Заголовок', 'title', Filter::MODE_EQUAL),
            Filter::boolean('Активность', 'is_active'),
        ];
    }

    /**
     * @return FieldAbstract[]
     */
    public function getDetailFields(): array
    {
        return [
            Field::string('Заголовок', 'title'),
            Field::image('Изображение на списке', 'image'),
            Field::image('Изображение детальное', 'images'),
            Field::textarea('Анонс', 'description'),
            Field::redactor('Содержание', 'text'),
            Field::date('Дата публикации', 'published_on'),
            Field::number('Просмотры', 'viewed'),
            Field::checkbox('Активность', 'is_active'),
        ];
    }

    /**
     * @return AbstractForm
     */
    public function getForm(): AbstractForm
    {
        return new AdminForm([
            [['title', 'text'], 'required', [], AdminForm::MESSAGE_REQUIRED],
            [['description', 'published_on', 'image', 'images', 'viewed', 'is_active']],
        ]);
    }
}
