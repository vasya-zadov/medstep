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
 * Description of AdminController
 *
 * @author Alexander Larkin <lcdee@andex.ru>
 */
class AdminController extends AdminControllerBase
{

    public $layout = '//layouts/column2';

    public function actionIndex()
    {
        $model = new Users;
        if(isset($_GET['Users']))
        {
            $model->attributes = $_GET['Users'];
        }
        if(user()->checkAccess('developer'))
        {
            $dataProvider = $model->resetScope()->search();
        }
        else
        {
            $dataProvider = $model->search();
        }
        $this->pageTitle = Yii::t('moduleCaptions', 'Users');
        $this->render('index', array(
            'model'        => $model,
            'dataProvider' => $dataProvider));
    }

    public function actionCreate()
    {
        $model = new Users;
        if(isset($_POST['ajax']) && $_POST['ajax'] == 'user-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if(isset($_POST['Users']))
        {
            $model->attributes = $_POST['Users'];
            if($model->save())
			{
				$redirect = array('update','id'=>$model->id);
				if(isset($_POST['returnBtn']))
				{
					$redirect=array('index');
				}
				$this->redirect($redirect);
			}
        }
        $this->pageTitle = Yii::t('moduleCaptions', 'Create User');
        $this->render('create', array(
            'model' => $model));
    }

    public function actionUpdate($id)
    {
        if(user()->checkAccess('developer'))
        {
            $model = Users::model()->resetScope()->findByPk($id);
        }
        else
        {
            $model = Users::model()->findByPk($id);
        }
        if(isset($_POST['ajax']) && $_POST['ajax'] == 'user-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if(isset($_POST['Users']))
        {
            $model->attributes = $_POST['Users'];
            if($model->save())
			{
				$redirect = array('update','id'=>$model->id);
				if(isset($_POST['returnBtn']))
				{
					$redirect=array('index');
				}
				$this->redirect($redirect);
			}
        }
        $this->pageTitle = Yii::t('moduleCaptions', 'Update User: {userName}', array(
                '{userName}' => $model->name));
        $this->render('update', array(
            'model' => $model));
    }

    public function actionDelete($id)
    {
        Users::model()->resetScope()->findByPk($id)->delete();
        if(!isset($_GET['ajax']))
            $this->redirect(array(
                'index'));
    }

    public function loadModel($id)
    {
        return Users::model()->findByPk($id);
    }

}
