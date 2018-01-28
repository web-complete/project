# Работа с SEO

Платформа обеспечивает следующие аспекты работы с seo:
- ЧПУ
- Метатеги страницы (+OG теги)
- Sitemap.xml
- 301 редиректы

## ЧПУ

Для того, чтобы включить у сущности ЧПУ и собственные метатеги, необходимо:
1. Создать класс Seo (пример: ArticleSeo), унаследованный от AbstractEntitySeo
и определить в нем обязательные свойства: **$entityServiceClass**, **$titleField**, **$urlPrefix**
2. Добавить в класс сущности trait: **SeoEntityTrait**
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
3. в контроллере можно получить сущность с помощью метода: **ArticleSeo::findCurrentPageItem($slug)**

Пример действия в публичном контроллере:
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

Чтобы это всё заработало, в систему необходимо добавить маршрут:
```php
['GET', '/article/{slug}', [ArticleController::class, 'actionDetail']]
```

Добавить маршрут можно либо в глобальном конфиге config/routes.php,
либо в кубе модуля (Pub) - зависит от выбора разработчика.

## Метатеги

За метатеги страницы отвечает класс **SeoManager**. Он передается в публичный лэйаут,
который получает из него **title, description, keywords, canonical, noindex и og**.

Метатеги можно устанавливать тремя способами:
1. Установить для определенного url в интерфейсе CRM (**SEO -> метатеги страниц**)
2. Установить напрямую в контроллере
3. Генерировать на основании сущности в её Seo-классе (от AbstractEntitySeo)

Все три способа мержатся в контексте каждого поля и расположены в порядке приоритета.
Так, если администратор установил title в интерфейсе CRM для определенного url,
то title из Seo-класса или установленный в контроллере будет игнорироваться. И наоборот,
если для текущего url не определен title в CRM, то он будет взят у контроллера или сущности.

По умолчанию title и description берутся из **Settings** (**site_name**, **site_description**).
Если определен другой title, то site_name будет добавлен префиксом с разделителем " - ".

### Установка кастомных мета-данных у Seo-класса сущности

У Seo-класса можно переопределить методы:
**getUrl, getTitle, getDescription, getKeywords, getCanonical, getNoindex, getMetaOG**
и генерировать необходимые метатеги автоматически, на основании данных сущности.
Этот способ более предпочтителен, чем установка метатегов в контроллере.

После получения сущности в публичном контроллере с помощью метода **AbstractEntitySeo::findCurrentPageItem**,
seo-класс сущности зарегистрирует себя у SeoManager, как актуальный для текущей страницы.
Таким образом, **SeoManager** будет знать, что можно взять метатеги у сущности.

### Установка кастомных мета-данных в контроллере

В публичном контроллере **modules\pub\controllers\AbstractController**, определены вспомогательные
методы: **setTitle()**, **setDescription()**, **setKeywords()**, **setCanonical()** и **setNoindex()**

### Установка кастомных мета-данных для конкретного url

В интерфейсе CRM (**SEO -> метатеги страниц**) можно создать страницу и указать для нее метатеги.
Url является обязательным полем. Остальные поля не обязательны и могут быть пустыми, в таком случае они
будут переопределены менее приоритетными способами.

### OG-теги

У seo-класса сущности можно переопределить метод **getMetaOG** и возвращать объект класса **SeoMetaOG**,
наполненный необходимыми данными.

### Sitemap

Создать sitemap.xml можно тремя способами:

Способ 1. Сгенерировать через консольную команду:
```bash
php console.php sitemap:generate
```

Способ 2. Сгенерировать в интерфейсе CRM: **SEO -> Sitemap -> Сгенерировать**

Способ 3. Загрузить в интерфейсе CRM: **SEO -> Sitemap -> Загрузить**

Для того, чтобы система знала как генерировать sitemap, необходимо создать класс, имплементирующий интерфейс
**SeoSitemapInterface** и его единственный метод **generate**, а также зарегистрировать его в definitions.
 
По умолчанию в definitions зарегистрирован и создан следующий класс:
```php
    \cubes\seo\sitemap\SeoSitemapInterface::class => \DI\object(\modules\pub\classes\SeoSitemap::class),
```

Данный класс будет передан в **SeoSitemapProcessor**, который запустит процесс генерации.

**\modules\pub\classes\SeoSitemap** может реализовывать любой механизм генерации sitemap, но по умолчанию
использует библиотеку [samdark/sitemap](https://github.com/samdark/sitemap).

Пример **\modules\pub\classes\SeoSitemap**:
```php
class SeoSitemap implements SeoSitemapInterface
{
    ...
    /** @var array [url, priority] */
    public $staticPages = [
        ['/', 1],
        ['/about', 0.7],
    ];
    
    /**
     * @param Sitemap $sitemap
     */
    protected function generateDynamicPages(Sitemap $sitemap)
    {
        if($items = $articleService->findAll(['f_active' => 1])) {
            /** @var Article $item */
            foreach ($items as $item) {
                $time = $item->updated_on ? \strtotime($item->updated_on) : \strtotime($item->created_on);
                $sitemap->addItem($this->prefix . $item->getUrl(), $time, Sitemap::MONTHLY, 0.5);
            }
        }
    }
    ...
    // прочий вспомогательный код
}
```

_Необходимо убедиться, что у консоли или web-сервера есть доступ на запись **/web/sitemap.xml**_

### 301 редиректы

За 301-е редиректы отвечает куб **cubes/seo/redirect**.<br>
Редиректы можно настроить в интерфейсе CRM (**SEO -> 301 редиректы**)

Далее: [Работа с поиском](search.md)<br>
Вверх: [Оглавление](index.md)
