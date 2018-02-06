<?php

namespace cubes\system\logger\controllers;

use cubes\system\logger\Log;
use Monolog\Logger;
use WebComplete\mvc\controller\AbstractController;

class LogController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function actionLog()
    {
        $level = $this->request->get('level', Logger::INFO);
        $message = $this->request->get('message');
        $category = $this->request->get('category', 'js');

        if (!\is_string($message)) {
            $message = \json_encode($message);
        }

        Log::log($level, $message, $category);
        return $this->responseJson([]);
    }
}
