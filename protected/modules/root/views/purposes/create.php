<?php
/* @var $this SliderController */
/* @var $model Slider */

$this->menu = array(
    array('label'=>'Использования','url'=>array('index')),
);
$this->breadcrumbs = array(
    'Использования'=>array('index'),
    'Добавить использование'
);
?>



<?php $this->renderPartial('_form',array('model'=>$model)); ?>