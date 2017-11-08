<?php

use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Simple\NullCache;
use WebComplete\admin\controllers\AppController;
use WebComplete\admin\controllers\ErrorController;
use WebComplete\core\utils\migration\MigrationRegistryInterface;
use WebComplete\core\utils\migration\MigrationRegistryMysql;
use WebComplete\rbac\resource\ResourceInterface;

return [
    'aliases' => [
        '@app' => \dirname(__DIR__, 2),
        '@web' => \dirname(__DIR__, 2) . '/web',
        '@admin' => \dirname(__DIR__, 2) . '/admin',
    ],
    'routes' => [
        ['GET', '/admin/', [AppController::class, 'index']],
    ],
    'cubesLocations' => [
        __DIR__ . '/../../cubes',
    ],
    'definitions' => [
        'db' => 'mysql://root@127.0.0.1/project?charset=UTF8',
        'errorController' => \DI\object(ErrorController::class),
        Doctrine\DBAL\Connection::class => function (\DI\Container $di) {
            return \Doctrine\DBAL\DriverManager::getConnection(
                ['url' => $di->get('db')],
                new \Doctrine\DBAL\Configuration()
            );
        },
        MigrationRegistryInterface::class => \DI\object(MigrationRegistryMysql::class),
        CacheInterface::class => \DI\object(NullCache::class),
        ResourceInterface::class => function (\DI\Container $di) {
            $aliasService = $di->get(\WebComplete\core\utils\alias\AliasService::class);
            return new \WebComplete\rbac\resource\FileResource($aliasService->get('@app/cubes/auth/storage/rbac.data'));
        }
    ]
];