<?php
/* @var $this SliderController */
/* @var $model Slider */

$this->menu = array(
    array('label'=>'Слайдер','url'=>array('index')),
);
$this->breadcrumbs = array(
    'Слайдер'=>array('index'),
    'Добавить слайд'
);
?>

<h1>Добавить слайд</h2>

<?php $this->renderPartial('_form',array('model'=>$model)); ?>