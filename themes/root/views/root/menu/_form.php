<?php
/* @var $this MenuController */
/* @var $model MenuForm */
/* @var $form TbActiveForm */

Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('showhide', "
	function showhide()
	{
		state = $('#MenuForm_controller').val();
		if (state === 'pages')
		{
			$('.node_id_pages').show();
			$('.node_id_news').hide();
			$('.node_id_articles').hide();
			$('.node_id_gallery').hide();
            $('.node_id_catalog').hide();
		}
		else if (state === 'news')
		{
			$('.node_id_pages').hide();
			$('.node_id_news').show();
			$('.node_id_articles').hide();
			$('.node_id_gallery').hide();
            $('.node_id_catalog').hide();
		} 
		else if (state === 'sights')
		{
			$('.node_id_pages').hide();
			$('.node_id_news').hide();
			$('.node_id_articles').show();
			$('.node_id_gallery').hide();
            $('.node_id_catalog').hide();
		} 
		else if (state === 'systems')
		{
			$('.node_id_pages').hide();
			$('.node_id_news').hide();
			$('.node_id_articles').hide();
			$('.node_id_systems').show();
            $('.node_id_catalog').hide();
		}
        else if (state === 'catalog')
		{
			$('.node_id_pages').hide();
			$('.node_id_news').hide();
			$('.node_id_articles').hide();
			$('.node_id_systems').hide();
            $('.node_id_catalog').show();
		}
		else
		{
			$('.node_id_pages').hide();
			$('.node_id_news').hide();
			$('.node_id_articles').hide();
			$('.node_id_gallery').hide();
            $('.node_id_catalog').hide();
		}
	}
	showhide();
	
	$('#MenuForm_controller').change( function() {
		showhide();
	});
");
?>

<div class="form">

    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id'                   => 'menu-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note"><?= Yii::t('formFields', 'Field marked with star (<span class="required">*</span>) are required.'); ?></p>

    <?php echo $form->errorSummary($model); ?>

    <?php
    echo $form->textFieldGroup($model, 'caption', array(
        'class' => 'span12'));
    ?>

    <?php
    Yii::import('application.extensions.CAutoTranslit.CAutoTranslit');
    $this->widget('CAutoTranslit', array(
        'options' => array(
            'src' => 'MenuForm_caption',
            'dst' => 'MenuForm_alias')
    ));
    ?>
    <?php echo $form->textFieldGroup($model, 'alias'); ?>

    <?php
    echo $form->dropdownListGroup($model, 'controller', array(
        'widgetOptions' => array(
            'data' => $model->nodes)
    ));
    ?>



    <div class="node_id_pages">
        <?php
        echo $form->dropdownListGroup($model, 'node_id_pages', array(
            'widgetOptions' => array(
                'data' => Pages::dropdownData(1))
        ));
        ?>
    </div>
    <div class="node_id_news">
        <?php
        echo $form->dropdownListGroup($model, 'node_id_news', array(
            'widgetOptions' => array(
                'data' => Pages::dropdownData(2))
        ));
        ?>
    </div>

    <?php echo $form->checkBoxGroup($model, 'active'); ?>

    <hr />

    <?php
    echo $form->dropdownListGroup($model, 'parent_id', array(
        'widgetOptions' => array(
            'data'        => $model->menu->dropdownData(),
            'htmlOptions' => array(
                'empty' => array(
                    '0' => Yii::t('formFields', 'Root menu items'))
            )
        )
    ));
    ?>

    <?php
    echo $form->textFieldGroup($model, 'title');
    ?>

    <?php
    echo $form->textFieldGroup($model, 'image');
    ?>


    <div class="modal-footer">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType'  => 'link',
            'label'       => Yii::t('formFields', 'Cancel'),
            'context'     => 'default',
            'url'         => array(
                'view',
                'id' => $model->parent_id),
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