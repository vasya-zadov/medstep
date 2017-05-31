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
    public $layout='//layouts/column2';
    
    public function actionActive($id)
	{
		$model=$this->loadModel($id);
		$model->active=($model->active+1) % 2;
		if ($model->save())
		{
			$this->redirect(array('view','id'=>$model->parent_id));
		}
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->pagetitle=Yii::t('moduleCaptions','Menu');
		$criteria = new CDbCriteria;
		$criteria->order = 'iNumber ASC';
		$criteria->condition = 'parent_id='.$id;
			
		$model = Menu::model()->findByPk($id);
        if($model==null)
        {
            $model = new Menu;
            $model->id = 0;
        }
		$models = Menu::model()->findAll($criteria);
			
		$this->render('index',array('models'=>$models,'model'=>$model));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
		$this->pagetitle=Yii::t('moduleCaptions','Create Menu item');
		$model=new MenuForm;
		$model->parent_id = $id;
		$model->active=1;
        
        $menu = new Menu;
        $menu->attributes = $model->attributes;
        
        $model->menu = $menu;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MenuForm']))
		{
			$model->attributes=$_POST['MenuForm'];
            
            $model->parent_id = $id;
			
            $menu->attributes = $model->attributes;
            $menu->node_id = $model->node_id;
            
			$menu->iNumber = $menu->maxOrd+1;
			
			if(!$menu->validate())
				$model->addErrors($menu->getErrors());
			if(!$model->hasErrors())
			{
				if($menu->save())
				{
                    $redirect = array('update','id'=>$menu->id);
                    if(isset($_POST['returnBtn']))
						$redirect = array('view','id'=>$id);
					$this->redirect($redirect);
				}
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=new MenuForm;
		$menu = $this->loadModel($id);
		
		$model->attributes = $menu->attributes;
        $model->menu = $menu;
		
		$this->pagetitle=Yii::t('moduleCaptions','Update Menu item: {caption}',array('{caption}'=>$menu->caption));
        
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MenuForm']))
		{
			$model->attributes=$_POST['MenuForm'];
			
			$menu->attributes = $model->attributes;
            $menu->node_id = $model->node_id;
			
			if(!$menu->validate())
				$model->addErrors($menu->getErrors());
			if(!$model->hasErrors())
			{
				if($menu->save())
				{
					$redirect = array('update','id'=>$menu->id);
                    if(isset($_POST['returnBtn']))
						$redirect = array('view','id'=>$menu->parent_id);
					$this->redirect($redirect);
				}
			}
		}
		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		
		$next = Menu::model()->findAll('iNumber>:iNumber AND parent_id=:parent_id',array(':iNumber'=>$model->iNumber,':parent_id'=>$model->parent_id));
		foreach($next as $item)
		{
			$item->iNumber = $item->iNumber-1;
			$item->save();
		}
		$ret = $model->parent_id;
		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if ($ret == 0)
			$this->redirect(array('index'));
			
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view','id'=>$ret));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->redirect(array('view','id'=>0));
	}
	
	public function actionMoveup($id)
	{
		$model = $this->loadModel($id);
		$prev = Menu::model()->find('iNumber=:iNumber AND parent_id=:parent_id',array(':iNumber'=>$model->iNumber-1,':parent_id'=>$model->parent_id));
		$prev->iNumber = $model->iNumber;
		$model->iNumber = $model->iNumber-1;
		$prev->save();
		$model->save();
		
		$route = ($model->parent !== null) ? array('view','id'=>$model->parent->id) : array('index');
		
		$this->redirect($route);
	}
	public function actionMovedown($id)
	{
		$model = $this->loadModel($id);
		$prev = Menu::model()->find('iNumber=:iNumber AND parent_id=:parent_id',array(':iNumber'=>$model->iNumber+1,':parent_id'=>$model->parent_id));
		$prev->iNumber = $model->iNumber;
		$model->iNumber = $model->iNumber+1;
		$prev->save();
		$model->save();
		
		$route = ($model->parent !== null) ? array('view','id'=>$model->parent->id) : array('index');
		
		$this->redirect($route);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Menu the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Menu::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Menu $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='menu-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
