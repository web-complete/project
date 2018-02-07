<?php

defined('ENV') or define('ENV', 'dev');

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/AppTestCase.php';

define('DB_TYPE', 'micro');

/** @var array[] $config */
global $config;
$config = require __DIR__ . '/../../config/config.php';
