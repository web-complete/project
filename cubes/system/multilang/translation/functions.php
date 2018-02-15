<?php

use cubes\system\multilang\translation\MultilangHelper;

if (!function_exists('t')) {
    function t(string $text, string $namespace = '', string $langCode = null)
    {
        return MultilangHelper::getText($text, $namespace, $langCode);
    }
}
