<?php
$this->breadcrumbs = array('Акции');
?>
<section class="main-body news">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="module title2">
                    <h1 class="module-title">Акции</h1>
                </div>
            </div>
            <div class="col-sm-12 col-md-12">
                <div class="blog uk-grid">
                    <?php foreach($models as $model): ?>
                        <div class="uk-width-medium-1-2 row clearfix">
                            <div class="col-sm-12">
                                <article class="item column-1">
                                    <div class="entry-header has-post-format">
                                        <span class="post-format"><i class="uk-icon-thumb-tack"></i></span>
                                        <dl class="article-info">		
                                            <dt class="article-info-term"></dt>	
                                            <dd class="published">
                                                <i class="uk-icon-calendar-o"></i>
                                                <time data-toggle="tooltip" datetime="<?= $model->date; ?>" data-original-title="Дата публикации"><?= app()->dateFormatter->format('dd MMMM y', $model->date); ?></time>
                                            </dd>
                                        </dl>
                                        <h2 style="height: 53px; overflow: hidden;">
                                            <a href="<?= $this->createUrl('view', array('id' => $model->id)); ?>"><?= $model->caption; ?></a>
                                        </h2>		
                                    </div>
                                    <p><a href="<?= $this->createUrl('view', array('id' => $model->id)); ?>"><img title="<?= $model->caption; ?>" alt="<?= $model->caption; ?>" src="<?= imageUrl($model->image, 600, 300, '2:1'); ?>"></a></p>
                                    <?= strip_tags(preg_replace('/(<[^>]+) style=".*?"/i', '$1', stripcslashes($model->text)), '<p><ul><ol><li><a>'); ?>
                                </article>
                            </div><!-- end col-sm-* -->
                        </div><!-- end row -->
                    <?php endforeach; ?>
                </div> 	
            </div>
        </div>
    </div>
</section>