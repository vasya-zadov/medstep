<?php
/* @var $this ProgramsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('moduleCaptions','Программы'),
);

$this->menu=array(
	array('label'=>Yii::t('menuItems','Добавить программу'), 'url'=>array('create')),
);
?>

<?php 
foreach($models as $model)
{	
	$this->renderPartial('_view',array('model'=>$model));
}
?>
