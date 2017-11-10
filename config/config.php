<?php

use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Simple\NullCache;
use cubes\admin\controllers\AppController;
use cubes\admin\controllers\ErrorController;
use WebComplete\core\utils\migration\MigrationRegistryInterface;
use WebComplete\core\utils\migration\MigrationRegistryMysql;
use WebComplete\microDb\MicroDb;
use WebComplete\rbac\resource\ResourceInterface;

return [
    'aliases' => [
        '@app' => \dirname(__DIR__, 1),
        '@web' => \dirname(__DIR__, 1) . '/web',
        '@admin' => \dirname(__DIR__, 1) . '/cubes/admin',
        '@storage' => \dirname(__DIR__, 1) . '/storage',
        '@runtime' => \dirname(__DIR__, 1) . '/runtime',
    ],
    'routes' => [
        ['GET', '/admin/', [AppController::class, 'index']],
    ],
    'commands' => [
        \cubes\admin\commands\AdminInitCommand::class,
        \WebComplete\core\utils\migration\commands\MigrationUpCommand::class,
        \WebComplete\core\utils\migration\commands\MigrationDownCommand::class,
    ],
    'cubesLocations' => [
        __DIR__ . '/../cubes',
    ],
    'definitions' => [
        'db' => require 'db.php',
        'errorController' => \DI\object(ErrorController::class),
        MigrationRegistryInterface::class => \DI\object(MigrationRegistryMysql::class),
        CacheInterface::class => \DI\object(NullCache::class),
        Doctrine\DBAL\Connection::class => function (\DI\Container $di) {
            return \Doctrine\DBAL\DriverManager::getConnection(
                ['url' => $di->get('db')],
                new \Doctrine\DBAL\Configuration()
            );
        },
        ResourceInterface::class => function (\DI\Container $di) {
            $aliasService = $di->get(\WebComplete\core\utils\alias\AliasService::class);
            $rbacDataFile = $aliasService->get('@storage/rbac.data');
            return new \WebComplete\rbac\resource\FileResource($rbacDataFile);
        },
        MicroDb::class => function (\DI\Container $di) {
            $aliasService = $di->get(\WebComplete\core\utils\alias\AliasService::class);
            $storageDir = $aliasService->get('@storage/micro-db');
            return new MicroDb($storageDir, 'app');
        }
    ],
    'salt' => 'SomeSecretWord',
];
