<!-- Medical Departments -->
<section class="main-body parallax-fluid medical-departments">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="module title2">
                    <h1 class="module-title" style="color:#555">Услуги</h1>
                </div>
            </div>
            <div class="col-sm-12 col-md-12">
                <div class="module ">
                    <div class="uk-text-contrast uk-text-center uk-flex uk-flex-center uk-flex-middle">
                        <div class="uk-grid uk-grid-collapse">
                            <?php
                            $c = 1;
                            foreach($dataProvider->data as $k => $model):
                                ?>
                                <div class="uk-width-medium-1-4 boxme-trans<?= $c ? '2' : '1'; ?>">
                                    <div class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1b">
                                        <a class="click-full-service-link" href="<?= $this->createUrl('view', array('id' => $model->id)); ?>"><h4><?= $model->caption; ?></h4></a>
                                        <p><?= $model->shortDescription; ?></p>
                                    </div>
                                </div>
                                <?php $c = !$c; ?>
                                <?php if(!(($k + 1) % 4)) $c = !$c; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>			
            </div>			  
        </div>
    </div>
</section>
<!-- /Medical Departments -->
<style>
    .boxme-trans1 {
        background-color: rgb(19, 85, 146);
        cursor: pointer;
    }
    .boxme-trans2 {
        background-color: rgb(22, 97, 167);
        cursor: pointer;
    }
</style>
<?php clientScript()->registerScript('click-full-service','
$(".boxme-trans1,.boxme-trans2").click(function(){
    window.location.href=$(this).find(".click-full-service-link").attr("href");
});
');