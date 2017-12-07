<?php

use admin\controllers\AuthController;
use admin\controllers\IndexController;
use WebComplete\mvc\router\Routes;

return new Routes([
    ['GET', '/admin/login', [AuthController::class, 'actionLogin']],
    ['POST', '/admin/auth', [AuthController::class, 'actionAuth']],
    ['GET', '/admin', [IndexController::class, 'actionIndex']],
]);
