<?php
/* @var $this ServicesController */
/* @var $model Services */

$this->breadcrumbs=array(
	Yii::t('moduleCaptions','Услуги')=>array('index'),
	$model->caption=>array('update','id'=>$model->id),
	Yii::t('menuItems','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('menuItems','Back'), 'url'=>array('index')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>