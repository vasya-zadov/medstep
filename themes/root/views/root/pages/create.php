<?php
/* @var $this PagesController */
/* @var $model Pages */

$this->breadcrumbs=array(
	Yii::t('moduleCaptions','Pages')=>array('index'),
	Yii::t('menuItems','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('menuItems','Back'), 'url'=>array('index')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>