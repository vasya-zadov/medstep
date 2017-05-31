<div class="uk-modal" id="contact-us" aria-hidden="true">
    <div class="uk-modal-dialog uk-text-center">
        <button class="uk-modal-close uk-close" type="button"></button>
        <?php
        $contactForm = $this->beginWidget('CActiveForm', array(
            'id'                   => 'feedback-form-contact-us',
            'htmlOptions'          => array('class' => 'form-horizontal'),
            'action'               => $this->action,
            'enableAjaxValidation' => true,
            'clientOptions'        => array(
                'validateOnChange' => true,
                'validateOnSubmit' => true,
                'afterValidate'    => 'js:function(form, data, hasError){
                    if(!hasError) {
                        $("#contact-us").find("form").slideUp(300,function(){
                            $("#contact-us").find(".uk-modal-dialog").append("<div class=\"uk-modal-spinner\"></div>");
                        });
                        setTimeout(function(){
                            var fail = function() {
                                form.replaceWith("<h4>При отправке сообщения произошла ошибка</h4>");
                            }
                            $.ajax({
                                type: "post",
                                url: form.attr("action"),
                                data: form.serialize()
                            })
                            .success(function(responseText){
                                var response = JSON.parse(responseText);
                                if(response.code==1){
                                    $("#contact-us").find(".uk-modal-spinner").fadeOut(300,function(){
                                        form.replaceWith("<h4>Ваше сообщение отправлено. Спасибо за обращение</h4>");
                                        var modal = UIkit.modal("#contact-us");
                                        setTimeout(function(){modal.hide()},3000);
                                    });
                                }
                                else
                                {
                                    fail();
                                }
                            })
                            .fail(function(){ fail(); });
                        },1000);
                    }
                    return false;
                }'
            )
        ));
        ?>
        <h4>Написать нам</h4>
        <hr>
        <?= $contactForm->errorSummary($model); ?>
        <div class="form-group">
            <?= $contactForm->labelEx($model, 'name', array('class' => 'control-label label-left col-xs-4')); ?>
            <div class="col-xs-8">
                <?= $contactForm->textField($model, 'name', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('name'))); ?>
            </div>
            <?= $contactForm->error($model, 'name'); ?>
        </div>
        <div class="form-group">
            <?= $contactForm->labelEx($model, 'email', array('class' => 'control-label label-left col-xs-4')); ?>
            <div class="col-xs-8">
                <?= $contactForm->textField($model, 'email', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('email'))); ?>
            </div>
            <?= $contactForm->error($model, 'email'); ?>
        </div>
        <div class="form-group">
            <?= $contactForm->labelEx($model, 'text', array('class' => 'control-label label-left col-xs-4')); ?>
            <div class="col-xs-8">
                <?= $contactForm->textArea($model, 'text', array('class' => 'form-control', 'placeholder' => $model->getAttributeLabel('text'))); ?>
            </div>
            <?= $contactForm->error($model, 'text'); ?>
        </div>
        <div class="form-group">
            <div class="col-xs-offset-4 col-xs-8">
                <button class="btn btn-primary validate" type="submit" aria-invalid="false">Написать</button>
            </div>
        </div>
        <?= CHtml::hiddenField('f', 'contact-us'); ?>
        <?php $this->endWidget(); ?>
    </div>
</div>