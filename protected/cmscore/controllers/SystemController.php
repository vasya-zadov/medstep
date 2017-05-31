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
 * Description of SystemController
 *
 * @author Alexander Larkin <lcdee@andex.ru>
 */
class SystemController extends Controller
{

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error = Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('cmscore.views.system.error', $error);
        }
    }

    public function actionInstallApp()
    {
        if(file_exists(Yii::getPathOfAlias('webroot').'/protected/config/main.php'))
            throw new CHttpException(404, Yii::t('errorMessages', 'The requested page does not exist.'));
        $values = array(
            'appName'           => '',
            'dbHost'            => 'localhost',
            'dbName'            => '',
            'dbUserName'        => '',
            'dbPassword'        => '',
            'tablePrefix'       => 'yiiadyncms'.mt_rand(10, 99).'_',
            'userName'          => '',
            'userEmail'         => '',
            'userPassword'      => '',
            'developerName'     => '',
            'developerEmail'    => '',
            'developerPassword' => '',
            'error'             => false
        );
        if(isset($_POST['install']))
        {
            unset($_POST['install']);
            $values = CMap::mergeArray($values, $_POST);
            foreach($values as $valueName => $value)
            {
                if($valueName != 'error' && empty($value))
                    $values['error'] = true;
            }
            if(!$values['error'])
            {
                require_once(dirname(__FILE__).'/../install/Installer.php');
                if(Installer::install($values))
                    $this->redirect(array(
                        '/root/default/index'));
            }
        }

        $this->render('cmscore.views.system.install', $values);
    }

    public function actionFtpbackup()
    {
        $backup = new Backup;
        $backup->performFtpBackup();
        echo 1;
    }

    public function actionRobots()
    {
        header('Content-Type: text/txt');
        if(defined('YII_DEBUG') && YII_DEBUG)
        {
            echo "User-agent: Yandex \r\n";
            echo "Disallow: / \r\n";
            echo "\r\n";
            echo "User-agent: * \r\n";
            echo "Disallow: / \r\n";
        }
        else
        {
            echo "User-agent: Yandex\r\n";
            echo "Disallow: /root \r\n";
            echo "\r\n";
            echo "User-agent: * \r\n";
            echo "Disallow: /root \r\n";
        }
    }

    public function actionSitemap()
    {
        Yii::import('cmscore.extensions.Sitemap');
        $this->render('cmscore.views.system.sitemap', array(
            'links' => Sitemap::buildLinks(array('host'=>'http://beta5.hunt-and-trophy.ru'))));
    }

}
