<?php
/* @var $this NewsController */
/* @var $model News */

$this->breadcrumbs=array(
	Yii::t('moduleCaptions','News')=>array('index'),
	$model->caption=>array('update','id'=>$model->id),
	Yii::t('menuItems','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('menuItems','Back'), 'url'=>array('index')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>