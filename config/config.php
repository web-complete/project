<?php

use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Simple\NullCache;
use admin\controllers\AppController;
use admin\controllers\ErrorController;
use Symfony\Component\Filesystem\Filesystem;
use WebComplete\core\utils\migration\MigrationRegistryInterface;
use WebComplete\core\utils\migration\MigrationRegistryMysql;
use WebComplete\microDb\MicroDb;
use WebComplete\rbac\resource\ResourceInterface;

return [
    'aliases' => [
        '@app' => \dirname(__DIR__, 1),
        '@web' => \dirname(__DIR__, 1) . '/web',
        '@admin' => \dirname(__DIR__, 1) . '/admin',
        '@storage' => \dirname(__DIR__, 1) . '/storage',
        '@runtime' => \dirname(__DIR__, 1) . '/runtime',
    ],
    'routes' => [
        ['GET', '/admin', [AppController::class, 'index']],
    ],
    'commands' => [
        \admin\commands\AdminInitCommand::class,
        \WebComplete\core\utils\migration\commands\MigrationUpCommand::class,
        \WebComplete\core\utils\migration\commands\MigrationDownCommand::class,
    ],
    'cubesLocations' => [
        __DIR__ . '/../admin',
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
        },
        \WebComplete\mvc\assets\AssetManager::class => function (\DI\Container $di) {
            $aliasService = $di->get(\WebComplete\core\utils\alias\AliasService::class);
            return new \WebComplete\mvc\assets\AssetManager(
                new Filesystem(),
                $aliasService->get('@web'),
                'assets'
            );
        }
    ],
    'salt' => 'SomeSecretWord',
];
