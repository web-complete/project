<?php
global $application;

use cubes\content\staticBlock\StaticBlockHelper;

/** @var \WebComplete\mvc\view\View $this */
/** @var \cubes\content\article\Article $article */

$settings = $this->getContainer()->get(\cubes\system\settings\Settings::class);
$search = $application->getContainer()->get(\cubes\system\search\search\SearchService::class);
$docs = $search->search(new \WebComplete\core\utils\paginator\Paginator(), 'aaa');
?>

index template
<?=StaticBlockHelper::get('ns1', 'name1', StaticBlockHelper::TYPE_TEXT) ?>
<?=\cubes\system\file\ImageHelper::getTag($settings->get('field_image')) ?>
<!--<h1>--><?//=$article->title ?><!--</h1>-->
<!--<h2>--><?//=StaticBlockHelper::get('ns1', 'static1', StaticBlockHelper::TYPE_STRING, 'en') ?><!--</h2>-->
<div>
    <?=t('some1') ?>
</div>
<div>
    <?=t('some1', 'ns1') ?>
</div>
<div>
    <?=t('some2', 'ns2') ?>
</div>
