<?php

/**
	Модель формы смены пароля
 */
class UpdatePasswordForm extends CFormModel
{

	//public $id;
	
	public $oldPassword;
	public $newPassword1;
	public $newPassword2;
	
	//public $isNewRecord = true;
	
	public function init()
	{
	}
	
	public function rules()
	{
		return array(
			array('oldPassword, newPassword1, newPassword2', 'required'),						
			array('oldPassword, newPassword1, newPassword2', 'length', 'max'=>45, 'min'=>3),			
			array('newPassword2', 'compare', 'compareAttribute'=>'newPassword1'),
			//array('oldPassword', 'PasswValidator', 'userID' => Yii::app()->user->getId()),
			array('oldPassword', 'checkOldPassword'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'oldPassword' => Yii::t('formFields','Old password'),
			'newPassword1' => Yii::t('formFields','New password'),
			'newPassword2' => Yii::t('formFields','Repeat password')
		);
	}
	
	public function save()
	{
        if($this->validate())
        {
            $user = user()->model; 
            $user->password = CPasswordHelper::hashPassword($this->newPassword1);
            return $user->save();
        }
        return false;
	}
	public function checkOldPassword($attribute, $params)
	{
		if(empty($this->$attribute))
			return;
        if(CPasswordHelper::verifyPassword($this->$attribute, user()->model->password))
			return true;
		$this->addError($attribute,Yii::t('formMessages','Old password is incorrect'));
	}
}