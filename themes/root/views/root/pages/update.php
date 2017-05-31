<?php
/* @var $this PagesController */
/* @var $model Pages */

$this->breadcrumbs=array(
	Yii::t('moduleCaptions','Pages')=>array('index'),
	$model->caption=>array('update','id'=>$model->id),
	Yii::t('menuItems','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('menuItems','Back'), 'url'=>array('index')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>