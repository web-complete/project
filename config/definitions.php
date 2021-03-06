<?php

use cubes\system\mongo\MigrationRegistryMongo;
use cubes\system\search\search\SearchInterface;
use modules\admin\controllers\ErrorController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use WebComplete\core\utils\cache\CacheService;
use WebComplete\core\utils\migration\MigrationRegistryInterface;
use WebComplete\rbac\resource\ResourceInterface;

return \array_merge(
    require 'db.php',
    require 'mongo.php',
    [
        'errorController' => \DI\autowire(ErrorController::class),
        Request::class => function () {
            $request = Request::createFromGlobals();
            $request->setSession(new Session());
            return $request;
        },
        MigrationRegistryInterface::class => \DI\autowire(MigrationRegistryMongo::class),
        CacheService::class => function () {
            $systemCache = new \Symfony\Component\Cache\Adapter\NullAdapter();
            $userCache = new \Symfony\Component\Cache\Adapter\NullAdapter();
            return new CacheService($systemCache, $userCache);
        },
        ResourceInterface::class => function (\DI\Container $di) {
            $aliasService = $di->get(\WebComplete\core\utils\alias\AliasService::class);
            $rbacDataFile = $aliasService->get('@storage/rbac.data');
            return new \WebComplete\rbac\resource\FileResource($rbacDataFile);
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
        \cubes\system\seo\sitemap\SeoSitemapInterface::class => \DI\autowire(\modules\pub\classes\SeoSitemap::class),
        SearchInterface::class => \DI\autowire(\cubes\system\search\search\adapters\NullSearchAdapter::class),
    ]
);
