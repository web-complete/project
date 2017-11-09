<?php

defined('ENV') or define('ENV', 'dev');

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/AppTestCase.php';

/** @var array[] $config */
$config = require __DIR__ . '/../../config/config.php';

global $application;
$application = new \WebComplete\mvc\Application($config, false);
