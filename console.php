<?php

use Symfony\Component\Console\Application;

require __DIR__ . '/vendor/autoload.php';

defined('ENV') or define('ENV', 'dev');

/** @var array[] $config */
$config = require __DIR__ . '/config/config.php';
$application = new \modules\Application($config, false);
$container = $application->getContainer();

$console = new Application();
if (isset($config['commands'])) {
    foreach ($config['commands'] as $commandClass) {
        $console->add($container->get($commandClass));
    }
}
$console->run();
