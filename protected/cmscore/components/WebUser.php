<?php

class WebUser extends CWebUser 
{
	private $_userModel=false;
	
    protected function beforeLogin($id, $states, $fromCookie)
	{
		if($fromCookie)
		{
			$user=Users::model()->resetScope()->findByPk($id);
			if($user->ckey == $states['ckey']) return true;
			else return false;
		}
		else return true;
	}
    function getRole() 
    {
        if($user = $this->getModel())
        {
            return $user->role;
        }
    }
	public function getModel()
	{
		if(!$this->_userModel)
		{
			$this->_userModel=Users::model()->resetScope()->findByPk($this->id);
		}
		return $this->_userModel;
	}
}