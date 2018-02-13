<?php

use modules\Application;
use WebComplete\mvc\front\FrontController;

require __DIR__ . '/../vendor/autoload.php';

defined('ENV')
or define('ENV', in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'], false) ? 'dev' : 'prod');

$config = require __DIR__ . '/../config/config.php';
$application = new Application($config);
$front = $application->getContainer()->get(FrontController::class);
$front->dispatch()->send();
