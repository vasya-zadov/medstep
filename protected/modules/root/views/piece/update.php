<?php
/* @var $this SliderController */
/* @var $model Slider */

$this->menu = array(
    array('label'=>'Вставки','url'=>array('index')),
);
$this->breadcrumbs = array(
    'Вставки'=>array('index'),
    'Редактировать вставку '.$model->name
);
?>

<h1>Редактировать вставку &laquo;<?= $model->name; ?>&raquo;</h2>

<?php $this->renderPartial('_form',array('model'=>$model)); ?>