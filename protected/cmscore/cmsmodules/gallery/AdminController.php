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

    public function init()
    {
        parent::init();
        clientScript()->registerCoreScript('jquery.ui');
    }

    public function actionIndex()
    {
        $model = new Gallery('search');
        if(isset($_GET['Gallery']))
        {
            $model->unsetAttributes();
            $model->attributes = $_GET['Gallery'];
        }
        $this->pageTitle = Yii::t('moduleCaptions', 'Gallery');
        $this->render('index', array(
            'model' => $model));
    }

    public function actionGallery($id)
    {
        $model = Gallery::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, Yii::t('errorMessages', 'The requested page does not exist.'));
        $this->pageTitle = $model->caption;
        $this->breadcrumbs = array(
            Yii::t('moduleCaptions', 'Gallery') => array(
                'index'),
            $model->caption                      => array(
                'gallery',
                'id' => $model->id),
            Yii::t('menuItems', 'Update'),
        );

        $this->menu = array(
            array(
                'label' => Yii::t('menuItems', 'Back'),
                'url'   => array(
                    'index')),
        );
        if(isset($_POST['Gallery']))
        {
            $model->attributes = $_POST['Gallery'];
            if($model->save())
            {
                $redirect = array(
                    'gallery',
                    'id' => $model->id);
                if(isset($_POST['returnBtn']))
                {
                    $redirect = array(
                        'index');
                }
                $this->redirect($redirect);
            }
        }

        $this->render('gallery', array(
            'model' => $model));
    }

    public function actionVisibility($id)
    {
        $model = Gallery::model()->findByPk($id);
        $model->updateAttributes(array(
            'isActive' => !$model->isActive));
        $this->redirect(array(
            'index'));
    }

    public function actionCreate()
    {
        $model = new Gallery;
        $this->pageTitle = Yii::t('moduleCaptions', 'Create gallery');
        $this->breadcrumbs = array(
            Yii::t('moduleCaptions', 'Gallery') => array(
                'index'),
            Yii::t('menuItems', 'Create'),
        );

        $this->menu = array(
            array(
                'label' => Yii::t('menuItems', 'Back'),
                'url'   => array(
                    'index')),
        );
        if(isset($_POST['Gallery']))
        {
            $model->attributes = $_POST['Gallery'];
            $model->iNumber = $model->getMaxOrd() + 1;
            if($model->save())
            {
                $redirect = array(
                    'gallery',
                    'id' => $model->id);
                if(isset($_POST['returnBtn']))
                {
                    $redirect = array(
                        'index');
                }
                $this->redirect($redirect);
            }
        }
        $this->render('gallery', array(
            'model' => $model));
    }

    public function actionDelete($id)
    {
        Gallery::model()->findByPk($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array(
                    'index'));
    }

    public function actionSortGallery()
    {
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id', $_POST['ids']);
        $criteria->order = 'FIELD(id,'.implode(',', $_POST['ids']).')';
        $order = '';
        $models = Gallery::model()->findAll($criteria);
        foreach($models as $k => $model)
        {
            $model->updateAttributes(array(
                'iNumber' => $k + 1));
            $order.=$model->id.'='.$model->iNumber.' ';
        }
        
        getSuccessFlash();

        echo $order;
    }

    public function actionRenameImage()
    {
        if(isset($_POST['GalleryPhoto'], $_POST['GalleryPhoto']['id']))
        {
            $model = GalleryPhoto::model()->findByPk($_POST['GalleryPhoto']['id']);
            if($model === null)
                throw new CHttpException(404);
            $model->caption = $_POST['GalleryPhoto']['caption'];
            $model->save();
            app()->end();
        }
        throw new CHttpException(500);
    }

    public function actionUploadImage($galleryId, $id = 0)
    {
        $model = new GalleryPhoto();
        if($id)
        {
            $model = GalleryPhoto::model()->findByPk($id);
            if($model == null)
                throw new CHttpException(404);
        }
        if($model->isNewRecord)
        {
            $model->galleryId = $galleryId;
            $model->iNumber = $model->getMaxOrd() + 1;
            $model->caption = "";
        }
        if($model->save())
        {
            $model->image = imageUrl($model, 400, 400, '1:1');
            echo CJSON::encode($model);
            app()->end();
        }
        echo CJSON::encode(array('error'=>$model->getError('file')));
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    }

    public function actionSortImages($galleryId)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('galleryId', $galleryId);
        $criteria->addInCondition('id', $_POST['ids']);
        $criteria->order = 'FIELD(id,'.implode(',', $_POST['ids']).')';
        $order = '';
        $models = GalleryPhoto::model()->findAll($criteria);
        foreach($models as $k => $model)
        {
            $model->updateAttributes(array(
                'iNumber' => $k + 1));
            $order.=$model->id.'='.$model->iNumber.' ';
        }
        
        getSuccessFlash();

        echo $order;
    }

    public function actionDeleteImage($id)
    {
        $model = GalleryPhoto::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, Yii::t('errorMessages', 'The requested page does not exist.'));
        $model->delete();
        if(request()->isAjaxRequest)
            app()->end();
        $this->redirect(array(
            'gallery',
            'id' => $model->galleryId));
    }

}
