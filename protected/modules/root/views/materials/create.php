<?php
/* @var $this SliderController */
/* @var $model Slider */

$this->menu = array(
    array('label'=>'Материалы','url'=>array('index')),
);
$this->breadcrumbs = array(
    'Материалы'=>array('index'),
    'Добавить материал'
);
?>



<?php $this->renderPartial('_form',array('model'=>$model)); ?>