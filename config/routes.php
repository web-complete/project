<?php

use modules\admin\controllers\AuthController;
use modules\admin\controllers\IndexController;
use modules\admin\controllers\AjaxController;
use WebComplete\mvc\router\Routes;

return new Routes([
    ['GET', '/admin/login', [AuthController::class, 'actionLogin']],
    ['POST', '/admin/api/upload-file', [AjaxController::class, 'actionUploadFile']],
    ['POST', '/admin/api/update-image', [AjaxController::class, 'actionUpdateImage']],
    ['POST', '/admin/api/auth', [AuthController::class, 'actionAuth']],
    ['GET', '/admin', [IndexController::class, 'actionApp']],
]);
