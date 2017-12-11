<?php

namespace modules\admin\controllers;

use Symfony\Component\HttpFoundation\Response;

class AjaxController extends AbstractController
{

    /**
     * @return Response
     */
    public function actionPing(): Response
    {
        return $this->responseJsonSuccess([]);
    }
}
