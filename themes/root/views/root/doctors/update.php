<?php
/* @var $this DoctorsController */
/* @var $model Doctors */

$this->breadcrumbs=array(
	Yii::t('moduleCaptions','Врачи')=>array('index'),
	$model->name=>array('update','id'=>$model->id),
	Yii::t('menuItems','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('menuItems','Back'), 'url'=>array('index')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>