<?php
/* @var $this NewsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('moduleCaptions','News'),
);

$this->menu=array(
	array('label'=>Yii::t('menuItems','Create News post'), 'url'=>array('create')),
);
?>

<?php 
foreach($models as $model)
{	
	$this->renderPartial('_view',array('model'=>$model));
}
?>
