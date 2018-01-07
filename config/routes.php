<?php

use modules\admin\controllers\AuthController;
use modules\admin\controllers\IndexController;
use modules\admin\controllers\AjaxController;
use WebComplete\mvc\router\Routes;

return new Routes([
    ['GET', '/', [\modules\pub\controllers\IndexController::class, 'actionIndex']],

    ['GET', '/admin/login', [AuthController::class, 'actionLogin']],
    ['GET', '/admin/api/ping', [AjaxController::class, 'actionPing']],
    ['POST', '/admin/api/auth', [AuthController::class, 'actionAuth']],
    ['GET', '/admin', [IndexController::class, 'actionApp']],
]);
