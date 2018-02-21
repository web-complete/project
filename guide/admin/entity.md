# CMS. Управление сущностями

Для того, чтобы сущностью можно было управлять в CMS,
необходимо добавить соответствующий функционал в структуру куба.

## Структура куба

Помимо файлов структуры, описанных в разделе [Cущности (Entity)](../entity.md),
требуется добавить следующие файлы:

```
article/
    admin/
        Controller.php - api-контроллер для сущности
    ArticleConfig.php - конфигурация сущности для CMS
```
**Контроллер** наследуется от стандартного CRUD-контроллера AbstractEntityController и
в минимально-необходимом виде выглядит так:

```php
namespace cubes\content\article\admin;

use cubes\content\article\ArticleConfig;
use modules\admin\controllers\AbstractEntityController;

class Controller extends AbstractEntityController
{
    protected $entityConfigClass = ArticleConfig::class;
}
```
При необходимости, можно переопределить любые методы и свойства родительского CRUD-контроллера. 

**Конфиг** ArticleConfig.php наследуется от EntityConfig и позволяет удобно и в одном месте настроить
сущность для работы с CMS. Детально описано ниже.

Непосредственное подключение куба к CMS происходит в Cube.php, в методе bootstrap,
в который требуется добавить следующие строки:

```php
    public function bootstrap(ContainerInterface $container)
    {
        $entityConfig = $container->get(ArticleConfig::class);
        $cubeHelper = $container->get(CubeHelper::class);
        $cubeHelper->defaultCrud($entityConfig);
    }
```

Тут происходит следующая магия. Мы получаем хелпер CubeHelper,
который по сути является фасадом для подключения куба к CMS.
При необходимости, можно взять код из хэлпера и модифицировать под свои нужды.
Если заглянуть в CubeHelper::defaultCrud, которому мы передаем конфиг сущности,
то увидим, что на основании этого конфига происходит следующее:

```php
    public function defaultCrud(EntityConfig $entityConfig)
    {
        // получаем параметры сущности
        $name = $entityConfig->getSystemName();
        $titleList = $entityConfig->titleList;
        $controllerClass = $entityConfig->controllerClass;
        $menuSectionName = $entityConfig->menuSectionName;
        $menuItemSort = $entityConfig->menuItemSort;
        $menuSectionSort = $entityConfig->menuSectionSort;

        // добавляем стандартные бэкенд-маршруты, настроенные на контроллер сущности
        $this
            ->addBackendRoute(['GET', "/admin/api/entity/$name", [$controllerClass, 'actionList']])
            ->addBackendRoute(['GET', "/admin/api/entity/$name/{id}", [$controllerClass, 'actionDetail']])
            ->addBackendRoute(['POST', "/admin/api/entity/$name/{id}", [$controllerClass, 'actionSave']])
            ->addBackendRoute(['DELETE', "/admin/api/entity/$name/{id}", [$controllerClass, 'actionDelete']])
            ->observeEntityTagField($entityConfig) // поддерживаем функционал тэгов
            ->observeEntitySearch($entityConfig) // поддерживаем функционал поиска
            ->observeEntitySeo($entityConfig); // поддерживаем функционал seo

        // добавляем раздел (если еще не создан) и ссылку на страницу в левое меню CMS
        if ($entityConfig->menuEnabled) {
            $this
                ->addMenuSection($menuSectionName, $menuSectionSort)
                ->addMenuItem($menuSectionName, $titleList, "/list/$name", $menuItemSort);
        }

        return $this;
    }
```

Как можно заметить, vue-маршрут не настраивается, так как он идет стандартный,
как описан в разделе [CMS. Архитектура](architecture.md).
Добавление собственных маршрутов будет описана в разделе [CMS. Кастомизация сущностей](entity-customization.md). 
 
## Конфиг сущности

Ключевой класс по настройке сущности. Должен наследоваться от EntityConfig
и имплементировать следующие свойства и методы:

```php
    public $namespace = null; // нэймспэйс в snake-case. Пример: project (параметр не обязателен)
    public $name = null; // название в snake-case. Пример: order-item
    public $titleList = null; // заголовок на списке
    public $titleDetail = null; // заголовок на детальной
    public $entityServiceClass = null; // класс сервиса
    public $controllerClass = null; // класс контроллера
    public $menuEnabled = true; // включить в левое меню
    public $menuSectionName = null; // секция меню. Пример: 'контент'
    public $menuSectionSort = 100; // сортировка секции (действует, если секция не была добавлена)
    public $menuItemSort = 100; // сортировка элемента меню
    public $tagField = null; // название поля тегов, если необходимо. Пример: 'tags'
    
    // конфигурация полей сущности вынесена из Entity для удобства настройки в одном месте.
    // Для примера см. Article::fields()
    abstract public static function getFieldTypes(): array;
    
    // конфигурация полей на листинге
    abstract public function getListFields(): array;
    
    // конфигурация полей для фильтра листинга (если требуется)
    abstract public function getFilterFields(): array;
    
    // конфигурация полей для детальной страницы
    abstract public function getDetailFields(): array;
    
    // конфигурация формы и валидации полей
    abstract public function getForm(): AdminForm;
```

Для примера можно обращаться к ArticleConfig и UserConfig

### Пространство имен сущности (Namespace)

Для разрешения конфликтных ситуаций в маршрутах и правах у одноименных сунщностей используется
параметр **namespace** класса **EntityConfig**. По умолчанию пустой.
Метод **EntityConfig::getSystemName()** возвращает системное имя сущности с учетом namespace.

