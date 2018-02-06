<?php

namespace cubes\system\logger\controllers;

use modules\admin\controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use WebComplete\core\utils\alias\AliasService;
use WebComplete\core\utils\helpers\FileHelper;

class Controller extends AbstractController
{

    /**
     * @param int $num
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function actionLast($num): Response
    {
        $alias = $this->container->get(AliasService::class);
        $logFilename = $alias->get('@logs/exceptions.log');
        $rows = [];
        if (\file_exists($logFilename)) {
            if ($last = \explode("\n", FileHelper::tail($logFilename, (int)$num))) {
                $lines = \array_reverse($last);
                foreach ($lines as $line) {
                    if (\preg_match('/^\[(.*?)\]\s(.*?):\s(.*)$/', $line, $matches)) {
                        $rows[] = [
                            'date' => $matches[1] ?? null,
                            'category' => $matches[2] ?? null,
                            'message' => $matches[3] ?? null,
                        ];
                    }
                }
            }
        }
        return $this->responseJsonSuccess([
            'rows' => $rows,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function actionClear(): Response
    {
        $alias = $this->container->get(AliasService::class);
        $logFilename = $alias->get('@logs/exceptions.log');
        if (\file_exists($logFilename)) {
            \file_put_contents($logFilename, '');
        }
        return $this->responseJsonSuccess();
    }
}
