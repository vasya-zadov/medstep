<?php
/* @var $this GalleryController */
/* @var $dataProvider CActiveDataProvider */
$i = 0;
$this->breadcrumbs=array(
	'Галереи',
);

$this->menu=array(
	array('label'=>'Добавить галерею', 'url'=>array('create')),
);
?>

<h1>Галереи</h1>

<div class="gallery">
<?php

$count = count($models);

foreach ($models as $model)
{
	$i++;
	$this->renderPartial('_galleryBlock',array('model'=>$model,'i'=>$i,'count'=>$count));
}

?>
<div class="clear"></div>
</div>