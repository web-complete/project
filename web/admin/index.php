<?php

(function () {
    require __DIR__ . '/../../vendor/autoload.php';

    defined('ENV')
    or define('ENV', in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'], false) ? 'dev' : 'prod');

    $config = require __DIR__ . '/../../admin/config/config.php';
    $application = new \WebComplete\mvc\Application($config);
    $front = $application->getContainer()->get(\WebComplete\mvc\front\FrontController::class);
    $front->dispatch()->send();
})();
