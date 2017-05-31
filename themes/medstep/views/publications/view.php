<?php
$this->breadcrumbs = array($model->caption);
?>
<!-- Main Body -->
<section id="main-body" class="main-body appointment">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="module title2">
                    <h1 class="module-title"><?= $model->headingOne ? $model->headingOne : $model->caption; ?></h1>
                </div>
                <?= $model->text; ?>
            </div>
        </div>
    </div>
</section>
<!-- /Main Body -->	 