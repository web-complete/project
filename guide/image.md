# Работа с изображениями

За работу с изображениями отвечает куб **cubes/system/file**

Допустим, сущности Article требуется иметь два типа изображений:
- для листинга с квадратными пропорциями
- для детальной несколько изображений с любыми пропорциями

Таким образом, нам необходимо:
1. добавить у сущности поля image_list, images_detail (при необходимости внести в миграцию).
Поле image_list будет хранить id одного изображения, поле images_detail будет содержать в себе массив айдишек.
2. добавить в конфиг полей необходимые поля с требуемыми параметрами:

```php
    $fields->image('Изображение на списке', 'image_list')->cropRatio(1/1),
    $fields->image('Изображение детальное', 'images_detail')->multiple(true),
```

Всё, теперь в CMS на детальной странице можно добавлять изображения.

### Механизм загрузки и добавления изображения

На фронтенде за загрузку изображение отвечает **VueFieldImage**. После загрузки изображения и кропа (если включен у поля),
изображение отправляется на бэкенд, а ответом получает его id, который устанавливает в значение поля.

На бэкенде **cubes/system/file** регистрирует свой api-контроллер **cubes\system\file\admin\Controller**, который принимает
загруженные изображения и сохраняет их в системе как файлы, с помощью сервиса **FileService**. Каждое изображение (=файл)
становится сущностью класса **File**.

### Механизм вывода изображений в публичной части

Для вывода изображения в публичной части (то есть по сути преобразования id изображения из поля сущности в url данного изображения)
для удобства разработан **ImageHelper**, который является фасадом для класса Image (управляет изображением на базе сущности File).

**ImageHelper** содержит следующие вспомогательные методы:
```php
public static function getTag($imageId, $width = null, $height = null, array $tagAttributes = []): string;
public static function getUrl($imageId, $width = null, $height = null, $defaultUrl = ''): string;
public static function getImage($imageId): ?Image;
```

1. **getTag** - вернет тег img с заполненными alt и title, а также src изображения (при необходимости можно сделать ресайз -
изменненное изображение будет сохранено в кеше). Также тегу можно указать дополнительные аттрибуты,
например ['class' => 'my-image']

2. **getUrl** - также умеет ресайзить изображение, но возвращает просто url.

3. **getImage** - вернет объект класса Image, на основе которого работают два предыдущих метода.

Примеры использования:
```php
<article>
    <div class="image">
        <?=ImageHelper::getTag($article->image_list, 200, 200, ['class' => 'article-image']) ?>
    </div>
</article>
```
```php
<article>
    <div class="image">
        <?=ImageHelper::getTag($article->image_list, 100) ?>
    </div>
</article>
```
```php
<article>
    <div class="image">
        <?=ImageHelper::getTag($article->image_list) ?>
    </div>
</article>
```
```php
<article>
    <div class="image">
        <img src="<?=ImageHelper::getUrl($article->image_list) ?>" />
    </div>
</article>
```

Далее: [Работа со статикой](static.md)<br>
Вверх: [Оглавление](index.md)
