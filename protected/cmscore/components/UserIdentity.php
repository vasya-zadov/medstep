<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	private $_id;
	
	protected function authUser($user)
	{
		$this->_id=$user->id;
	//	$this->setState('title', $user->nick);
		$this->setState('name', empty($user->name)?$user->email:$user->name);
		
	//	$this->setState('avatar', empty($user->avatar)?Yii::app()->params['defaultUserMiniIco']:$user->avatar);
		{ // cookie key
			$ckey=$this->generateCookieKey();
			$this->setState('ckey', $ckey);
			$user->saveAttributes(array('ckey' => $ckey));
		}
	}
	
	public function authenticate()
	{
		
		$user=Users::model()->resetScope()->findByAttributes(array('email'=>$this->username));
		
		if($user===null)
		{
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}
		else if (!CPasswordHelper::verifyPassword($this->password, $user->password)) //yii 1.1.14
	//	else if (md5(md5(md5($this->password))) !== $user->password) // Blowfish is not set.
        { 
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
		}
        else
        {
            $this->authUser($user);
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
	}
	
	public function authenticateSocial($serviceName, $identity, $userData)
	{
		$userSocial = UserSocial::model()->findByAttributes(array('service_name'=>$serviceName,'id_in_service'=>$identity->id));
		if($userSocial === null)
		{ 
			$user = new User;
			$user->name = $identity->name;
			$user->password = CPasswordHelper::hashPassword(UserSocial::generate_password(5));
			$user->socialOnly = 1;
			$user->email = $identity->id.'-'.$serviceName.'@wikea.ru';
            $user->contactEmail = $user->email;
			if(!$user->save())
				return false;
			
			$userSocial = new UserSocial;
			$userSocial->service_name = $serviceName;
			$userSocial->id_in_service = $identity->id;
			$userSocial->user_id = $user->id;		
			if(!$userSocial->save())
			{
				$user->delete();
				return false;
			} 
			$this->authUser($user);
		}
		else
		{ 
			$this->authUser($userSocial->user);
		}    
		return true;
	}
	
	public function getId()
    {
        return $this->_id;
    }
	
	private function generateCookieKey()
	{
		$base = str_shuffle('abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890@#%$*');
		return substr($base,3,10);
	}
	
}