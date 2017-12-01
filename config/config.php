<?php

return [
    'aliases' => require 'aliases.php',
    'routes' => require 'routes.php',
    'commands' => require 'commands.php',
    'cubesLocations' => [
        __DIR__ . '/../admin',
        __DIR__ . '/../cubes',
    ],
    'definitions' => require 'definitions.php',
    'salt' => 'SomeSecretWord',
];
