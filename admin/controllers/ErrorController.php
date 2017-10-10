<?php

namespace WebComplete\admin\controllers;

use WebComplete\thunder\controller\AbstractErrorController;

class ErrorController extends AbstractErrorController
{

    /**
     * @param \Exception $exception
     *
     * @return mixed
     * @throws \Exception
     */
    public function action403(\Exception $exception)
    {
        return 'action 403';
    }

    /**
     * @param \Exception $exception
     *
     * @return mixed
     * @throws \Exception
     */
    public function action404(\Exception $exception)
    {
        return 'action 404';
    }

    /**
     * @param \Exception $exception
     *
     * @return mixed
     * @throws \Exception
     */
    public function action500(\Exception $exception)
    {
        return 'action 500';
    }
}
