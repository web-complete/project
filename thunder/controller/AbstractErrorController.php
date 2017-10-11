<?php

namespace WebComplete\thunder\controller;

abstract class AbstractErrorController extends AbstractController
{

    /**
     * @param \Exception|null $exception
     * @return mixed
     */
    abstract public function action403(\Exception $exception = null);

    /**
     * @param \Exception|null $exception
     * @return mixed
     */
    abstract public function action404(\Exception $exception = null);

    /**
     * @param \Exception|null $exception
     * @return mixed
     */
    abstract public function action500(\Exception $exception = null);
}
