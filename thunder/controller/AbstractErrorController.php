<?php

namespace WebComplete\thunder\controller;

abstract class AbstractErrorController extends AbstractController
{

    /**
     * @param \Exception $exception
     * @return mixed
     */
    abstract public function action403(\Exception $exception);

    /**
     * @param \Exception $exception
     * @return mixed
     */
    abstract public function action404(\Exception $exception);

    /**
     * @param \Exception $exception
     * @return mixed
     */
    abstract public function action500(\Exception $exception);
}
