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
 * Description of DoctorsController
 *
 * @author Alexander Larkin <lcdee@andex.ru>
 */
class DoctorsController extends AdminControllerBase
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
        $this->pagetitle = Yii::t('moduleCaptions', 'Добавить врача');
        $model = new Doctors;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Doctors']))
        {
            $model->attributes = $_POST['Doctors'];
            $model->name = $model->name;
			$model->itemOrder = Doctors::model()->find(array('select'=>'MAX(itemOrder) AS itemOrder'))->itemOrder + 1;
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
        $this->pagetitle = Yii::t('moduleCaptions', 'Редактировать данные врача: {caption}', array('{caption}' => $model->name));

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['Doctors']))
        {
            $model->attributes = $_POST['Doctors'];
            $model->name = $model->name;
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
        $this->pagetitle = Yii::t('moduleCaptions', 'Врачи');
        $criteria = new CDbCriteria;
        $criteria->order = 'itemOrder ASC';

        $models = Doctors::model()->findAll($criteria);
        $this->render('index', array(
            'models' => $models,
        ));
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
        $model = Doctors::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax'] === 'doctors-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /*public function actionOrder() {
        $model =Doctors::model()->findAll();
        for($i=0;$i<count($model);$i++){
            $model[$i]->itemOrder=$i+1;
            $model[$i]->save();
        }

        

      
    }*/

    public function actionMoveup($id) {
        $model = $this->loadModel($id);
		$prev = Doctors::model()->find(array(
			'condition'=>'itemOrder<:itemOrder',
			'params'=>array(
				':itemOrder'=>$model->itemOrder
			),
			'order'=>'itemOrder DESC'
		));
		$ord = $model->itemOrder;
        $model->itemOrder = $prev->itemOrder;
        $prev->itemOrder = $ord;
        $prev->save();
        $model->save();

        $route =  array('index');

        $this->redirect($route);
    }

    public function actionMovedown($id) {
        $model = $this->loadModel($id);
		$next = Doctors::model()->find(array(
			'condition'=>'itemOrder>:itemOrder',
			'params'=>array(
				':itemOrder'=>$model->itemOrder
			),
			'order'=>'itemOrder ASC',
			'limit'=>1
		));
		$ord = $model->itemOrder;
        $model->itemOrder = $next->itemOrder;
        $next->itemOrder = $ord;
        $next->save();
        $model->save();

        $route =  array('index');

        $this->redirect($route);
    }
	
	public function actionFixorder()
	{
		$models = Doctors::model()->findAll(array('order'=>'itemOrder ASC'));
		foreach($models as $k=>$model)
		{
			$model->itemOrder = $k+1;
			$model->save();
		}
		$this->redirect(array('index'));
	}

}
