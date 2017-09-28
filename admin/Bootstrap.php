<?php

namespace WebComplete\admin;

use WebComplete\admin\base\ErrorHandler;

class Bootstrap
{

    public function run()
    {
        ErrorHandler::init();
    }
}