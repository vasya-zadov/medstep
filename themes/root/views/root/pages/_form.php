<?php
/* @var $this PagesController */
/* @var $model Pages */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id'                   => 'pages-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note"><?=Yii::t('formFields','Field marked with star (<span class="required">*</span>) are required.');?></p>

    <?php echo $form->errorSummary($model); ?>
    <div class="col-md-12">
        <?php
        echo $form->textFieldGroup($model, 'caption', array(
            'size'      => 60,
            'maxlength' => 255));
        ?>
    </div>
    <div class="col-md-12">
        <?php
        echo $form->textFieldGroup($model, 'alias', array(
            'size'      => 60,
            'maxlength' => 255));
        ?>
    </div>
    <?php
    $this->widget('ext.CAutoTranslit.CAutoTranslit', array(
        'options' => array(
            'src' => 'Pages_caption',
            'dst' => 'Pages_alias'
        )
    ));
    ?>
    <div class="col-md-12">
        <?php
        echo $form->textFieldGroup($model, 'headingOne', array(
            'size'      => 60,
            'maxlength' => 255));
        ?>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-6">
        <?php
        echo $form->textAreaGroup($model, 'description', array(
            'rows' => 6,
            'cols' => 50));
        ?>
    </div>
    <div class="col-md-6">
        <?php
        echo $form->textAreaGroup($model, 'keywords', array(
            'rows' => 6,
            'cols' => 50));
        ?>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php
            echo $form->labelEx($model, 'image', array(
                'class' => 'control-label'));
            ?>
            <?php
            $this->widget('ext.elFinder.ServerFileInput', array(
                'model'          => $model,
                'attribute'      => 'image',
                'connectorRoute' => 'root/elfinder/connector',
                'htmlOptions'    => array(
                    'class' => 'input-group'
                )
            ));
            ?>
            <?php echo $form->error($model, 'image'); ?>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
        <?php
        echo $form->ckEditorGroup($model, 'text', array(
            'widgetOptions'=>array(
            'editorOptions'=>array(
                'filebrowserBrowseUrl' => Yii::app()->createUrl('root/elfinder/browse'),
                'allowedContent'       => true
            ))
        ));
        ?>
    </div>
    <div class="clearfix"></div>
    
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

</div><!-- form -->