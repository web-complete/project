<?php

use cubes\search\search\SearchInterface;
use cubes\system\elastic\ElasticSearchDriver;
use modules\admin\controllers\ErrorController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use WebComplete\core\utils\cache\CacheService;
use WebComplete\core\utils\migration\MigrationRegistryInterface;
use WebComplete\core\utils\migration\MigrationRegistryMysql;
use WebComplete\microDb\MicroDb;
use WebComplete\rbac\resource\ResourceInterface;

return [
    'db' => require 'db.php',
    'errorController' => \DI\object(ErrorController::class),
    Request::class => function () {
        $request = Request::createFromGlobals();
        $request->setSession(new Session());
        return $request;
    },
    MigrationRegistryInterface::class => \DI\object(MigrationRegistryMysql::class),
    CacheService::class => function () {
        $systemCache = new \Symfony\Component\Cache\Adapter\NullAdapter();
        $userCache = new \Symfony\Component\Cache\Adapter\NullAdapter();
        return new CacheService($systemCache, $userCache);
    },
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
            'assets',
            \ENV === 'prod'
        );
    },
    Swift_Transport::class => function () {
        return new \Swift_Transport_NullTransport(new Swift_Events_SimpleEventDispatcher());
    },
    \cubes\seo\sitemap\SeoSitemapInterface::class => \DI\object(\modules\pub\classes\SeoSitemap::class),
    SearchInterface::class => \DI\object(\cubes\search\search\adapters\NullSearchAdapter::class),
];
