<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

return [
    'app' => [
        new StreamHandler(\dirname(__DIR__) . '/runtime/logs/app.log', Logger::DEBUG),
    ],
    '*' => [
        new StreamHandler(\dirname(__DIR__) . '/runtime/logs/exceptions.log', Logger::ERROR),
    ],
];
