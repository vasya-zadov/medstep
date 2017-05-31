<?php
/* @var $this DoctorsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('moduleCaptions','Врачи'),
);

$this->menu=array(
	array('label'=>Yii::t('menuItems','Добавить врача'), 'url'=>array('create')),
);
?>

<?php 
$count = count($models);
foreach($models as $k=>$model)
{	
	$this->renderPartial('_view',array('model'=>$model,'index'=>$k,'count'=>$count));
}
?>
