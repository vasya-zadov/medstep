<?php

/**
	Модель формы регистрации
 */
class RegisterForm extends CFormModel
{

	//public $id;
	
	public $name;
	public $email;
	public $password;
	public $password2;
	public $captcha;
	public $emailSubscribe;
	
	//public $isNewRecord = true;
	
	public function init()
	{
	}
	
	public function rules()
	{
		return array(
			array('name, email, password, password2', 'required'),			
			array('name, email', 'length', 'max'=>255),			
			array('email', 'email'),
			//array('email','rule_emailunique'),	
			array('email', 'unique', 'className'=>'Users', 'attributeName'=>'email', 'caseSensitive' => 'false'),			
			array('password, password2', 'length', 'max'=>45, 'min'=>3),			
			array('password2', 'compare', 'compareAttribute'=>'password'),
			//array('captcha', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(),'on'=>'submit'),
			array('emailSubscribe','safe'),
		);
	}

	
	public function attributeLabels()
	{
		return array(
			//'id' => 'ID',
			'name' => 'Имя',
			'email' => 'E-mail',
			'password' => 'Пароль',
			'password2' => 'Повторите пароль',
		);
	}
	
	public function save()
	{
		$user = new Users;
		
		$user->name = $this->name;
		$user->email = $this->email;
                $user->role = 'user';
                
		
		$user->password =CPasswordHelper::hashPassword($this->password);
		//VarDumper::dump($user->validate());
		if ($user->save(false))
		{
			$login = new LoginForm;
			$login->username = $this->email;
			$login->password = $this->password;
            $login->login();
            return true;
		}
	}
	
}