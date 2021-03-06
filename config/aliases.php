<?php

return [
    '@app' => \dirname(__DIR__, 1),
    '@web' => \dirname(__DIR__, 1) . '/web',
    '@admin' => \dirname(__DIR__, 1) . '/modules/admin',
    '@pub' => \dirname(__DIR__, 1) . '/modules/pub',
    '@storage' => \dirname(__DIR__, 1) . '/storage',
    '@runtime' => \dirname(__DIR__, 1) . '/runtime',
    '@logs' => \dirname(__DIR__, 1) . '/runtime/logs',
];
