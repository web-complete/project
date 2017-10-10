<?php

namespace WebComplete\thunder\ErrorHandler;

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;

class ErrorHandler
{

    private $errorPagePath = '';

    public function register()
    {
        (new Run())->pushHandler(\ENV === 'dev'
            ? new PrettyPageHandler()
            : function () {
                $errorPagePath = $this->getErrorPagePath();
                if ($errorPagePath && \file_exists($errorPagePath)) {
                    echo \file_get_contents($errorPagePath);
                } else {
                    echo 'System error';
                }
            })->register();
    }

    /**
     * @return string
     */
    public function getErrorPagePath(): string
    {
        return $this->errorPagePath;
    }

    /**
     * @param string $errorPagePath
     */
    public function setErrorPagePath(string $errorPagePath)
    {
        $this->errorPagePath = $errorPagePath;
    }

}
