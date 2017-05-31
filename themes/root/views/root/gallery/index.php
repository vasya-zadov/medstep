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

/* @var $model Gallery */
/* @var $this AdminControllerBase */
/* @var $dataProvider CActiveDataProvider */
/* @var $gallery Gallery */

$this->breadcrumbs = array(
    Yii::t('moduleCaptions', 'Gallery'));
$this->menu = array(
    array(
        'label' => Yii::t('menuItems', 'Create'),
        'url'   => array(
            'create'))
);

$dataProvider = $model->search(array(), array(
    'pagination' => false));
?>
<div class="gallery">
    <?php foreach($dataProvider->data as $gallery): ?>
        <div class="panel <?php if($gallery->isActive): ?>panel-default<?php else: ?>panel-danger<?php endif; ?>"  id="id_<?= $gallery->id; ?>" title="<?= Yii::t('menuItems', 'Sort'); ?>">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-10"><a href="<?=
                        $this->createUrl('gallery', array(
                            'id' => $gallery->id));
                        ?>" title="<?= Yii::t('menuItems', 'Update'); ?>"><?= $gallery->caption; ?></a></div>
                    <div class="col-md-2" style="text-align: right">
                        <?=
                        CHtml::link($gallery->isActive ? '<i class="glyphicon glyphicon-eye-close"></i>' : '<i class="glyphicon glyphicon-eye-open"></i>', array(
                            'visibility',
                            'id' => $gallery->id), array(
                            'title' => ($gallery->isActive ? Yii::t('menuItems', 'Hide') : Yii::t('menuItems', 'Show'))));
                        ?>
                        <?=
                        CHtml::link('<i class="glyphicon glyphicon-pencil"></i>', array(
                            'gallery',
                            'id' => $gallery->id), array(
                            'title' => Yii::t('menuItems', 'Update')));
                        ?>
                        <?=
                        CHtml::link('<i class="glyphicon glyphicon-trash"></i>', array(
                            '#'), array(
                            'submit'  => array(
                                'delete',
                                'id' => $gallery->id),
                            'confirm' => Yii::t('menuItems', 'Are you really want to delete this item?'),
                            'title'   => Yii::t('menuItems', 'Delete')));
                        ?>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2"><?php if($gallery->cover != ""): ?>
                            <a href="<?=
                            $this->createUrl('gallery', array(
                                'id' => $gallery->id));
                            ?>" class="thumbnail" title="<?= Yii::t('menuItems', 'Update'); ?>"><img src="<?= imageUrl($gallery->cover, 300, 0, '1:1'); ?>" class="img-responsive" /></a>
                           <?php endif; ?>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-12">
                                <?= $gallery->description; ?>
                            </div>
                        </div>
                        <div class="row">
                            <?php /* foreach($gallery->photos as $photo): ?>
                              <div class="col-md-2">
                              <span class="thumbnail">
                              <img src="<?= imageUrl($photo, 300, 0, '1:1'); ?>" class="img-responsive" />
                              </span>
                              </div>
                              <?php endforeach; */ ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php clientScript()->registerScript('sortable', '
AdynCMSCore(".gallery").initSortable({url:"'.$this->createUrl('sortGallery').'"});
'); ?>
