<?php $slides = Slider::model()->findAll(array('order' => 'itemOrder ASC')); ?>

<?php if(!empty($slides)): ?>
    <!-- Slider -->
    <section id="ukSlider" class="uk-slider-section">
        <div class="container-fluid">
            <div class="row">                        
                <div class="col-md-12 padding-0">
                    <div class="swiper">
                        <div class="swiper-wrapper">

                            <?php foreach($slides as $slide): ?>

                                <div class="swiper-slide">
                                    <img alt="" src="<?= imageUrl($slide->cover, 1920, 600, '1920:600'); ?>">
                                    <div class="container uk-overlay-panel uk-overlay-fade uk-text-left">					
                                        <div class="uk-slider-caption-80">
                                            <?php /*<div class="wow fadeInDown slider-text" data-wow-delay="0.7s" >
                                                <span class="merri29 uk-text-primary"><?= $slide->caption; ?></span>
                                            </div>
                                            <div class="wow fadeInUp slider-text slider-text-2" data-wow-delay="1.2s">		
                                                <span class="merri14 uk-text-body"><?= $slide->text; ?></span>
                                            </div> */?>
                                        </div>					
                                    </div>					  
                                </div>

                            <?php endforeach; ?>

                        </div>
                        <a class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" href="#"></a>
                        <a class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" href="#"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Slider -->
<?php endif; ?>

<!-- Our Process -->
<section class="main-body our-process">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="module ">
                    <div class="module title1">
                        <h3 class="module-title"><?= PageAccess::page(29)->headingOne; ?></h3>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-medium-1-2">
                            <?= PageAccess::page(29)->text; ?>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <img class="boxme" alt="<?= PageAccess::page(29)->headingOne; ?>" src="<?= imageUrl(PageAccess::page(29)->image, 600); ?>">
                        </div>
                    </div>		  
                </div>			
            </div>			  
        </div>
    </div>
</section>
<!-- /Our Process -->	

<?php
$specials = Specials::model()->search(array(
        'condition' => 'type='.Specials::TYPE_ID.' AND isActive=1'), array(
        'pagination' => array('pageSize' => 4),
        'sort'       => array(
            'defaultOrder' => 'date DESC')
    ))->data;
if(count($specials)):
    ?>
    <!-- Our Doctors & Nurses -->
    <section class="main-body doctors-nurses">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="module ">
                        <div class="module title1">
                             <a href="<?=createUrl('specials/index');?>"><h3 class="module-title">Акции</h3></a>
                        </div>
                        <div class="uk-grid">
                            <?php foreach($specials as $special): ?>
                                <div class="uk-width-medium-1-4 uk-text-center">
                                    <a href="<?= $this->createUrl('specials/view', array('id' => $special->id)); ?>"><img alt="<?= $special->caption; ?>" src="<?= imageUrl($special->image, 300, 0, '1:1'); ?>" class="boxme"></a>
                                    <br>
                                    <h4><a href="<?= $this->createUrl('specials/view', array('id' => $special->id)); ?>"><?= $special->caption; ?></a></h4>
                                    <p><?= $special->description ? $special->description : ExtHelpers::cropString($special->text, 300); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>				
                    </div>			
                </div>			  
            </div>
        </div>
    </section>
    <!-- /Our Doctors & Nurses -->				
<?php endif; ?>

<!-- Our Process -->
<section class="main-body appointment">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="module ">
                    <div class="module title1">
                        <h3 class="module-title"><?= $model->caption; ?></h3>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-medium-1-2">
                            <img class="boxme" alt="<?= $model->caption; ?>" src="<?= imageUrl($model->image, 600); ?>">
                        </div>
                        <div class="uk-width-medium-1-2">
                            <?= $model->text; ?>
                        </div>
                    </div>		  
                </div>			
            </div>			  
        </div>
    </div>
</section>
<!-- /Our Process -->	

<!-- Main Body -->
<section id="main-body" class="main-body our-process">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="uk-text-center">
                    <h3>Уже обследовались? <span class="uk-text-gray">Свяжитесь с нашими специалистами</span>&nbsp;&nbsp;&nbsp;<a href="#contact-us" class="uk-button uk-button-large uk-button-primary" data-uk-modal="{center:true}">Написать нам</a></h3>
                </div>
            </div>  
        </div>
    </div>
</section>
<!-- /Main Body -->

<!-- News from the Center -->	  
<section class="video more-health-programs news-from-center">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="module title1">
                    <a href="<?=createUrl('news/index');?>"><h3 class="module-title">Новости о клинике</h3></a>
                </div>
                <?php $this->widget('ext.LatestNews'); ?>		  
            </div>
        </div>
    </div>
</section>
<!-- /News from the Center -->

<?php $this->widget('ext.RssNewsWidget'); ?>

<?php
$this->widget('ext.FeedbackFormWidget', array('viewName' => 'contact-us', 'scenario' => 'contact-us'));