### getFieldTypes()

Данный метод просто проксирует настройки полей в саму сущность и имеет следующий формат:

```php
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
```

В данном примере поле published_on имеет кастомное приведение к типу (дата).
Приведение к типу происходит при установке поля через __set, set или через mapFromArray.
За подробным описанием приведения типов см. библиотеку [TypeCast](https://github.com/mvkasatkin/typecast), встроенную в Core)

### getListFields()

Метод возвращает массив объектов CellAbstract[]
Доступные поля: **string, checkbox, date, dateTime, sex**.

Каждое поле имеет взаимосвязанный vue-компонент VueCell*.

Про добавление кастомных полей см. раздел [CMS. Поля](fields.md).

```php
        $cells = CellFactory::build();
        return [
            $cells->string('ID', 'id', \SORT_DESC),
            $cells->string('Заголовок', 'title', \SORT_DESC),
            $cells->string('Просмотры', 'viewed', \SORT_DESC),
            $cells->checkbox('Активность', 'is_active', \SORT_DESC),
            $cells->date('Дата публикации', 'published_on', \SORT_DESC),
        ];
```

Третьим параметром указывается начальное направление сортировки (если пользователь кликнул на сортировку этого поля,
то первым будет выбрано данное направление). Может быть null - поле несортируемое.

### getFilterFields()

Метод возвращает пустой массив, либо массив объектов FilterAbstract[]
Доступные поля: **string, select и boolean**.
Поле string может принимать 3-м аргументом режим сравнения:
- FilterFactory::MODE_EQUAL - точное совпадение
- FilterFactory::MODE_LIKE - частичное совпадение

```php
        $filters = FilterFactory::build();
        return [
            $filters->string('ID', 'id', FilterFactory::MODE_EQUAL),
            $filters->string('Заголовок', 'title', FilterFactory::MODE_EQUAL),
            $filters->boolean('Активность', 'is_active'),
        ];
```

### getDetailFields()
Метод возвращает массив объектов FieldAbstract[]
Доступные поля: **string, number, date, dateTime, checkbox, select,
textarea, redactor, html, file, image, tags**.

Каждое поле имеет дополнительные параметры, которые можно устанавливать с помощью
т.н. fluent-interface. Так, к примеру, у строкового поля можно указать маску:
```php
$fields->string('Заголовок', 'title')->mask('+7-999-999-99-99')
```
или у поля image можно указать множественный выбор:
```php
$fields->image('Изображение', 'image')->multiple(true),
```
Итд.

Каждое поле имеет взаимосвязанный vue-компонент VueField*.

Про добавление кастомных полей см. раздел [CMS. Поля](fields.md).

```php
    $fields = FieldFactory::build();
    return [
        $fields->string('Заголовок', 'title'),
        $fields->image('Изображение на списке', 'image_list'),
        $fields->image('Изображение детальное', 'image_detail'),
        $fields->textarea('Анонс', 'description'),
        $fields->redactor('Содержание', 'text'),
        $fields->tags('Теги', 'tags', $this->entityServiceClass),
        $fields->date('Дата публикации', 'published_on'),
        $fields->number('Просмотры', 'viewed'),
        $fields->checkbox('Активность', 'is_active'),
    ];
```

### getForm()

Метод возвращает класс формы AdminForm (см библиотеку [Web Complete Form](https://github.com/web-complete/form))

```php
    return new AdminForm([
        [['title', 'text'], 'required', [], AdminForm::MESSAGE_REQUIRED],
        [['description', 'published_on', 'tags', 'image', 'images', 'viewed', 'is_active']],
    ]);
```

В сложном случае inline-описание правил можно заменить на полноценный класс формы, унаследованный от AdminForm, с методами-валидаторами, фильтрами и прочей логикой.

## Репозиторий сущности

Разделение бизнес-логики и слоя доступа к данным (репозитории) позволяет переключаться между различными типами баз данных
с минимальными накладными расходами.

Любой класс репозитория сущности, который принимает в себя сервис сущности, должен имплементировать CRUD-интерфейс
**EntityRepositoryInterface**.

С платформой поставляется две реализации данного интерфейса: MicroDB (**AbstractEntityRepositoryMicro**) и Mysql (**AbstractEntityRepositoryDb**).

Каждая сущность, которая поставляется с платформой, имеет обе реализации интерфейса.
В рамках конкретного проекта разработчик сам решает какую (какие) типы репозиториев ему поддерживать:
- **MicroDB** - рекомендуется для быстрого прототипирования или очень простых сайтов, так как работает с файлами и не имеет схемы
- **Mysql** или **Mongo** - для серьезных проектов.

Выбор конкретной реализации репозитория происходит в кубе, в определениях зависимостей (метод **registerDependencies**):
```php
    $definitions[ArticleRepositoryInterface::class] = RepositorySelector::get(
        ArticleRepositoryMicro::class,
        ArticleRepositoryDb::class
    );
```

В простом случае это выглядит вот так:
```php
    $definitions[ArticleRepositoryInterface::class] = \DI\autowire(ArticleRepositoryMicro::class);
```

Хелпер RepositorySelector выбирает тип репозитория на основании константы DB_TYPE из config/const.php
и позволяет производить быстрое переключение между типами БД, если того требует dev/prod-окружение.

Далее: [CMS. Кастомизация сущностей](entity-customization.md)<br>
Вверх: [Оглавление](../index.md)
