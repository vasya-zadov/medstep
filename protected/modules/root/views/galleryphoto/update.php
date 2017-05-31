<?php
/* @var $this GalleryphotoController */
/* @var $model GalleryPhoto */

$this->breadcrumbs=array(
	'Галереи'=>array('gallery/index'),
	$model->gallery->caption=>array('gallery/view','id'=>$model->gallery->id),
	'Редактировать фото: '.$model->caption,
);

$this->menu=array(
	array('label'=>'Назад', 'url'=>array('gallery/view','id'=>$model->gallery->id)),
);
?>

<h1>Редактировать фото: <?php echo $model->caption; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>