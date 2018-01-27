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
        $article = $articleSeo->findCurrentPageItem('super-zagolovok2');
        return $this->responseHtml('@pub/views/index/index.php', [
            'article' => $article,
        ]);
    }
}
