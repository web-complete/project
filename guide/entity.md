# Сущности (Entity)

## Что такое сущность

[Из Википедии:](https://ru.wikipedia.org/wiki/%D0%9F%D1%80%D0%BE%D0%B1%D0%BB%D0%B5%D0%BC%D0%BD%D0%BE-%D0%BE%D1%80%D0%B8%D0%B5%D0%BD%D1%82%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%BD%D0%BE%D0%B5_%D0%BF%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B5#%D0%A1%D1%83%D1%89%D0%BD%D0%BE%D1%81%D1%82%D1%8C)

Проще всего сущности выражать в виде существительных: люди, места, товары и т. д.
У сущностей есть и индивидуальность, и жизненный цикл. Во время проектирования
думать о сущностях следует как о единицах поведения, нежели как о единицах данных.
Чаще всего какие-то операции, которые вы пытаетесь добавить в модель, должна
получить какая-то сущность, или при этом начинает создаваться или извлекаться новая
сущность.

В разработке, как правило, индивидуальность определяется наличием идентификатора (id).

Примеры сущностей: Article, Product, Order, OrderItem, User итд.

## Базовая структура куба сущности

Рассмотрим на примере Article (/cubes/content/article):
```
1. article/
2. article/migrations/
3. article/Cube.php
4. article/Article.php
5. article/ArticleFactory.php
6. article/ArticleService.php
7. article/ArticleRepositoryInterface.php
8. article/ArticleRepositoryDb.php
```

1. Куб ограничен директорией article
2. Куб имеет миграции, находящиеся в migrations
3. Главный класс куба. С помощью него CubeManager регистрирует куб
4. Класс сущности, наследуемый от AbstractEntity. Согласно Domain Driven Development,
сущностями являются данные и поведение, работающее с этими данными
5. Класс-фабрика, умеющий создавать данную сущность
6. Сервис - отвечает за загрузку, сохранение, удаление сущностей, а также за поведение,
которое нельзя однозначно отнести к конкретной сущности (например равнозначное взаимодействие нескольких сущностей).
7. Интерфейс репозитория сущности. Репозиторий отвечает за персистентность сущности.
С репозиторием может взаимодействовать только сервис.
8. Конкретная реализация репозитория сущности (В данном случае для базы данных).
Примеры возможных реализаций: ArticleRepositoryMongo.php, ArticleRepositoryElastic.php итд

##### Регистрация конкретной реализации репозитория

В конфигурации куба необходимо зарегистрировать конкретную реализацию репозитория:
```php
    public function registerDependencies(array &$definitions)
    {
        $definitions[ArticleRepositoryInterface::class] = \DI\autowire(ArticleRepositoryDb::class);
    }
```

##### Класс сущности

На примере Article:

```php
<?php

namespace cubes\content\article;

use cubes\system\multilang\lang\classes\AbstractMultilangEntity;

/**
 *
 * @property $title
 * @property $description
 * @property $text
 * @property $viewed
 * @property $tags
 * @property $image_list
 * @property $image_detail
 * @property $is_active
 * @property $created_on
 * @property $updated_on
 * @property $published_on
 */
class Article extends AbstractMultilangEntity
{

    /**
     * @return array
     */
    public static function fields(): array
    {
        return [
            'title' => Cast::STRING,
            'image_list' => Cast::STRING,
            'image_detail' => Cast::STRING,
            'description' => Cast::STRING,
            'text' => Cast::STRING,
            'tags' => Cast::STRING,
            'viewed' => Cast::INT,
            'is_active' => Cast::BOOL,
            'created_on' => Cast::STRING,
            'updated_on' => Cast::STRING,
            'published_on' => [AdminCast::class, 'date'],
        ];
    }
}
```

Аннотации @property обеспечивают автокомплит доступа к данным сущности по средствам магических __get и __set.

Помимо этого, у сущности есть возможность получить или изменить поле с помощью метода set/get, а также получить все данные
в виде массива или загрузить новые: mapToArray, mapFromArray.

Метод fields() определяет доступные поля сущности и их типы
(а также старается привести данные к указанным типам с помощью класса библиотеки [TypeCast](https://github.com/mvkasatkin/typecast), встроенной в Core) 

##### Гибкость или сложность?

Структура и архитектура сущности на первый взгляд может показаться избыточной,
но в долгосрочной перспективе имеет ряд плюсов, так как обладает большой гибкостью,
благодаря соблюдению принципов SOLID и DDD.

Также, стоит обратить внимание на автоматическую генерацию сущностей.
Рассмотрена в разделе [CMS. Генератор кубов](admin/generator.md).

## Интеграция сущности с Web Complete CMS

В рамках интеграции с CMS, к базовой структуре добавляются несколько дополнительных файлов,
такие как контроллер сущности, конфиг сущности и, при необходимости, кастомные шаблоны для CMS.

Особенности интеграции описаны в разделе [CMS. Управление сущностями](admin/entity.md)

Далее: [MVC](mvc.md)<br>
Вверх: [Оглавление](index.md)
