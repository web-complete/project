<?php

namespace WebComplete\thunder\ErrorHandler;

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;

class ErrorHandler
{

    public static function init()
    {
        (new Run())->pushHandler(\DEV
            ? new PrettyPageHandler()
            : function () {
                echo 'Error 500';
            })->register();
    }
}
