<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle='Авторизация';
$this->breadcrumbs=array(
	'Авторизация',
);
?>

<h1>Авторизация</h1>

<p>Пожалуйста, заполните все поля:</p>

<div class="form col-sm-3">
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

		<?php echo $form->textFieldGroup($model,'username'); ?>

		<?php echo $form->passwordFieldGroup($model,'password'); ?>

		<?php echo $form->checkboxGroup($model,'rememberMe'); ?>

		<?php $this->widget('booster.widgets.TbButton',array('buttonType'=>'submit','label'=>'Авторизоваться','context'=>'primary')); ?>

<?php $this->endWidget(); ?>
</div><!-- form -->