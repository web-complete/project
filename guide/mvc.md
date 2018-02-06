# MVC

Платформа работает с использованием библиотеки [Web Complete MVC](https://github.com/web-complete/mvc)

За модель отвечают классы бизнес-логики приложения, которые никак не связаны непосредственно с MVC, поэтому рассмотрим
контроллеры и представления.
 
## Контроллеры (Controller)

Контроллер должен наследоваться от WebComplete\mvc\controller\Controller или от его наследника, например:
- modules\admin\controllers\Controller
- modules\pub\controllers\Controller

Основные моменты:
- в конструктор контроллера передается $container, для доступа к сервисам приложения.
Контейнер доступен по **$this->container**
- В контроллере доступен Request: **$this->request** ([Symfony HTTP foundation](https://symfony.com/doc/2.7/components/http_foundation.html))
- В контроллере доступен Response: **$this->response** ([Symfony HTTP foundation](https://symfony.com/doc/2.7/components/http_foundation.html))
- В контроллере доступен объект View: **$this->view**
- В контроллере можно указать layout: **protected $layout = '@pub/views/layouts/main.php'**

## Действия (action)

определяются обычными методами с префиксом action: actionIndex, actionList, actionSave итд.

### предобработка: beforeAction()

Метод позволяет провести предварительные проверки перед действием, например проверить права доступа.

По умолчанию метод возвращает true, что означает передать выполнение непосредственно действию.
Если метод возвращает !== true (string или Response), то действие не вызывается, ответ отправляется клиенту.

Выполняется перед любым действием.

### постобработка: afterAction($result)

Метод позволяет провести дополнительную обработку ответа действия.

Выполняется после любого действия (которому было передано управление).

### Получение входных данных

GET-параметры, определенные в маршруте, передаются в качестве аргументов метода действия.
Допусти определен маршрут с параметром id:
```php
['GET', "/admin/api/entity/user/{id}", [UserController::class, 'actionDetail']
```

Таким образом, метод действия получает параметр $id в своих аргументах:
```php
    /**
     * @param $id
     * @return Response
     */
    public function actionDetail($id): Response
    {
        ...
    }
```

Также GET- и POST- параметры можно получать из Request ([Symfony HTTP foundation](https://symfony.com/doc/2.7/components/http_foundation.html)):
```php
        $id = (int)$this->request->get('id');
        $data = (array)$this->request->request->all();
```

### Формирование ответа

Ответом действия может являться либо строка (string), либо Response.
Строка возвращается клиенту без учета различных заголовков, поэтому лучше использовать честный ответ.
Для этого предусмотрены следующие методы-хэлперы:
```php
        // json-ответ
        return $this->responseJson(['result' => true]));
```
```php
        // html-ответ view + layout (если указан в свойствах класса)
        return $this->responseHtml('@pub/views/user/detail.php', $vars));
```
```php
        // html-ответ view без layout
        return $this->responseHtmlPartial('@pub/views/user/detail.php', $vars));
```
```php
        // редирект
        return $this->responseRedirect('/', 302, $headers = []));
```
```php
        // 404
        return $this->responseNotFound();
```
```php
        // 403
        return $this->responseAccessDenied();
```

## Представления (View)

В шаблоне представления, помимо переданных переменных, доступны следующие объекты и методы:
- **$this** - WebComplete\mvc\view\View
- **$this->getController(): Controller** - текущий контроллер
- **$this->getContainer(): Container** - контейнер приложения
- **$this->getAssetManager(): AssetManager** - менеджер ассетов
- **$this->render($path, array $vars = []): string** - рендеринг вложенных шаблонов

## Виджеты (Widget)

Виджеты - это вспомогательные компоненты UI, имеющие свою логику (контроллер) и шаблон.
Виджеты могут располагаться в отдельной папке и иметь, например, следующую структуру:

```
modules/pub/
    widgets/
        views/
            HeaderWidget/
                template.php
            FooterWidget/
                template.php
        HeaderWidget.php
        FooterWidget.php
```

Контроллер виджета наследуется от WebComplete\mvc\widget\AbstractWidget и реализует метод-действие **run(array $params = []): string**.
В действии доступен метод **render()**, работающий по аналогии с аналогичным методом во View.

Вызов виджета внутри шаблона выглядит следующим образом (пример layout):
```php
<?php
/** @var $content */
$headerWidget = $this->getContainer()->get(HeaderWidget::class);
$footerWidget = $this->getContainer()->get(FooterWidget::class);
?>

<body>
    <?=$this->getAssetManager()->applyCss() ?>
    <?=$headerWidget->run(); ?>
    <?=$content ?>
    <?=$footerWidget->run(); ?>
    <?=$this->getAssetManager()->applyJs() ?>
</body>
```

Далее: [CMS](admin/index.md)<br>
Вверх: [Оглавление](index.md)
