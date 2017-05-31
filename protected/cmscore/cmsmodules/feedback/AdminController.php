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
    public $layout='//layouts/column1';
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('moduleCaptions','Feedback');
        $model = new Feedback;
        $model->unsetAttributes();
        if(isset($_GET['Feedback']))
        {
            $model->attributes = $_GET['Feedback'];
        }
        $this->render('index',array('model'=>$model));
    }
    public function actionView($id)
    {
        $this->layout='//layouts/column2';
        $model = $this->loadModel($id);
        $this->pageTitle = Yii::t('moduleCaptions','Feedback').': '.$model->theme;
        $model->updateAttributes(array('isNew'=>0));
        $this->render('view',array('model'=>$model));
    }
    public function actionSeen($id)
    {
        $this->loadModel($id)->updateAttributes(array('isNew'=>0));
        $this->redirect(array('index'));
    }
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        $this->redirect(array('index'));
    }
    
    public function loadModel($id)
    {
        $model = Feedback::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,Yii::t('errorMessages','The requested page does not exist.'));
        return $model;
    }
}
