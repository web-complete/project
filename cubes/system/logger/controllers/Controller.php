<?php

namespace cubes\system\logger\controllers;

use cubes\system\logger\Log;
use Monolog\Logger;
use WebComplete\mvc\controller\AbstractController;

class Controller extends AbstractController
{

    public function actionLog()
    {
        $level = $this->request->get('level', Logger::INFO);
        $message = $this->request->get('message');
        $category = $this->request->get('category', 'js');
        Log::log($level, $message, $category);
        return $this->responseJson([]);
    }
}
