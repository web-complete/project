<?php

return [
    'aliases' => [
        '@app' => \dirname(__DIR__ . '/..', 2),
        '@web' => \dirname(__DIR__ . '/../web', 2),
    ],
    'routes' => [
        ['GET', '/some/index', [\tests\app\controllers\SomeController::class, 'actionIndex']],
    ],
    'packageLocations' => [
    ],
    'definitions' => [
        'errorController' => \DI\object(\tests\app\controllers\ErrorController::class),
    ]
];