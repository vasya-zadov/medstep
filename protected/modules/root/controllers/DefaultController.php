<?php

class DefaultController extends AdminControllerBase
{

    public $layout = '//layouts/column2';

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array(
                    'login',
                    'error'),
                'users'   => array(
                    '*'))
        );
    }

    public function actionIndex()
    {
        $this->pagetitle = 'Администрирование';
        $this->layout = '//layouts/column1';
        $this->render('index');
    }

    public function actionLogin()
    {
        $this->layout = '//layouts/empty';
        $model = new LoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax'] === 'login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login())
                $this->redirect(array(
                    '/root/default/index'));
        }
        // display the login form
        $this->render('login', array(
            'model' => $model));
    }

    public function actionLogout()
    {
        Yii::app()->user->logout(false);
        $this->redirect(Yii::app()->getModule($this->module->id)->user->loginUrl);
    }
    
    public function actionUserSettings()
    {
        $this->pagetitle = Yii::t('moduleCaptions','Change Password');
        $passwordModel = new UpdatePasswordForm;
        if(isset($_POST['UpdatePasswordForm']))
        {
            $passwordModel->attributes = $_POST['UpdatePasswordForm'];
            if($passwordModel->save())
                $this->redirect(array('index'));
        }
        $this->render('usersettings',array('password'=>$passwordModel));
    }
    
    public function actionBackup()
    {
        $this->pageTitle = Yii::t('menuItems','Backup');
        $settings = $this->processSettings(4);
        $this->render('backup',array('settings'=>$settings));
    }
    
    public function actionBackupDb()
    {
        Yii::import('cmscore.backup.Backup');
        
        $backup = new Backup;
        $backup->backupDbDownload();
    }
    
    public function actionBackupArchive()
    {
        Yii::import('cmscore.backup.Backup');
        
        $backup = new Backup;
        $backup->backupArchiveDownload();
    }

    public function loadModel($id)
    {
        return null;
    }
    
    public function processSettings($groupId)
    {
        $models = Settings::model()->findAll(array('condition'=>'groupId=:id','params'=>array(':id'=>$groupId),'order'=>'orderNumber'));
        $settings = array();
        foreach($models as $model)
        {
            $settings[$model->name] = $model;
        }
        if(isset($_POST['Settings']))
        {
            $errors = false;
            $transaction=app()->db->beginTransaction();
            foreach($_POST['Settings'] as $settingsName=>$settingsValue)
            {
                $settings[$settingsName]->value = $settingsValue;
                if(!$settings[$settingsName]->save())
                    $errors=true;
            }
            if(!$errors)
            {
                $transaction->commit();
                $this->redirect(array('backup'));
            }
            $transaction->rollback();
            getSuccessFlash();
        }
        return $settings;
    }
    
}
