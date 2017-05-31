<?php
/* @var $this SliderController */
/* @var $model Slider */

$this->menu = array(
    array('label'=>'Цвета','url'=>array('index')),
);
$this->breadcrumbs = array(
    'Цвета'=>array('index'),
    'Редактировать цвет '.$model->name
);
?>

<h1>Редактировать цвет &laquo;<?= $model->name; ?>&raquo;</h2>

<?php $this->renderPartial('_form',array('model'=>$model)); ?>