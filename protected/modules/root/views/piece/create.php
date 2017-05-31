<?php
/* @var $this SliderController */
/* @var $model Slider */

$this->menu = array(
    array('label'=>'Вставки','url'=>array('index')),
);
$this->breadcrumbs = array(
    'Вставки'=>array('index'),
    'Добавить вставку'
);
?>



<?php $this->renderPartial('_form',array('model'=>$model)); ?>