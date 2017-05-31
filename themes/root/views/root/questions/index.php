<?php foreach($models as $model): ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-11"><strong><?= $model->id; ?>) <?= app()->dateFormatter->format('d.mm.y', $model->date); ?></strong> <?= $model->name; ?> &lt;<?= $model->email; ?>&gt; IP: <?= $model->ip; ?></div>
                <div class="col-md-1">
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
                    !$model->isModerated ?
                        CHtml::link('<i class="glyphicon glyphicon-check"></i>', array(
                            'visibility',
                            'id' => $model->id), array(
                            'title' => Yii::t('menuItems', 'Отобразить на сайте'))) : '';
                    ?>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <?= $model->text; ?>
            <?php
            $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id'                   => 'question-form-'.$model->id,
                'action'               => array('update', 'id' => $model->id),
                'enableAjaxValidation' => true,
                'clientOptions'        => array(
                    'validateOnSubmit' => true
                )
            ));
            ?>
            <?= $form->errorSummary($model); ?>
            <?= $form->textAreaGroup($model, 'answer', array('widgetOptions' => array('htmlOptions' => array('rows' => 6)))); ?>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-10">
                        <?php if(user()->hasFlash('success-'.$model->id)): ?>
                            <div id="success-<?= $model->id; ?>" class="alert alert-success" style="text-align: left; margin-bottom: 0px;" role="alert">
                                <?= user()->getFlash('success-'.$model->id); ?>
                            </div>
                            <?php clientScript()->registerScript('dismiss-success-'.$model->id,'$("#success-'.$model->id.'").delay(3000).slideUp();'); ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-2">
                        <?php
                        $this->widget('booster.widgets.TbButton', array(
                            'buttonType' => 'submit',
                            'label'      => Yii::t('formFields', 'Save'),
                            'context'    => 'primary'));
                        ?>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
<?php endforeach; ?>
