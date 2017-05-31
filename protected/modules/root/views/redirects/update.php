<?php
/* @var $this RedirectsController */
/* @var $model Redirects */
?>
<h1><?= $model->redirectFrom; ?> &rAarr; <?= $model->redirectTo; ?></h1>

<?php $this->renderPartial('_form',array('model'=>$model)); ?>