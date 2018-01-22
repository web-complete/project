<?php
global $application;

use cubes\content\staticBlock\StaticBlockHelper;

$articleService = $application->getContainer()->get(\cubes\content\article\ArticleService::class);
/** @var \cubes\content\article\Article $article */
$article = $articleService->findById(1);
$article->setLang('en');
?>

index template

<h1><?=$article->title ?></h1>
<h2><?=StaticBlockHelper::get('ns1', 'static1', StaticBlockHelper::TYPE_STRING, 'en') ?></h2>
<div>
    <?=t('some1') ?>
</div>
<div>
    <?=t('some1', 'ns1') ?>
</div>
<div>
    <?=t('some2', 'ns2') ?>
</div>
