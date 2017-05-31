<?php
/* @var $this SliderController */
/* @var $model Slider */

$this->breadcrumbs = array(
    'Использования'
);
$this->menu = array(
    array('label'=>'Добавить использование','url'=>array('create')),
);

$dataProvider = $model->search();
?>

<?php $this->widget('booster.widgets.TbGridView',array(
    'dataProvider'=>$model->search(),

   
    'columns'=>array(
        array(
            'name'=>'id',
            'htmlOptions'=>array('width'=>'50')
        ),
        array(
            'name' => 'name',
            'type' => 'raw',
            'value'=> 'CHtml::link($data->name,array(\'coupon/update\',\'id\'=>$data->id))', 
        ),
       
       
        array(
            'htmlOptions'=>array('width'=>'100'),
            'class'=>'booster.widgets.TbButtonColumn',
            'template'=>'{delete}',
            'buttons'=>array(
                
                )
            //'updateButtonUrl'=>'Yii::app()->createUrl("objects/update",array("id"=>$data->subject_id))',
        )
    )
));?>
<?php $this->widget('CLinkPager',array(
    'pages'=>$dataProvider->pagination,
));