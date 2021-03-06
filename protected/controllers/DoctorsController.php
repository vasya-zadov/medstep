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
class DoctorsController extends ClientControllerBase
{

    public function actionIndex()
    {
        $this->pagetitle = 'Врачи';
        $model = new Doctors;
        $model->unsetAttributes();
        if(isset($_GET['category']) && $_GET['category'])
            $model->categoryId = $_GET['category'];
        if(isset($_GET['spec']) && $_GET['spec'])
            $model->specId = $_GET['spec'];
        $dataProvider = $model->search();
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    public function loadModel($id)
    {
        if(($model = Doctors::model()->findByPk($id)) !== null)
            return $model;
        throw new CHttpException(404, 'Страница не найдена');
    }

}
