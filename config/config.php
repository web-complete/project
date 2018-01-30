<?php

use WebComplete\core\utils\helpers\ArrayHelper;

$localConfig = \file_exists($file = 'config_local.php') ? (array)require $file : [];
require 'const.php';

$config = [
    'aliases' => require 'aliases.php',
    'routes' => require 'routes.php',
    'commands' => require 'commands.php',
    'cubesLocations' => [
        __DIR__ . '/../modules',
        __DIR__ . '/../cubes',
    ],
    'definitions' => require 'definitions.php',
    'settingsLocation' => __DIR__ . '/settings.php',
    'logger' => require 'logger.php',
    'salt' => 'SomeSecretWord',
];

return ArrayHelper::merge($config, $localConfig);
