# Работа с SEO

Платформа обеспечивает следующие аспекты работы с seo:
- ЧПУ
- Мета теги страницы (+OG теги)
- Разметка Json-LD
- Sitemap.xml
- 301 редиректы

## ЧПУ

Для того, чтобы включить у сущности ЧПУ и собственные мета теги, необходимо:
1. Создать класс Seo (пример: ArticleSeo), унаследованный от AbstractEntitySeo
и определить в нем обязательные свойства: **$entityServiceClass**, **$titleField**, **$urlPrefix**
2. Добавить с класс сущности trait: **SeoEntityTrait**
3. Установить в конфиге сущности (пример: ArticleConfig) свойство: **$entitySeoClass**

Пример ArticleSeo:
```php
class ArticleSeo extends AbstractEntitySeo
{
    protected $entityServiceClass = ArticleService::class;
    protected $titleField = 'title';
    protected $urlPrefix = '/article';
}
```

Пример Article:
```php
class Article extends AbstractMultilangEntity
{
    use SeoEntityTrait;
    ...
}
```

Пример ArticleConfig:
```php
class ArticleConfig extends EntityConfig
{
    ...
    public $entitySeoClass = ArticleSeo::class;
    ...
}
```

Всё, теперь:
1. на основании title будет автоматически генерироваться [slug](https://en.wikipedia.org/wiki/Clean_URL#Slug).
2. у сущности появился метод getUrl(), возвращающий ссылку на основании urlPrefix и slug.
3. в контроллере получить сущность можно с помощью метода: **ArticleSeo::findCurrentPageItem($slug)**

Пример в публичном контроллере:
```php
    public function actionIndex($slug)
    {
        $articleSeo = $this->container->get(ArticleSeo::class);
        if (!$article = $articleSeo->findCurrentPageItem($slug)) {
            return $this->responseNotFound();
        }
        ...
    }
```

Чтобы это всё заработало, необходимо определить бэкенд-маршрут:
```php
['GET', '/article/{slug}', [ArticleController::class, 'actionDetail']]
```

## Мета теги

За мета теги страницы отвечает класс **SeoManager**. Он передается в публичный лэйаут,
который получает из него **title, description, keywords, og и jsonLd**.

Мета теги можно устанавливать тремя способами:
1. Установить мета теги для определенного url в интерфейсе CRM (**SEO -> мета теги страниц**)
2. Установить напрямую в контроллере
3. Генерировать на основании сущности в её Seo-классе (от AbstractEntitySeo)

Все три способа мержатся в контексте каждого поля и расположены в порядке приоритета.
Так, если администратор установил title в интерфейсе CRM для определенного url,
то title из Seo-класса или установленный в контроллере будет игнорироваться. И наоборот,
если для текущего url не определен title в CRM, то он будет взят у контроллера или сущности.

По умолчанию title и description берутся из **Settings** (**site_name**, **site_description**).
Если определен другой title, то site_name будет добавлен префиксом с разделителем " - ".

### Установка кастомных мета-данных у Seo-класса сущности

У Seo-класса можно переопределить методы **getUrl, getTitle, getDescription, getKeywords, getMetaOG, getMetaJsonLD**
и генерировать необходимые мета теги автоматически, на основании данных сущности.
Этот способ более предпочтителен, чем установка мета тегов в контроллере.

### Установка кастомных мета-данных в контроллере

В публичном контроллере **modules\pub\controllers\AbstractController**, определены вспомогающие
методы: **setTitle()**, **setDescription()** и **setKeywords()**

### Установка кастомных мета-данных для страницы

В интерфейсе CRM (**SEO -> мета теги страниц**) можно создать страницу и указать для нее мета теги.
Url является обязательным полем. Остальные поля не обязательны и могут быть пустыми, в таком случае они
будут переопределены менее приоритетными способами.

### OG-теги
### Json-LD
### Sitemap
### 301 редиректы

Далее: [Работа с поиском](search.md)<br>
Вверх: [Оглавление](index.md)
