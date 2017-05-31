<?php
/* @var $this SliderController */
/* @var $model Slider */

$this->menu = array(
    array('label'=>'Слайдер','url'=>array('index')),
);
$this->breadcrumbs = array(
    'Слайдер'=>array('index'),
    'Редактировать слайд '.$model->caption
);
?>

<h1>Редактировать слайд &laquo;<?= $model->caption; ?>&raquo;</h2>

<?php $this->renderPartial('_form',array('model'=>$model)); ?>