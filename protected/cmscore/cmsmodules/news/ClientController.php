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
 * Description of ClientController
 *
 * @author Alexander Larkin <lcdee@andex.ru>
 */
class ClientController extends ClientControllerBase
{

    public function actionIndex()
    {
        $model = new News;
        $model->unsetAttributes();
        $this->pageTitle = 'Все новости';

        $this->render('index', array(
            'dataProvider' => $model->search(array(
                'order'     => 'date DESC',
                ), array(
                'pagination' => false
            ))
        ));
    }

    public function actionAlias($alias)
    {
        $model = News::model()->findByAttributes(array(
            'alias' => $alias));
        if($model === null)
            throw new CHttpException(404, 'Страница не найдена');
        $this->pageTitle = $model->caption;
        $breadcrumbs = array('Новости' => array('news/index'));
        $this->render('view', array(
            'model'       => $model,
            'breadcrumbs' => $breadcrumbs,
            )
        );
    }

    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $this->render('view', array(
            'model' => $model));
    }

    public function loadModel($id)
    {
        $model = News::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'Страница не найдена');
        return $model;
    }

}
