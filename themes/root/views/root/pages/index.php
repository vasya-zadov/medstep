<?php
/* @var $this PagesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('moduleCaptions','Pages'),
);

$this->menu=array(
	array('label'=>Yii::t('menuItems','Create Page'), 'url'=>array('create')),
);
?>

<?php 
foreach($models as $model)
{	
	$this->renderPartial('_view',array('model'=>$model));
}
?>
