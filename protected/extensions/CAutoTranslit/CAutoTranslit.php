<?php
/**
 * CJuiDateTimePicker class file.
 *
 * @author Anatoly Ivanchin <van4in@gmail.com>
 */

class CAutoTranslit
{
	//const ASSETS_NAME='/jquery-ui-timepicker-addon';
	
	//public $mode='datetime';
	
	public function init()
	{
		//return parent::init();
	}
	
	public function run()
	{
		$options=$this->options;
		
		$cs = Yii::app()->getClientScript();
		
		$assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets');
		$cs->registerScriptFile($assets.'/jquery.synctranslit.js',CClientScript::POS_END);
		$cs->registerScript('autoTranslit', "$(document).ready(function()
											 {
											 	if ($('#{$options['dst']}').val()=='')
											 	{
											 		$('#{$options['src']}').syncTranslit({destination: '{$options['dst']}'});
											 	}											 	
											 })",CClientScript::POS_END);
	}
}