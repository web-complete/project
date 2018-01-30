# Работа с поиском

За поиск в системе отвечает куб **cubes/search/search** и его сервис **SearchService**.

**SearchService** умеет индексировать, удалять и искать документы - сущности класса **SearchDoc**. Таким образом,
чтобы что-то проиндексировать, необходимо это что-то преобразовать в сущность **SearchDoc**, которая поддерживает
следующие поля:
```php
 * @property string $item_id // id индексируемой сущности
 * @property string $type // Тип индексируемой сущности, например 'article'
 * @property string $title // Заголовок
 * @property string $content // Содержимое
 * @property string $image // Изображение, если есть
 * @property string $url // Ссылка, если есть
 * @property string $extra // Доп. контент - теги итд
 * @property float $weight // Коэффициент веса: 1, либо на усмотрение
 * @property string $lang_code // Код языка, если документ мультиязычный
```

и далее отправить в поисковый сервис на индекс:
```php
$searchService->indexDoc($doc);
```

Поиск:
```php
$paginator = new Paginator();
$docs = $searchService->search($paginator, 'my search string');
```
Только по статьям:
```php
$paginator = new Paginator();
$docs = $searchService->search($paginator, 'my search string', 'article');
```
В английском контенте:
```php
$paginator = new Paginator();
$docs = $searchService->search($paginator, 'my search string', null, 'en');
```

## Индексация сущностей

Для того, чтобы сущность участвовала в поиске, необходимо выполнить 2 шага:
1. У конфига сущности определить свойство $searchable = true
2. У класса сущности имплементирвать интерфейс Searchable: 

```php
class Article extends AbstractMultilangEntity implements Searchable
{
    ...
    public function prepareSearchDoc(SearchDoc $doc)
    {
        $doc->type = 'article';
        $doc->item_id = $this->getId();
        $doc->title = $this->title;
        $doc->content = $this->text;
        $doc->image = $this->image_detail ? ImageHelper::getUrl($this->image_detail) : '';
        $doc->url = $this->getUrl();
        $doc->weight = 1;
        if (!$this->is_active) {
            $doc->markToDelete();
        }
    }
}
```

Остальную работу выполнит **SearchObserver**

## Консольные команды

На данный момент платформа предоставляет две команды для работы с поиском:
```bash
$ php console.php search:clear
$ php console.php search:reindex
```

## Адаптеры

Адаптер поиска - это реализация конкретного поискового движка, которую использует сервис **SearchService**.
Адаптер должен имплементировать интерфейс **SearchInterface**.

Текущий используемый адаптер необходимо зарегистрировать в definitions.php:
```php
    \cubes\search\search\SearchInterface::class => \DI\object(\cubes\search\search\adapters\NullSearchAdapter::class),
```

В платформе предусмотрены следующие адаптеры:
1. **NullSearchAdapter** - заглушка
2. **MicroSearchAdapter** - с использованием файлового [MicroDb](https://github.com/web-complete/microDb)
4. **ElasticSearchAdapter**

## ElasticSearch

ElasticSearch помимо гибкости настройки и релевантности поиска, также обеспечивает и подсветку текста тегом \<em>.

Для подключения **ElasticSearchAdapter**, в definitions.php необходимо сконфигурировать **ElasticSearchDriver**:
```php
    \cubes\system\elastic\ElasticSearchDriver::class => function () {
        return new ElasticSearchDriver('wcp', ['localhost:9200']);
    },
    SearchInterface::class => \DI\object(\cubes\search\search\adapters\ElasticSearchAdapter::class),
```

**ElasticSearchDriver** используется для доступа к elastic-серверу классами-индексами **AbstractElasticIndex**.
Данные классы-индексы обеспечивают единый интерфейс взаимодействия с ElasticSearch, на базе официальной библиотеки
[elasticsearch/elasticsearch](https://github.com/elastic/elasticsearch-php).

Поисковый адаптер **ElasticSearchAdapter** использует класс-индекс **ElasticSearchDocIndex**
(содержит логику построения запроса и матчинга), унаследованный от **AbstractElasticIndex**.

## Мультиязычный поиск

Про мультиязычный поиск см. раздел [Работа с мультиязычностью](multilang.md).

Далее: [Работа с мультиязычностью](multilang.md)<br>
Вверх: [Оглавление](index.md)
