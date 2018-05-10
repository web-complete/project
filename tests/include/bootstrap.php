<?php

use WebComplete\core\utils\helpers\ArrayHelper;

defined('ENV') or define('ENV', 'dev');

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/AppTestCase.php';
require __DIR__ . '/MongoTestCase.php';

define('DB_TYPE', 'micro');

/** @var array[] $config */
global $config;
$config = require __DIR__ . '/../../config/config.php';
$testConfig = require __DIR__. '/config.php';

$config = ArrayHelper::merge($config, $testConfig);
