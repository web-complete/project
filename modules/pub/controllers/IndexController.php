<?php

namespace modules\pub\controllers;

use cubes\content\article\ArticleSeo;

class IndexController extends AbstractController
{

    /**
     * @throws \Exception
     */
    public function actionIndex()
    {
        $articleSeo = $this->container->get(ArticleSeo::class);
        if (!$article = $articleSeo->findCurrentPageItem('aaa1')) {
//            return $this->responseNotFound();
        }
        return $this->responseHtml('@pub/views/index/index.php', [
            'article' => $article,
        ]);
    }
}
