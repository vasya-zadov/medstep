<?php
/* @var $this ProgramsController */
/* @var $model Programs */

$this->breadcrumbs=array(
	Yii::t('moduleCaptions','Программы')=>array('index'),
	Yii::t('menuItems','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('menuItems','Back'), 'url'=>array('index')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>