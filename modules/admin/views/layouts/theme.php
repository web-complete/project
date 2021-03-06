<?php

use modules\admin\controllers\AbstractController;

/** @var \WebComplete\mvc\view\View $this */
/** @var AbstractController $controller */
$controller = $this->getController();
$settings = $controller->settings;
$themeColor1 = $settings->get('theme_color1', '#F1A800');
$themeColor2 = $settings->get('theme_color2', '#E77E15');

?>

<style type="text/css">
    .button,
    .redactor-toolbar li a:hover,
    .redactor-dropdown a:hover,
    .form-row .selectize-control.multi .selectize-input [data-value].active,
    #redactor-modal footer button.redactor-modal-action-btn,
    .nav > ul > li._active > span,
    .nav > ul > li > ul > li._active > a::before,
    .login__button,
    .button-set button._active,
    #to-top {
        background-color: <?=$themeColor1 ?>;
    }

    .button:hover,
    .login__button:hover,
    .form-row .selectize-control.multi .selectize-input [data-value],
    #redactor-modal footer button.redactor-modal-action-btn:hover {
        background: <?=$themeColor2 ?>;
    }

    a.help:hover,
    .datepicker--day-name,
    .datepicker--cell.-current-,
    .tree-root .jstree-icon,
    .header ._logout:hover {
        color: <?=$themeColor1 ?>;
    }

    .datepicker--cell.-selected-,
    .datepicker--cell.-selected-.-focus-,
    .datepicker--cell.-selected-.-current- {
        color: #fff;
        background: <?=$themeColor2 ?>;
    }

    .button-set button._active {
        border-color: <?=$themeColor1 ?>;
    }

</style>

