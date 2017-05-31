<?php
$this->breadcrumbs = array('Акции' => array('index'), $model->caption);
?>
<!-- Main Body -->
<section id="main-body" class="main-body appointment">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="module title2">
                    <h1 class="module-title"><?= $model->headingOne ? $model->headingOne : $model->caption; ?></h1>
                </div>
                <dd class="published" style="margin-bottom: 10px;">
                    <i class="uk-icon-calendar-o"></i>
                    <time data-toggle="tooltip" datetime="<?= $model->date; ?>" data-original-title="Дата публикации"><?= app()->dateFormatter->format('dd MMMM y', $model->date); ?></time>
                </dd>
                <div class="row">
                    <div class="col-md-4"><img src="<?= imageUrl($model->image, 400); ?>" alt="" class="img-responsive" /></div>
                    <div class="col-md-8"><?= $model->text; ?></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Main Body -->	 