<?php

/** @var \WebComplete\mvc\view\View $this */
/** @var $content */

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8"/>
    <title>Web Complete Admin Panel</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:800" rel="stylesheet">

    <script type="text/javascript">
        window.ready = function(cb){document.addEventListener("DOMContentLoaded", function(){ cb.call(window); })};
        window.$ = function(){return { ready: window.ready }};
    </script>

    <?=$this->getAssetManager()->applyCss() ?>
    <?=$this->render('@admin/views/layouts/theme.php') ?>
</head>
<body>
    <?=$content ?>
    <?=$this->getAssetManager()->applyJs() ?>
</body>
</html>