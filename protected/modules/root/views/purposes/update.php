<?php
/* @var $this SliderController */
/* @var $model Slider */

$this->menu = array(
    array('label'=>'Использования','url'=>array('index')),
);
$this->breadcrumbs = array(
    'Использования'=>array('index'),
    'Редактировать испольование '.$model->name
);
?>

<h1>Редактировать испольование &laquo;<?= $model->name; ?>&raquo;</h2>

<?php $this->renderPartial('_form',array('model'=>$model)); ?>