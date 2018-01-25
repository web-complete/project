# Работа с ассетами

Реализованы на базе библиотеки [Web Complete MVC](https://github.com/web-complete/mvc)

Ассеты наследуются от **WebComplete\mvc\assets\AbstractAsset** и позволяют хранить в едином месте (в кубе)
необходимые для фроненда файлы: css, js, изображения, шрифты итд.

Ассеты регистрируются в **AssetManager** с помощью метода **registerAsset**.

AssetManager передается во View (в том числе в layout), где может отрисовать зарегистрированные ассеты
с помощью методов **applyCss** и **applyJs**.

### Настройка ассета

- В кубе в директории assets необходимо создать класс, например, ArticleAsset, наследуемый от AbstractAsset.
- Рядом с классом создать директорию ArticleAsset, куда положить необходимые файлы

Пример ассета:
```php
class ArticleAsset extends AbstractAsset
{

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return __DIR__ . '/ArticleAsset';
    }

    /**
     * @return array
     */
    public function css(): array
    {
        return [
            'css/article.css',
            'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', // внешняя ссылка
        ];
    }

    /**
     * @return array
     */
    public function js(): array
    {
        return [
            'js/article.js',
            'https://code.jquery.com/jquery-3.3.1.min.js', // внешняя ссылка
        ]);
    }
}
```

Также у ассета можно переопределить следующие свойства абстрактного класса:
- **$publish = true** - ассет требует публикации (будет скопирован в document_root: web/assets)
- **$useLinks = true** - по возможности использовать ссылку на директорию для публикации
(в случае false, при каждом реквесте будет происходить копирование всего ассета, что сильно снижает производительность)

### Подключение дополнительных ассетов

К ассету можно подключить дополнительные ассеты с помощью методов **addAssetBefore** и **addAssetAfter**.

Данный механизм позволяет кубам подключать собственные ассеты путем добавления их к **AdminAsset**.
Таким же образом куб может зарагистрировать ассет не только для CMS, но и для публичной части.

Про склейку и минификацию ассетов будет описано в разделе [Деплой](deploy.md).

Далее: [Работа с изображениями](image.md)<br>
Вверх: [Оглавление](index.md)
