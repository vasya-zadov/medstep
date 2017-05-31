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
/* @var $this DefaultController */
/* @var $settings Settings[] */
?>
<ul>
    <li><a href="<?=$this->createUrl('backupdb');?>"><i class="glyphicon glyphicon-download"></i> <?=Yii::t('menuItems','Download full DataBase backup');?></a></li>
    <li><a href="<?=$this->createUrl('backuparchive');?>"><i class="glyphicon glyphicon-download"></i> <?=Yii::t('menuItems','Download full Site backup');?></a></li>
</ul>

<h2><?=$settings['backupLatestBackupDate']->group->captionTr;?></h2>

<form method="POST">
    <table class="table table-condensed">
        <tbody>
            <?php foreach($settings as $settingsName => $model): ?>
                <tr>
                    <td><?= $model->captionTr; ?>:</td>
                    <td>
                        <input type="text" class="form-control" <?php if($model->readOnly):?>readonly="readonly"<?php else: ?>name="Settings[<?= $settingsName; ?>]"<?php endif; ?> value="<?= $model->value; ?>" />
                        <?php if($model->hasErrors()): ?><p class="alert alert-block alert-danger"><?=$model->getError('value');?></p><?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="modal-footer">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'label'      => Yii::t('formFields', 'Save'),
            'context'    => 'primary'));
        ?>
    </div>
</form>