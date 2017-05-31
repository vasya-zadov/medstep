<?php
/* @var $model Gallery */
$this->breadcrumbs = array($model->caption);
$this->pagetitle = $model->caption;
?>
<!-- News -->
<section class="main-body news">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="module title2">
                    <h1 class="module-title"><?= $model->caption; ?></h1>
                </div>
            </div>
            <?php foreach($model->photos as $photo): ?>
                <div class="col-md-4" style="margin-bottom: 20px;">
                    <a href="<?= $photo; ?>" data-uk-lightbox="{group:'my-group'}">
                        <img src="<?= imageUrl($photo, 600, 0, '1:1'); ?>" alt="" class="img-responsive" />
                    </a>
                </div>
            <?php endforeach; ?>
            <div class="col-md-12">
                <p><?= str_replace(array("\r\n","\r","\n"),'<br />',$model->description ); ?></p>
            </div>
        </div>
    </div>
</section>