<?php
/* @var $this MenuController */
/* @var $model Menu */

$caption = array();

$bc = array(
	Yii::t('menuItems','Create')
);

if (!empty($model))
{
	$md = Menu::model()->findByPk($model->parent_id);
	if($md !== null)
	{
		$bc[$md->caption] = array('view','id'=>$md->id);
		while($md->parent !== null)
		{
			$md = $md->parent;
			$bc[$md->caption] = array('view', 'id'=>$md->id);
		}
	}
}

$bc[Yii::t('moduleCaptions','Menu')] = array('index');

$bc = array_reverse($bc);

$this->breadcrumbs=$bc;

$this->menu=array(
	array('label'=>Yii::t('menuItems','Back'), 'url'=>array('view','id'=>$model->parent_id)),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>