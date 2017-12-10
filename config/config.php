<?php

return [
    'aliases' => require 'aliases.php',
    'routes' => require 'routes.php',
    'commands' => require 'commands.php',
    'cubesLocations' => [
        __DIR__ . '/../modules',
        __DIR__ . '/../cubes',
    ],
    'definitions' => require 'definitions.php',
    'settings' => require 'settings.php',
    'salt' => 'SomeSecretWord',
];
