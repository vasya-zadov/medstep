<?php
/* @var $this ServicesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('moduleCaptions','Услуги'),
);

$this->menu=array(
	array('label'=>Yii::t('menuItems','Добавить услугу'), 'url'=>array('create')),
);
?>

<?php 
foreach($models as $model)
{	
	$this->renderPartial('_view',array('model'=>$model));
}
?>
