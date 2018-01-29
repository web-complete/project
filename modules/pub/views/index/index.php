<?php
global $application;

use cubes\content\staticBlock\StaticBlockHelper;

/** @var \cubes\content\article\Article $article */

$search = $application->getContainer()->get(\cubes\search\search\SearchService::class);
$docs = $search->search(new \WebComplete\core\utils\paginator\Paginator(), 'aaa');
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
