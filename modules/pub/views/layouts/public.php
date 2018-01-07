<?php

use cubes\system\settings\Settings;

/** @var \WebComplete\mvc\view\View $this */
/** @var $content */

$settings = $this->getContainer()->get(Settings::class);

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
<?=$content ?>
<?=$this->getAssetManager()->applyJs() ?>

</body>
</html>
