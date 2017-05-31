<?php

/*
 * The MIT License
 *
 * Copyright 2016 Alexander Larkin <lcdee@andex.ru>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Description of Installer
 *
 * @author Alexander Larkin <lcdee@andex.ru>
 */
class Installer
{
    private function __construct()
    {
        
    }
    public static function install($values)
    {
        $instance = new self;
        $instance->makeConfigFile($values);
        $instance->makeDirectories();
        $instance->buildSqls($values);
        $instance->insertUsers($values);
        return true;
    }
    public function makeConfigFile($values)
    {
        file_put_contents(dirname(__FILE__).'/../../config/main.php',$this->renderInternal(dirname(__FILE__).'/config-template.php',$values));
    }
    public function buildSqls($values)
    {
        $config = Configurator::buildConfig();
        app()->setComponent('db', $config['components']['db']);
        foreach($config['params']['enabledModules'] as $module)
        {
            if(file_exists(dirname(__FILE__).'/../cmsmodules/'.$module.'/db.sql'))
            {
                $sql = $this->renderInternal(dirname(__FILE__).'/../cmsmodules/'.$module.'/db.sql',$values);
                $dbCommand = app()->db->createCommand($sql)->execute();
            }
        }
    }
    public function insertUsers($values)
    {
        $user = new Users;
        $user->name = $values['userName'];
        $user->newPassword = $values['userPassword'];
        $user->email = $values['userEmail'];
        $user->role = 'administrator';
        $user->save();
        $user = new Users;
        $user->name = $values['developerName'];
        $user->newPassword = $values['developerPassword'];
        $user->email = $values['developerEmail'];
        $user->role = 'developer';
        $user->save();
    }
    public function makeDirectories()
    {
        @mkdir(Yii::getPathOfAlias('webroot').'/imagecache',0777);
        @mkdir(Yii::getPathOfAlias('webroot').'/uploads',0777);
        @mkdir(Yii::getPathOfAlias('webroot').'/assets',0777);
    }
    public function renderInternal($_viewFile_,$_data_=null)
	{
		// we use special variable names here to avoid conflict when extracting data
		if(is_array($_data_))
			extract($_data_,EXTR_PREFIX_SAME,'data');
		else
			$data=$_data_;
        ob_start();
        ob_implicit_flush(false);
        require($_viewFile_);
        return ob_get_clean();
	}
}
