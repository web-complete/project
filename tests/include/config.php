<?php

use WebComplete\microDb\MicroDb;

return ['definitions' => [
        'mongo_db' => 'project_test',
        MicroDb::class => function (\DI\Container $di) {
            $aliasService = $di->get(\WebComplete\core\utils\alias\AliasService::class);
            $storageDir = $aliasService->get('@storage/micro-db');
            return new MicroDb($storageDir, 'app');
        }
        //        Doctrine\DBAL\Connection::class => function (\DI\Container $di) {
        //            return \Doctrine\DBAL\DriverManager::getConnection(
        //                ['url' => $di->get('db')],
        //                new \Doctrine\DBAL\Configuration()
        //            );
        //        },
    ]
];
