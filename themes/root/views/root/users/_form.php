<div class="form">
    <?php
    /* @var $form TbActiveForm */
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id'                   => 'user-form',
        'enableAjaxValidation' => true,
        'clientOptions'        => array(
            'validateOnSubmit' => true
        )
    ));
    ?>
    
    <p class="note"><?=Yii::t('formFields','Field marked with star (<span class="required">*</span>) are required.');?></p>
    
    <?= $form->errorSummary($model); ?>
    <?= $form->textFieldGroup($model, 'name'); ?>
    <?= $form->textFieldGroup($model, 'email'); ?>
    <?= $form->passFieldGroup($model, 'newPassword'); ?>
    <?= $form->dropdownListGroup($model, 'role', array('widgetOptions'=>array('data'=>$model->rolesList))); ?>

    <div class="modal-footer">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType'  => 'link',
            'label'       => Yii::t('formFields', 'Cancel'),
            'context'     => 'default',
            'url'         => array(
                'index'),
            'htmlOptions' => array(
                'class' => 'pull-left'
        )));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType'  => 'submit',
            'label'       => Yii::t('formFields', 'Save and return'),
            'context'     => 'primary',
            'htmlOptions' => array(
                'name' => 'returnBtn',
        )));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'label'      => Yii::t('formFields', 'Save'),
            'context'    => 'primary'));
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>