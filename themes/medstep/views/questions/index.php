<?php
$this->breadcrumbs = array($this->pagetitle);
?>
<section id="main-body" class="main-body">
    <div class="container">
        <div class="row">
            <div class="module title2">
                <h1 class="module-title">Вопрос-ответ</h1>
                <p>На этой странице вы можете задать вопрос руководству клиники или оставить отзыв</p>
            </div>
            <div class="col-sm-12 col-md-12">
                <?php
                $contactForm = $this->beginWidget('CActiveForm', array(
                    'id'                   => 'question-form',
                    'htmlOptions'          => array('class' => 'form-horizontal'),
                    'enableAjaxValidation' => true,
                    'clientOptions'        => array(
                        'validateOnChange' => true,
                        'validateOnSubmit' => true
                    )
                ));
                ?>
                <h4 class="clearfix"><a class="show-form btn btn-primary pull-right" href="#question-form-container">Написать нам</a></h4>
                <hr>
                <div class="form-hidden" id="question-form-container">
                    <?= $contactForm->errorSummary($formModel); ?>
                    <div class="form-group">
                        <?= $contactForm->labelEx($formModel, 'name', array('class' => 'control-label label-left col-xs-4')); ?>
                        <div class="col-xs-8">
                            <?= $contactForm->textField($formModel, 'name', array('class' => 'form-control', 'placeholder' => $formModel->getAttributeLabel('name'))); ?>
                        </div>
                        <?= $contactForm->error($formModel, 'name'); ?>
                    </div>
                    <div class="form-group">
                        <?= $contactForm->labelEx($formModel, 'email', array('class' => 'control-label label-left col-xs-4')); ?>
                        <div class="col-xs-8">
                            <?= $contactForm->textField($formModel, 'email', array('class' => 'form-control', 'placeholder' => $formModel->getAttributeLabel('email'))); ?>
                        </div>
                        <?= $contactForm->error($formModel, 'email'); ?>
                    </div>
                    <div class="form-group">
                        <?= $contactForm->labelEx($formModel, 'text', array('class' => 'control-label label-left col-xs-4')); ?>
                        <div class="col-xs-8">
                            <?= $contactForm->textArea($formModel, 'text', array('class' => 'form-control', 'placeholder' => $formModel->getAttributeLabel('text'))); ?>
                        </div>
                        <?= $contactForm->error($formModel, 'text'); ?>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-offset-4 col-xs-8">
                            <button class="btn btn-primary validate" type="submit" aria-invalid="false">Написать</button>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
            <?php foreach($dataProvider->data as $model): ?>
                <div class="col-sm-12 col-md-12" style="margin-bottom: 50px;">
                    <div class="row">
                        <div class="module title3">
                            <h3><?= $model->name; ?> <span style="float: right;" class="uk-badge uk-badge-success"><?= app()->dateFormatter->format('dd MMMM y', $model->date); ?></span></h3>
                            <p><?= $model->text; ?></p>
                        </div>
                        <?php if($model->answer): ?>
                            <div class="module title4" style="margin-top: 20px;">
                                <h3>Ответ администратора</h3>
                                <p><?= $model->answer; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php
            $this->widget('CLinkPager', array(
                'pages'                => $dataProvider->pagination,
                'cssFile'              => false,
                'htmlOptions'          => array('class' => 'pagination'),
                'header'               => false,
                'selectedPageCssClass' => 'active',
                'firstPageCssClass'    => 'hidden',
                'lastPageCssClass'     => 'hidden'
            ));
            ?>
        </div>
    </div>
</section>

<style type="text/css">
    .form-hidden {
        display: none;
    }
</style>
<?php
clientScript()->registerScript('show-form', '
$(".show-form").click(function(e){e.preventDefault();$($(this).attr("href")).stop().slideToggle();});    
');
