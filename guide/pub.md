# Публичная часть

За публичную часть отвечает модуль **modules\pub**

Контроллеры необходимо наследовать от **modules\pub\controllers\AbstractController**, который подготовлен для публичной
части, имеет подключенную защиту CSRF и реализует вспомогательные методы для работы с SEO:
- setTitle(string $title)
- setDescription(string $description)
- setKeywords(string $keywords)
- setCanonical(string $canonical)
- setNoindex(bool $noindex)


## Ассеты

Публичный модуль по умолчанию подключает два ассета - базовый и публичный.

#### Базовый ассет

**modules\pub\assets\BaseAsset** содержит в себе скрипты, необходимые для корректного функционирования
функционала платформы, такого как логгирование js-ошибок, csrf-защита, multilang-переводы, работа с cookie.
А также предоставляет объект для работы с ajax - **Request** (зависит от jquery) - самостоятельно
обрабатывает csrf-токен:
```php
Request.get(url, params, successCallback, failCallback);
Request.post(url, params, successCallback, failCallback);
Request.delete(url, params, successCallback, failCallback);
```  
А также дополнительные библиотеки, такие как Lodash, Vue. Их можно закомментировать при необходимости.

#### Публичный ассет

**modules\pub\assets\PubAsset** представляет собой пустой ассет-заготовку.

## Layout

Типовой лэйаут представляет собой следующий вид:
```php
use cubes\seo\seo\SeoManager;
use cubes\system\settings\Settings;
use modules\pub\widgets\FooterWidget;
use modules\pub\widgets\HeaderWidget;
use cubes\multilang\translation\MultilangHelper;

/** @var \WebComplete\mvc\view\View $this */
/** @var $content */

$settings = $this->getContainer()->get(Settings::class);
$seoManager = $this->getContainer()->get(SeoManager::class);
$headerWidget = $this->getContainer()->get(HeaderWidget::class);
$footerWidget = $this->getContainer()->get(FooterWidget::class);

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?=$seoManager->getTitle() ?></title>
    <?=$seoManager->renderMetaTags() ?>
    <meta charset="UTF-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <script type="text/javascript">
        window.ready = function(cb){document.addEventListener("DOMContentLoaded", function(){ cb.call(window); })};
        window.$ = function(){return { ready: window.ready }};
    </script>
    <?=$this->getAssetManager()->applyCss() ?>
</head>
<body>
<?=$settings->get('counter_yandex') ?>
<?=$settings->get('counter_google') ?>
<?=$headerWidget->run(); ?>
<?=$content ?>
<?=$footerWidget->run(); ?>
<?=$this->getAssetManager()->applyJs() ?>
<script type="text/javascript">
    Log.initHandler();
    Translations.data = <?=json_encode(MultilangHelper::getTextMap()) ?>;
</script>

</body>
</html>
```

Далее: [Деплой](deploy.md)<br>
Вверх: [Оглавление](index.md)
