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
    public function actionIndex($id)
    {
        $group = SettingsGroups::model()->findByPk($id);
        if($group===null)
            throw new CHttpException(404,'The requested page does not exist.');
        $models = Settings::model()->findAll(array('condition'=>'groupId=:id','params'=>array(':id'=>$id),'order'=>'orderNumber'));
        $settings = array();
        foreach($models as $model)
        {
            $settings[$model->name] = $model;
        }
        if(isset($_POST['Settings']))
        {
            $errors = false;
            $transaction=app()->db->beginTransaction();
            foreach($_POST['Settings'] as $settingsName=>$settingsValue)
            {
                $settings[$settingsName]->value = $settingsValue;
                if(!$settings[$settingsName]->save())
                    $errors=true;
            }
            if(!$errors)
            {
                $transaction->commit();
                $this->redirect(array('index','id'=>$id));
            }
            $transaction->rollback();
            getSuccessFlash();
        }
        $this->pageTitle = $group->captionTr;
        $this->breadcrumbs = array($group->captionTr);
        $this->render('index',array('settings'=>$settings));
    }
}
