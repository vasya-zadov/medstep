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

    public function actionSend()
    {
        $model = new FeedbackForm;
        $f = '';
        
        if(isset($_REQUEST['f']))
        {
            $f = '-'.$_REQUEST['f'];
            $model->scenario = $_REQUEST['f'];
        }
        
        if(isset($_POST['ajax']) && $_POST['ajax'] == 'feedback-form'.$f)
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if(isset($_POST['FeedbackForm']))
        {
            $model->attributes = $_POST['FeedbackForm'];
            if($model->validate() && $model->send())
            {
                if(!app()->request->isAjaxRequest)
                {
                    setSuccessFlash(true);
                    if(isset($_GET['redirect']))
                    {
                        $this->redirect($_GET['redirect']);
                    }
                    $this->redirect(array('index'));
                }
                    
                echo CJSON::encode(array(
                    'code' => 1));
                Yii::app()->end();
            }
        }
        echo CJSON::encode(array(
            'code' => 0));
        Yii::app()->end();
    }

    public function loadModel($id)
    {
        return null;
    }

}
