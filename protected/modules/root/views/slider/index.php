<?php
/* @var $this SliderController */
/* @var $model Slider */

$this->breadcrumbs = array(
    'Слайдер'
);
$this->menu = array(
    array('label'=>'Добавить слайд','url'=>array('create')),
);

$dataProvider = $model->search();
?>
<h1>Слайдер</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Изображение</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($dataProvider->data as $k=>$row): ?>
            <tr>
                <td><?= CHtml::link($row->id,array('update','id'=>$row->id)); ?></td>
                <td><?= CHtml::link($row->caption,array('update','id'=>$row->id)); ?></td>
                <td><?= CHtml::image($row->image.'?width=70&height=70'); ?></td>
                <td>
                    <?=CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/assets/images/edit.png'),array('update','id'=>$row->id), array('title'=>'Редактировать'));?>
                <?=($k+$dataProvider->pagination->offset!==0)?CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/assets/images/up-arrow.png'),array('moveup','id'=>$row->id), array('title'=>'Упорядочить')):'';?>
                    <div class="clear"></div>
                    <?=CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/assets/images/delete.png'),array('#'),array('submit'=>array('delete','id'=>$row->id),'confirm'=>'Вы действительно хотите удалить данный элемент?', 'title'=>'Удалить'));?>
                <?=(($k+$dataProvider->pagination->offset)<$dataProvider->totalItemCount-1)?CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/assets/images/down-arrow.png'),array('movedown','id'=>$row->id), array('title'=>'Упорядочить')):'';?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $this->widget('CLinkPager',array(
    'pages'=>$dataProvider->pagination,
));