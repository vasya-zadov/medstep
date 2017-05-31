<?php
/* @var $this RedirectsController */
/* @var $models Redirects[] */
$this->menu=array(
    array('label'=>'Добавить','url'=>array('create'))
);

?>
<h1>Редиректы</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Откуда</th>
            <th>Куда</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($models as $model): ?>
        <tr>
            <td><?= $model->id; ?></td>
            <td><?= $model->redirectFrom; ?></td>
            <td><?= $model->redirectTo; ?></td>
            <td>
                <?=CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/assets/images/edit.png'),array('update','id'=>$model->id), array('title'=>'Редактировать'));?>
                <?=CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/assets/images/delete.png'),array('#'),array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы действительно хотите удалить данный элемент?', 'title'=>'Удалить'));?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>