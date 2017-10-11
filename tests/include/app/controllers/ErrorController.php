<?php

namespace tests\app\controllers;

use WebComplete\thunder\controller\AbstractErrorController;

class ErrorController extends AbstractErrorController
{

    /**
     * @param \Exception|null $exception
     *
     * @return mixed
     */
    public function action403(\Exception $exception = null)
    {
        return 'error 403';
    }

    /**
     * @param \Exception|null $exception
     *
     * @return mixed
     */
    public function action404(\Exception $exception = null)
    {
        return 'error 404';
    }

    /**
     * @param \Exception|null $exception
     *
     * @return mixed
     */
    public function action500(\Exception $exception = null)
    {
        return 'error 500';
}}