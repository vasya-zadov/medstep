<?php
/* @var $this NewsController */
/* @var $model News */

$this->breadcrumbs=array(
	Yii::t('moduleCaptions','News')=>array('index'),
	Yii::t('menuItems','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('menuItems','Back'), 'url'=>array('index')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>