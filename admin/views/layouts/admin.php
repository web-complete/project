<?php
/** @var \WebComplete\mvc\view\View $this */
/** @var $content */
?>

<div>header</div>
<?=$this->getAssetManager()->applyCss() ?>

<?=$content ?>

<?=$this->getAssetManager()->applyJs() ?>
<div>footer</div>
