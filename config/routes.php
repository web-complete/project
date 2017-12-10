<?php

use modules\admin\controllers\AuthController;
use modules\admin\controllers\IndexController;
use modules\admin\controllers\UploadController;
use WebComplete\mvc\router\Routes;

return new Routes([
    ['GET', '/admin/login', [AuthController::class, 'actionLogin']],
    ['POST', '/admin/api/upload', [UploadController::class, 'actionUpload']],
    ['POST', '/admin/api/auth', [AuthController::class, 'actionAuth']],
    ['GET', '/admin', [IndexController::class, 'actionApp']],
]);
