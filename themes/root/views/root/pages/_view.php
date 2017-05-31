<?php
/* @var $this PagesController */
/* @var $data Pages */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-10"><strong><?= $model->id; ?>) <?= $model->caption; ?> |</strong> <?= $model->dateFormatted; ?></div>
            <div class="col-md-2" style="text-align: right;">
                <?=
                CHtml::link('<i class="glyphicon glyphicon-pencil"></i>', array(
                    'update',
                    'id' => $model->id));
                ?>
                <?=
                (!in_array($model->id, $model->systemPages)) ? CHtml::link('<i class="glyphicon glyphicon-trash"></i>', array(
                        '#'), array(
                        'submit'  => array(
                            'delete',
                            'id' => $model->id),
                        'confirm' => Yii::t('menuItems','Are you really want to delete this item?'))) : '';
                ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <?= (!empty($model->description)) ? $model->description : mb_substr(strip_tags($model->text), 0, 200); ?>
    </div>
</div>