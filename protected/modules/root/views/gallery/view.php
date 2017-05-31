<?php
/* @var $this GalleryController */
/* @var $model Gallery */
$i = 0;

$this->breadcrumbs=array(
	'Галереи'=>array('index'),
	$model->caption,
);

$this->menu=array(
	array('label'=>'Назад', 'url'=>array('index')),
	array('label'=>'Добавить фото', 'url'=>array('galleryphoto/create','id'=>$model->id)),
	array('label'=>'Редактировать галерею', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить галерею', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы действительно хотите удалить данный элемент?')),
);
?>

<h1>Галерея: <?php echo $model->caption; ?></h1>

<div class="gallery">
<?php

if (!empty($model->photos))
{
	$count = count($model->photos);
	foreach($model->photos as $photo)
	{
		$i++;
		$this->renderPartial('_photoBlock',array('model'=>$photo,'i'=>$i,'count'=>$count));
	}
}

?>
</div>