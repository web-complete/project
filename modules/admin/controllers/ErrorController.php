<?php

namespace modules\admin\controllers;

use WebComplete\mvc\controller\AbstractErrorController;

class ErrorController extends AbstractErrorController
{

    /**
     * @param \Exception|null $exception
     *
     * @return mixed
     * @throws \Exception
     */
    public function action403(\Exception $exception = null)
    {
        return $this->responseHtmlPartial('@admin/views/error/common.php', ['status' => 403]);
    }

    /**
     * @param \Exception|null $exception
     *
     * @return mixed
     * @throws \Exception
     */
    public function action404(\Exception $exception = null)
    {
        return $this->responseHtmlPartial('@admin/views/error/common.php', ['status' => 404]);
    }

    /**
     * @param \Exception|null $exception
     *
     * @return mixed
     * @throws \Exception
     */
    public function action500(\Exception $exception = null)
    {
        return $this->responseHtmlPartial('@admin/views/error/common.php', ['status' => 500]);
    }
}
