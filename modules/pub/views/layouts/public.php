<?php

use cubes\system\settings\Settings;
use modules\pub\widgets\FooterWidget;
use modules\pub\widgets\HeaderWidget;
use cubes\multilang\translation\MultilangHelper;

/** @var \WebComplete\mvc\view\View $this */
/** @var $content */

$settings = $this->getContainer()->get(Settings::class);
$headerWidget = $this->getContainer()->get(HeaderWidget::class);
$footerWidget = $this->getContainer()->get(FooterWidget::class);

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title></title>
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
    Translations.data = <?=json_encode(MultilangHelper::getTextMap()) ?>;
</script>

</body>
</html>
