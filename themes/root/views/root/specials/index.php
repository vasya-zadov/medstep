<?php
/* @var $this SpecialsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('moduleCaptions','Акции'),
);

$this->menu=array(
	array('label'=>Yii::t('menuItems','Добавить акцию'), 'url'=>array('create')),
);
?>

<?php 
foreach($models as $model)
{	
	$this->renderPartial('_view',array('model'=>$model));
}
?>
