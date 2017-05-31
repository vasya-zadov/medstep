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
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id'                   => 'pages-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note"><?= Yii::t('formFields', 'Field marked with star (<span class="required">*</span>) are required.'); ?></p>

    <?php echo $form->errorSummary($model); ?>
    <div class="col-md-12">
        <?php
        echo $form->textFieldGroup($model, 'caption', array(
            'size'      => 60,
            'maxlength' => 255));
        ?>
    </div>
    <div class="col-md-12">
        <?php
        echo $form->textAreaGroup($model, 'text', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'rows' => 5))
        ));
        ?>
    </div>
    <div class="clearfix"></div>
     
    <div class="clearfix"></div>
    <div class="modal-footer">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType'  => 'link',
            'label'       => Yii::t('formFields', 'Cancel'),
            'context'     => 'default',
            'url'         => array(
                'index'),
            'htmlOptions' => array(
                'class' => 'pull-left'
        )));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType'  => 'submit',
            'label'       => Yii::t('formFields', 'Save and return'),
            'context'     => 'primary',
            'htmlOptions' => array(
                'name' => 'returnBtn',
        )));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'label'      => Yii::t('formFields', 'Save'),
            'context'    => 'primary'));
        ?>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->
<?php if(!$model->isNewRecord): ?>
    <h2>Изображения</h2>
    <div class="upload-zone row">
        <div class="col-md-2">
            <a class="btn btn-success btn-block btn-lg upload" data-url="<?=
            $this->createUrl('uploadImage', array(
                'galleryId' => $model->id));
            ?>" role="button" title="<?= Yii::t('menuItems', 'Upload'); ?>"><i class="glyphicon glyphicon-plus"></i> <?= Yii::t('menuItems', 'Upload'); ?></a>
        </div>
        <div class="col-md-10">
            <div class="dropzone">
                <div class="dropzone-inner"><?= Yii::t('formFields', 'Drop files here'); ?></div>
            </div>
        </div>
        <div class="currentUploads col-md-12">

        </div>
    </div>
    <div class="gallery row">
        <?php foreach($model->images as $photo): ?>
            <div class="col-md-3"  id="id_<?= $photo->id; ?>">
                <div class="thumbnail">
                    <a class="update-image"><img src="<?= imageUrl($photo, 400, 400, '1:1'); ?>" class="img-responsive" /></a>
                    <div class="caption clearfix">
                        <form>
                            <input type="hidden" name="GalleryPhoto[id]" value="<?= $photo->id; ?>" />
                            <div class="form-group">
                                Название 
                                <input class="form-control" placeholder="<?= Yii::t('formFields', 'Caption'); ?>" name="GalleryPhoto[caption]" id="GalleryPhoto_caption" type="text" maxlength="255" value="<?= $photo->caption; ?>" />
                                Алиас 
                                <input class="form-control" placeholder="<?= Yii::t('formFields', 'Alias'); ?>" name="GalleryPhoto[alias]" id="GalleryPhoto_alias" type="text" maxlength="255" value="<?= $photo->alias; ?>" />
                            </div>
                            <a href="<?=
                            $this->createUrl('deleteImage', array(
                                'id' => $photo->id));
                            ?>" class="btn btn-danger delete" role="button" title="<?= Yii::t('menuItems', 'Delete'); ?>"><i class="glyphicon glyphicon-trash"></i></a>
                            <span class="ok" style="display:none;"><i class="glyphicon glyphicon-ok"></i></span>
                            <button class="btn btn-primary pull-right rename" type="submit"><?= Yii::t('formFields', 'Save'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php
    clientScript()->registerScript('sortable', '
    AdynCMSCore(".gallery").initSortable({url:"'.$this->createUrl('sortImages', array(
                'galleryId' => $model->id)).'"});
    ');
        clientScript()->registerScript('rename', '
    $(".gallery").on("click",".delete",function(e){
        e.preventDefault();
        var $link = $(this);
        $.ajax({url:$link.attr("href")}).success(function(data){ var $item=$link.parents(".thumbnail").parent(); $item.fadeOut(300,function(){$item.remove()});});
    });
    $(".gallery").on("submit",".caption form",function(e){
        e.preventDefault();
        var $form = $(this);
        $.ajax({url:"'.$this->createUrl('renameImage').'",type:"post",data:$form.serialize()}).success(function(data){ $form.find(".ok").show().delay(1000).fadeOut(); });
    });
    $(".upload-zone .upload").click(function (e) {
        var $link = $(this);
        e.preventDefault();
        if ($(".upload-zone input[type=file]").length < 1)
        {
            var $inputFile = $("<input type=\"file\" style=\"display:none\" multiple=\"multiple\" />").appendTo($(this).parent());

            $inputFile.change(function () {
                AdynCMSCore().uploadFiles(this.files, $(".upload-zone"), {
                    url: $link.data("url"),
                    uploadText: "'.Yii::t('formFields', 'Uploading').'",
                    successMessage: "'.Yii::t('errorMessages', 'Upload successfull').'",
                    errMessage: "'.Yii::t('errorMessages', 'Upload failed').'",
                    success: function(data){
                        var response = JSON.parse(data);
                        var $imageContainer = $("<div class=\"col-md-3\" id=\"id_"+response.id+"\" style=\"display:none\">"+
                        "<div class=\"thumbnail\">"+
                        "<a class=\"update-image\">"+
                        "<img src=\""+response.image+"\" class=\"img-responsive\" />"+
                        "</a>"+
                        "<div class=\"caption clearfix\">"+
                        "<form>"+
                        "<input type=\"hidden\" name=\"GalleryPhoto[id]\" value=\""+response.id+"\" />"+
                        "<div class=\"form-group\">"+
                        "<input class=\"form-control\" placeholder=\"'.Yii::t('formFields', 'Caption').'\" name=\"GalleryPhoto[caption]\" id=\"GalleryPhoto_caption\" type=\"text\" maxlength=\"255\" value=\""+response.caption+"\" />"+
                        "</div>"+
                        "<a href=\"'.$this->createUrl('deleteImage').'?id="+response.id+"\" class=\"btn btn-danger delete\" role=\"button\" title=\"'.Yii::t('menuItems', 'Delete').'\"><i class=\"glyphicon glyphicon-trash\"></i></a>"+
                        "<span class=\"ok\" style=\"display:none;\"><i class=\"glyphicon glyphicon-ok\"></i></span>"+
                        "<button class=\"btn btn-primary pull-right rename\" type=\"submit\">'.Yii::t('formFields', 'Save').'</button>"+
                        "</form>"+
                        "</div>"+
                        "</div>");
                        $(".gallery").append($imageContainer);
                        $imageContainer.delay(700).fadeIn();
                    },
                    error: function(data) {
                        var response = JSON.parse(data);
                        printError(response.error);
                    }
                });
            });
        }
        else
            var $inputFile = $(".upload-zone input[type=file]");
        $inputFile.trigger("click");
    });
    $(".gallery").on("click",".update-image",function(e){
        e.preventDefault();
        var $link = $(this);
        var $image = $link.find("img");
        var id = $link.parent().find("form").find("input[type=hidden]").val();
        if ($link.parent().find("input[type=file]").length < 1)
        {
            var $inputFile = $("<input type=\"file\" style=\"display:none\" />").appendTo($(this).parent());
            $inputFile.change(function () {
                AdynCMSCore().uploadFiles(this.files, $(".upload-zone"), {
                    url: "'.$this->createUrl('uploadImage', array(
                'galleryId' => $model->id)).'&id="+id,
                    uploadText: "'.Yii::t('formFields', 'Uploading').'",
                    successMessage: "'.Yii::t('errorMessages', 'Upload successfull').'",
                    errMessage: "'.Yii::t('errorMessages', 'Upload failed').'",
                    success: function(data){
                        var response = JSON.parse(data);
                        $image.fadeOut(300,function(){$image.attr("src",response.image).delay(700).fadeIn();});
                    },
                    error: function(data) {
                        var response = JSON.parse(data);
                        printError(response.error);
                    }
                });
            });
        }
        else
            var $inputFile = $link.parent().find("input[type=file]");
        $inputFile.trigger("click");
    });
    AdynCMSCore().dropzoneInit($(".upload-zone"), {
        url: "'.$this->createUrl('uploadImage', array(
                'galleryId' => $model->id)).'",
        uploadText: "'.Yii::t('formFields', 'Uploading').'",
        successMessage: "'.Yii::t('errorMessages', 'Upload successfull').'",
        errMessage: "'.Yii::t('errorMessages', 'Upload failed').'",
        success: function(data){
            var response = JSON.parse(data);
            var $imageContainer = $("<div class=\"col-md-3\" id=\"id_"+response.id+"\" style=\"display:none\">"+
            "<div class=\"thumbnail\">"+
            "<a class=\"update-image\">"+
            "<img src=\""+response.image+"\" class=\"img-responsive\" />"+
            "</a>"+
            "<div class=\"caption clearfix\">"+
            "<form>"+
            "<input type=\"hidden\" name=\"GalleryPhoto[id]\" value=\""+response.id+"\" />"+
            "<div class=\"form-group\">"+
            "<input class=\"form-control\" placeholder=\"'.Yii::t('formFields', 'Caption').'\" name=\"GalleryPhoto[caption]\" id=\"GalleryPhoto_caption\" type=\"text\" maxlength=\"255\" value=\""+response.caption+"\" />"+
            "</div>"+
            "<a href=\"'.$this->createUrl('deleteImage').'?id="+response.id+"\" class=\"btn btn-danger delete\" role=\"button\" title=\"'.Yii::t('menuItems', 'Delete').'\"><i class=\"glyphicon glyphicon-trash\"></i></a>"+
            "<span class=\"ok\" style=\"display:none;\"><i class=\"glyphicon glyphicon-ok\"></i></span>"+
            "<button class=\"btn btn-primary pull-right rename\" type=\"submit\">'.Yii::t('formFields', 'Save').'</button>"+
            "</form>"+
            "</div>"+
            "</div>");
            $(".gallery").append($imageContainer);
            $imageContainer.delay(700).fadeIn();
        },
        error: function(data) {
            var response = JSON.parse(data);
            printError(response.error);
        }
    });
    ');
endif;
?>