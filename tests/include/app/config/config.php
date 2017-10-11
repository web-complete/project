<?php

return [
    'aliases' => [
        '@app' => \dirname(__DIR__ . '/..', 2),
        '@web' => \dirname(__DIR__ . '/../web', 2),
    ],
    'routes' => [
        ['GET', '/some/index', [\tests\app\controllers\SomeController::class, 'actionIndex']],
        ['GET', '/some/layout', [\tests\app\controllers\SomeController::class, 'actionLayout']],
        ['GET', '/some/partial', [\tests\app\controllers\SomeController::class, 'actionPartial']],
        ['GET', '/some/json', [\tests\app\controllers\SomeController::class, 'actionJson']],
        ['GET', '/some/redirect', [\tests\app\controllers\SomeController::class, 'actionRedirect']],
        ['GET', '/some/not-found', [\tests\app\controllers\SomeController::class, 'actionNotFound']],
        ['GET', '/some/access-denied', [\tests\app\controllers\SomeController::class, 'actionAccessDenied']],
        ['GET', '/some/system-error', [\tests\app\controllers\SomeController::class, 'actionSystemError']],
    ],
    'packageLocations' => [
    ],
    'definitions' => [
        'errorController' => \DI\object(\tests\app\controllers\ErrorController::class),
    ]
];