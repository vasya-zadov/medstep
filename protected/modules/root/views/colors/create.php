<?php
/* @var $this SliderController */
/* @var $model Slider */

$this->menu = array(
    array('label'=>'Цвета','url'=>array('index')),
);
$this->breadcrumbs = array(
    'Цвета'=>array('index'),
    'Добавить цвет'
);
?>



<?php $this->renderPartial('_form',array('model'=>$model)); ?>