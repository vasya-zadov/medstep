<?php
/* @var $this DoctorsController */
/* @var $data Doctors */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-10">
                <strong><?= $model->id; ?>) <?= $model->name; ?></strong>
            </div>

            <div class="col-md-2" style="text-align: right;">
                <?=
                CHtml::link('<i class="glyphicon glyphicon-pencil"></i>', array(
                    'update',
                    'id' => $model->id), array(
                    'title' => Yii::t('menuItems', 'Update')));
                ?>
                <?=
                CHtml::link('<i class="glyphicon glyphicon-trash"></i>', array(
                    '#'), array(
                    'submit'  => array(
                        'delete',
                        'id' => $model->id),
                    'confirm' => Yii::t('menuItems', 'Are you really want to delete this item?'),
                    'title'   => Yii::t('menuItems', 'Delete')));
                ?>
                 <?=
                ($index>0)?CHtml::link('<i class="glyphicon glyphicon-arrow-up"></i>', array(
                    'doctors/moveup',
                    'id' => $model->id), array(
                    'title' => 'Вверх')):'';
                ?>
                 <?=
                ($index<$count-1)?CHtml::link('<i class="glyphicon glyphicon-arrow-down"></i>', array(
                    'doctors/movedown',
                    'id' => $model->id), array(
                    'title' => 'Вверх')):'';
                ?>
                
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-2">
                <?php if(!empty($model->photo)): ?>
                    <a href="<?=
                    $this->createUrl('update', array(
                        'id' => $model->id));
                    ?>" class="thumbnail">
                       <?=
                       CHtml::image(imageUrl($model->photo, 200, 0, '1:1'), '', array(
                           'class' => 'img-responsive'));
                       ?>
                    </a>
                <?php endif; ?>
            </div>
            <div class="col-md-10">
                <?= mb_substr(strip_tags($model->text), 0, 200); ?>
            </div>
        </div>
    </div>
</div>