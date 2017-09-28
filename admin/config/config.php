<?php

return [
    'routes' => [
        ['GET', '/post/{id:\d+}', [\WebComplete\admin\controllers\Post::class, 'test']],
    ],
    'packageLocations' => [
        __DIR__ . '/../app',
    ],
    'definitions' => [
        'db' => 'mysql://root@127.0.0.1/sandbox?charset=UTF-8',
        Doctrine\DBAL\Connection::class => \DI\factory(function () {
            return \Doctrine\DBAL\DriverManager::getConnection(
                ['url' => \DI\get('db')],
                new \Doctrine\DBAL\Configuration()
            );
        }),
    ]
];