<?php
    /* @var $this AdminControllerBase */
	$this->breadcrumbs=array(
		Yii::t('moduleCaptions','Users')
	);
	$this->menu=array(
		array('label'=>Yii::t('menuItems','Create User'),'url'=>array('create'))
	);
?>

<?php $this->widget('booster.widgets.TbGridView',array(
    'dataProvider'=>$dataProvider,
    'filter'=>$model,
    'columns'=>array(
        array(
            'name'=>'id',
            'htmlOptions'=>array('width'=>'30')
        ),
        array(
            'name'=>'name',
            'htmlOptions'=>array('width'=>'30')
        ),
        array(
            'name'=>'email',
            'htmlOptions'=>array('width'=>'30')
        ),
        array(
            'name'=>'role',
            'value'=>'$data->rolesList[$data->role]',
            'filter'=>$model->rolesList,
            'htmlOptions'=>array('width'=>'30')
        ),
        array(
            'class'=>'booster.widgets.TbButtonColumn',
            'template'=>'{update} {delete}',
            //'updateButtonUrl'=>'Yii::app()->createUrl("objects/update",array("id"=>$data->subject_id))',
        )
    )
)); ?>