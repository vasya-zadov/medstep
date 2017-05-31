<?php
/* @var $this GalleryphotoController */
/* @var $model GalleryPhoto */

$this->breadcrumbs=array(
	'Галереи'=>array('gallery/index'),
	$model->gallery->caption=>array('gallery/view','id'=>$model->gallery->id),
	'Добавить фото',
);

$this->menu=array(
	array('label'=>'Назад', 'url'=>array('gallery/view','id'=>$model->gallery->id)),
);
?>

<h1>Добавить фото</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>