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
 * Description of SpecialsController
 *
 * @author Alexander Larkin <lcdee@andex.ru>
 */
class SpecialsController extends AdminControllerBase
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $this->pagetitle = Yii::t('moduleCaptions', 'Добавить акцию');
        $model = new Specials;
        $model->date = date('Y-m-d');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Specials']))
        {
            $model->attributes = $_POST['Specials'];
            if($model->save())
            {
                $redirect = array('update', 'id' => $model->id);
                if(isset($_POST['returnBtn']))
                {
                    $redirect = array('index');
                }
                $this->redirect($redirect);
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $this->pagetitle = Yii::t('moduleCaptions', 'Редактировать акцию: {caption}', array('{caption}' => $model->caption));
        if(empty($model->date))
            $model->date = date('Y-m-d');

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['Specials']))
        {
            $model->attributes = $_POST['Specials'];
            if($model->save())
            {
                $redirect = array('update', 'id' => $model->id);
                if(isset($_POST['returnBtn']))
                {
                    $redirect = array('index');
                }
                $this->redirect($redirect);
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->pagetitle = Yii::t('moduleCaptions', 'Акции');
        $criteria = new CDbCriteria;
        $criteria->condition = 'type=:type';
        $criteria->order = 'id DESC';
        $criteria->params = array(':type' => Specials::TYPE_ID);

        $models = Specials::model()->findAll($criteria);
        $this->render('index', array(
            'models' => $models,
        ));
    }

    public function actionVisibility($id)
    {
        $model = $this->loadModel($id);
        $model->updateAttributes(array('isActive' => !$model->isActive));
        $this->redirect(array('index'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Pages the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Specials::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, Yii::t('errorMessages', 'The requested page does not exist.'));
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Pages $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax'] === 'news-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
