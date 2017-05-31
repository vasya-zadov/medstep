<?php
/* @var $this SliderController */
/* @var $model Slider */

$this->menu = array(
    array('label'=>'Материалы','url'=>array('index')),
);
$this->breadcrumbs = array(
    'Материалы'=>array('index'),
    'Редактировать материал '.$model->name
);
?>

<h1>Редактировать материал &laquo;<?=$model->name; ?>&raquo;</h2>

<?php $this->renderPartial('_form',array('model'=>$model)); ?>