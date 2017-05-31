<?php

class RootModule extends CWebModule
{

    public $theme;

    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        clientScript()->scriptMap = array(
            'jquery.js' => 'https://code.jquery.com/jquery-1.8.3.js'
        );
        $this->setImport(array(
            'root.models.*',
            'root.components.*',
        ));
        app()->theme = $this->theme;

        app()->booster->init();
        $this->setupLanguage();
        $this->checkDbg();
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
        {
            // this method is called before any module controller action is performed
            // you may place customized code here
            $route = $controller->id.'/'.$action->id;
            $publicPages = array(
                'default/login',
                'default/error',
            );
            if(app()->user->isGuest && !in_array($route, $publicPages))
            {
                app()->getModule($this->id)->user->loginRequired();
            }
            else
                return true;
        }
        else
            return false;
    }

    public function setupLanguage()
    {
        if(isset(request()->cookies['language']))
        {
            app()->language = Yii::app()->request->cookies['language']->value;
        }
    }

    public function checkDbg()
    {
        $alerts = array();
        if(defined('YII_DEBUG') && YII_DEBUG)
            $alerts[] = Yii::t('errorMessages', 'Application runs in debug mode (YII_DEBUG)');
        if(app()->hasModule('gii'))
            $alerts[] = Yii::t('errorMessages', 'Gii is enabled. It is recommended to disable it for security reasons');

        setParam('adminAlerts', $alerts);
    }

}
