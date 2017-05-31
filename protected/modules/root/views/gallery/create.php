<?php
/* @var $this GalleryController */
/* @var $model Gallery */

$this->breadcrumbs=array(
	'Галереи'=>array('index'),
	'Добавить',
);

$this->menu=array(
	array('label'=>'Назад', 'url'=>array('index')),
);
?>

<h1>Добавить галерею</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>