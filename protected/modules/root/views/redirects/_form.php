<?php
/* @var $this RedirectsController */
/* @var $model Redirects */
/* @var $form CActiveForm */
?>
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
    <div class="row">
        <?php echo $form->labelEx($model, 'redirectFrom'); ?>
        <?php echo $form->textField($model, 'redirectFrom'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'redirectTo'); ?>
        <?php echo $form->textField($model, 'redirectTo'); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>