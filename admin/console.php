<?php

use Symfony\Component\Console\Application;

(function () {
    require __DIR__ . '/../vendor/autoload.php';

    defined('ENV') or define('ENV', 'dev');

    $config = require __DIR__ . '/../admin/config/config.php';
    $application = new \WebComplete\mvc\Application($config, false);
    $container = $application->getContainer();

    $console = new Application();
    $console->add($container->get(\WebComplete\core\utils\migration\commands\MigrationUpCommand::class));
    $console->add($container->get(\WebComplete\core\utils\migration\commands\MigrationDownCommand::class));
    $console->run();
})();
