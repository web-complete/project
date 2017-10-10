<?php

return [
    'aliases' => [
        '@app' => \dirname(__DIR__ . '/../..', 2),
        '@web' => \dirname(__DIR__ . '/../../web', 2),
        '@admin' => \dirname(__DIR__ . '/..', 2),
    ],
    'routes' => [
        ['GET', '/admin/', [\WebComplete\admin\controllers\AppController::class, 'index']],
    ],
    'packageLocations' => [
        __DIR__ . '/../packages',
    ],
    'definitions' => [
        'db' => 'mysql://root@127.0.0.1/sandbox?charset=UTF-8',
        'errorController' => \DI\object(\WebComplete\admin\controllers\ErrorController::class),
        Doctrine\DBAL\Connection::class => \DI\factory(function () {
            return \Doctrine\DBAL\DriverManager::getConnection(
                ['url' => \DI\get('db')],
                new \Doctrine\DBAL\Configuration()
            );
        }),
    ]
];