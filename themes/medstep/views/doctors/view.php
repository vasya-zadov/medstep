<?php
$this->pageTitle = $model->name;
if($model->spec !== null)
    $this->pageTitle .=', '.mb_strtolower($model->spec);
?>
<?php
$this->breadcrumbs = array('Врачи' => array('index'), $this->pageTitle);
?>
<!-- Main Body -->
<section id="main-body" class="main-body">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="uk-grid">
                    <div class="uk-width-medium-1-4 uk-text-center">
                        <img alt="Our Care Team" src="<?= imageUrl($model->photo, 200); ?>" class="boxme">
                    </div>
                    <div class="uk-width-medium-3-4">
                        <div class="module title3">
                            <h3><?= $model->name; ?></h3>
                            <?php if($model->spec || $model->category): ?>
                                <ul>
                                    <li><?php if($model->spec) echo $model->spec; ?></li>
                                    <li><?php if($model->category) echo $model->category; ?></li>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <?php if(trim(str_replace('&nbsp;', '', strip_tags($model->text)))): ?>
                            <div style="margin-top: 20px;">
                                <?= $model->text; ?>
                            </div>
                        <?php endif; ?>
                        <?php if(trim(str_replace('&nbsp;', '', strip_tags($model->cite)))): ?>
                            <div class="blockquote-pc" style="margin-top: 20px;">
                                <?= $model->cite; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>	
            </div>
        </div>
    </div>
</section>
<!-- /Main Body -->	