# Работа с мультиязычностью

Мультиязычность в проекте подразумевает следующие аспекты:
- мультиязычность у определенных полей у сущностей
- мультиязычность у статических блоков
- переводы (заголовки, кнопки и прочий неуправляемый контент)

За мультиязычность отвечает нэймспэйс кубов - **cubes/multilang**, который содержит в себе кубы:
- **cubes/multilang/lang**
- **cubes/multilang/translation**

### языки

Для включения функционала мультиязычности, необходимо добавить в интерфейсе CMS добавить более одного языка в систему.
Например:

- Русский, код: ru, главный: true
- Английский, код: en

Сервис **LangService** предоставляет методы для получения всех языков, получения и установки текущего языка.

### мультиязычность у определенных полей у сущностей

Для включения мультиязычности у сущности, ее необходимо унаследовать от **AbstractMultilangEntity**. Данная
абстракция добавляет методы для работы с мультиязычными полями.

Далее, в конфиге сущности, у мультиязычных полей необходимо включить настройку **multilang**:

```php
    $fields->string('Заголовок', 'title')->multilang(),
    $fields->image('Изображение на списке', 'image_list'),
    $fields->image('Изображение детальное', 'image_detail'),
    $fields->textarea('Анонс', 'description')->multilang(),
    $fields->redactor('Содержание', 'text')->multilang(),
    $fields->tags('Теги', 'tags', $this->entityServiceClass),
    $fields->date('Дата публикации', 'published_on'),
```

Таким образом в CMS на детальной странице должна появиться возможность задавать переводы для данных полей.

В публичной части вывести мультиязычные поля можно следующим образом:
```php
    <?php
    
    $article->setLang('en');
    
    ?>
    

    <div class="title">
        <?=$article->title; ?>
    </div>
```

либо:
```php
    <div class="title">
        <?=$article->setLang('ru')->title; ?>
    </div>
    <div class="title">
        <?=$article->setLang('en')->title; ?>
    </div>
```

Механизм хранения мультиязычных полей следующий:

У **AbstractMultilangEntity** добавляется поле multilang, которое хранит в себе мапу языков и полей.
В случае установки текущего языка сущности с помощью setLang, контент будет браться из multilang (при его наличии).

Контент основного (главного) языка хранится в оригинальных полях и берется из них.

### мультиязычность у статических блоков

Статические блоки автоматически поддерживают мультиязычность, при доступности более одного языка в системе.
Механизм хранения мультиязычного контента аналогичен механизму сущности, так как по сути статические блоки являются
той же сущностью.

В публичной части StaticBlockHelper позволяет указать текущий язык последним аргументом методов:

```php
    <div class="some-static-content">
        <?=StaticBlockHelper::get('main-page', 'text-on-top', StaticBlockHelper::TYPE_TEXT, 'en') ?>
        <div class="image">
            <?php $imageId = StaticBlockHelper::get('main-page', 'some-image', StaticBlockHelper::TYPE_IMAGE); ?>
            <?=ImageHelper::getTag($imageId) ?>
        </div>
    </div>
```
```php
    <div class="some-static-content">
        <?=StaticBlockHelper::begin('main-page', 'text-on-top', StaticBlockHelper::TYPE_TEXT, 'en') ?>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
            ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
            fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
            mollit anim id est laborum.
        <?=StaticBlockHelper::end() ?>
    </div>
```


### переводы (заголовки, кнопки и прочий неуправляемый контент)

За переводы отвечает куб **cubes/multilang/translation**, сервис TranslationService

Использование в публичной части:
```php
    <button><?=t('Применить', 'feedback-form', 'en') ?></button>
```

либо в js:
```js
    alert(Translations.get('Внимание!', 'feedback-form', 'en'));
```

Если текст в системе не найден, он будет автоматически добавлен в интерфейс переводов в CMS.

## Мультиязычность и поиск

Поиск из коробки поддерживает индексирование мультиязычных сущностей.

Для самостоятельного индексироватьния мультиязычных документов, необходимо создать **SearchDoc** для каждого языка, указав
у него необходимый **lang_code** и отправить на индексацию в **SearchIndex::indexDoc**. Для поиска с учетом мультиязычности
метод **SearchIndex::search** предоставляет специальный параметр **$langCode**.

Далее: [Логгирование](logging.md)<br>
Вверх: [Оглавление](index.md)
