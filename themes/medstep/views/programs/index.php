<!-- Main Body -->
<section id="main-body" class="main-body appointment">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="module title2">
                    <h1 class="module-title">Программы</h1>
                </div>

                <?= PageAccess::page(28)->text; ?>
                <ul>
                    <?php foreach($dataProvider->data as $model): ?>
                        <li><a href="<?= $this->createUrl('alias', array('alias' => $model->alias)); ?>"><?= $model->caption; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- /Main Body -->	 