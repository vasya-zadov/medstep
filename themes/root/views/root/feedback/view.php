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

$this->breadcrumbs = array(
    Yii::t('moduleCaptions','Feedback')=>array('index'),
    $model->theme
);
$this->menu = array(
    array('label'=>Yii::t('menuItems','Back'),'url'=>array('index'))
);
/* @var $model Feedback */
?>

<table class="table table-stripped">
    <tbody>
         <tr>
            <th><?= $model->getAttributeLabel('theme'); ?></th>
            <td><?= $model->theme; ?></td>
        </tr>
        
        <tr>
            <th><?= $model->getAttributeLabel('name'); ?></th>
            <td><?= $model->name; ?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('email'); ?></th>
            <td><?= $model->email; ?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('phone'); ?></th>
            <td><?= $model->phone; ?></td>
        </tr>
       
        <tr>
            <th><?= $model->getAttributeLabel('text'); ?></th>
            <td><?= $model->text; ?></td>
        </tr>
    </tbody>
</table>