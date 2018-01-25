# Работа со статикой

За работу со статикой отвечает куб **cubes/content/staticBlock**

### Типы полей

На данный момент статические блоки поддерживают следующие типы полей:
```php
        self::TYPE_STRING => 'Строка',
        self::TYPE_TEXT => 'Текст',
        self::TYPE_HTML => 'Html',
        self::TYPE_IMAGE => 'Изображение',
        self::TYPE_IMAGES => 'Изображения',
```

### Добавление новых типов

Для добавления новых типов статических блоков необходимо внести изменения
в StaticBlockService, StaticBlockHelper и в cubes\content\staticBlock\admin\Controller.

С большой вероятностью, если требуется сложное составное поле, то, возможно,
это правильнее решить созданием кастомной страницы или специальной сущности.

### Механизм создания/вывода статики в публичной части

Для создания и вывода статики в публичной части для удобства разработан **StaticBlockHelper**,
который является фасадом для сервиса StaticBlockService и предоставляет следующие методы:

```php
    public static function get(string $namespace, string $name, int $type, string $langCode = null);
    public static function begin(string $namespace, string $name, int $type, string $langCode = null);
    public static function end();
```

Метод **get()** попробует загрузить (и создать, если не создан) статический блок и вернуть его контент.

Методы **begin()** и **end()** позволяют обернуть статические тексты или html из верстки
и создать на их основе статический блок, либо вернуть контент уже созданного блока.

Примеры использования:
```php
    <div class="some-static-content">
        <?=StaticBlockHelper::get('main-page', 'text-on-top', StaticBlockHelper::TYPE_TEXT) ?>
        <div class="image">
            <?php $imageId = StaticBlockHelper::get('main-page', 'some-image', StaticBlockHelper::TYPE_IMAGE); ?>
            <?=ImageHelper::getTag($imageId) ?>
        </div>
    </div>
```
```php
    <div class="some-static-content">
        <?=StaticBlockHelper::begin('main-page', 'text-on-top', StaticBlockHelper::TYPE_TEXT) ?>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
            ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
            fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
            mollit anim id est laborum.
        <?=StaticBlockHelper::end() ?>
    </div>
```

Далее: [Работа с уведомлениями](notifications.md)<br>
Вверх: [Оглавление](index.md)