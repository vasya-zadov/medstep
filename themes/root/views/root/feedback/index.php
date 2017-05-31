<?php
    /* @var $this AdminControllerBase */
	$this->breadcrumbs=array(
		Yii::t('moduleCaptions','Feedback')
	);
	$this->menu=array(
		//array('label'=>Yii::t('menuItems','Create User'),'url'=>array('create'))
	);
?>

<?php $this->widget('booster.widgets.TbGridView',array(
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'rowCssClassExpression'=>'$data->isNew?"warning":""',
    'columns'=>array(
        array(
            'name'=>'id',
            'htmlOptions'=>array('width'=>'50')
        ),
        array(
            'name'=>'name',
        ),
        array(
            'name'=>'phone',
        ),
        array(
            'name'=>'theme',
        ),
        array(
            'htmlOptions'=>array('width'=>'100'),
            'class'=>'booster.widgets.TbButtonColumn',
            'template'=>'{view} {seen} {delete}',
            'buttons'=>array('seen'=>array('url'=>'createUrl("/root/feedback/seen",array("id"=>$data->id))','icon'=>'check','visible'=>'$data->isNew','label'=>Yii::t('menuItems','Set as seen')))
            //'updateButtonUrl'=>'Yii::app()->createUrl("objects/update",array("id"=>$data->subject_id))',
        )
    )
));