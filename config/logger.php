<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

return [
    'app' => [
        new StreamHandler(\dirname(__DIR__) . '/runtime/logs/app.log'),
    ],
    'js' => [
        new StreamHandler(\dirname(__DIR__) . '/runtime/logs/js.log'),
    ],
    '*' => [
        new StreamHandler(\dirname(__DIR__) . '/runtime/logs/exceptions.log', Logger::ERROR),
    ],
];
