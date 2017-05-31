<?php
/* @var $this GalleryphotoController */
/* @var $model GalleryPhoto */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'gallery-photo-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля со звездочкой (<span class="required">*</span>) обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'caption'); ?>
		<?php echo $form->textField($model,'caption',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'caption'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php
		$this->widget('ext.elFinder.ServerFileInput', array(
			'model' => $model,
			'attribute' => 'image',
			'connectorRoute' => 'root/elfinder/connector',
			)
		);
		?>
		<?php echo $form->error($model,'image'); ?>
		
		<?php
			if (!empty($model->image))
			{
				echo CHtml::image($model->image, $model->caption, array('style'=>'float:right;margin-top:-30px;'));
			}
		?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->