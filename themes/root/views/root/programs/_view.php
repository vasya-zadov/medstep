<?php
/* @var $this ProgramsController */
/* @var $data Programs */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-10">
                <strong><?= $model->id; ?>) <?= $model->caption; ?></strong> 
            </div>

            <div class="col-md-2" style="text-align: right;">
                <?=
                CHtml::link($model->isActive ? '<i class="glyphicon glyphicon-eye-close"></i>' : '<i class="glyphicon glyphicon-eye-open"></i>', array(
                    'visibility',
                    'id' => $model->id), array(
                    'title' => ($model->isActive ? Yii::t('menuItems', 'Hide') : Yii::t('menuItems', 'Show'))));
                ?>
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
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-2">
                <?php if(!empty($model->image)): ?>
                    <a href="<?=
                    $this->createUrl('update', array(
                        'id' => $model->id));
                    ?>" class="thumbnail">
                       <?=
                       CHtml::image(imageUrl($model->image, 200, 0, '1:1'), '', array(
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