<?php
/* @var $this GalleryController */
/* @var $model Gallery */

$this->breadcrumbs=array(
	'Галереи'=>array('index'),
	$model->caption=>array('view','id'=>$model->id),
	'Редактировать',
);

$this->menu=array(
	array('label'=>'Назад', 'url'=>array('index')),
	array('label'=>'Просмотр галереи', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Редактировать гарелею: <?php echo $model->caption; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>