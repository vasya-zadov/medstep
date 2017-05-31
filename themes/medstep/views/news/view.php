<?php
$this->breadcrumbs = array('Новости' => array('index'), $model->caption);
?>
<!-- Main Body -->
<section id="main-body" class="main-body appointment">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="module title2">
                    <h1 class="module-title"><?= $model->headingOne ? $model->headingOne : $model->caption; ?></h1>
                </div>
                <?php if($model->image && file_exists(app()->basePath.DS.'..'.DS.$model->image)): ?>
                    <div class="row">
                        <div class="col-md-4"><img class="img-responsive" src="<?= imageUrl($model->image, 400); ?>" /></div>
                        <div class="col-md-8"><?= $model->text; ?></div>
                    </div>
                <?php else: ?>
                    <?= $model->text; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- /Main Body -->	 