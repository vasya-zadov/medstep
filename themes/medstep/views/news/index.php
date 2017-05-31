<?php
$this->breadcrumbs = array('Новости');
?>
<!-- News -->
<section class="main-body news">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="module title2">
                    <h1 class="module-title">Новости</h1>
                </div>
            </div>
            <div class="col-sm-12 col-md-12">
                <div class="blog">
                    <?php foreach($dataProvider->data as $model): ?>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <article class="item column-1">
                                <div class="entry-header has-post-format">
                                    <span class="post-format"><i class="uk-icon-thumb-tack"></i></span>
                                    <dl class="article-info">		
                                        <dt class="article-info-term"></dt>	
                                        <dd class="published">
                                            <i class="uk-icon-calendar-o"></i>
                                            <time data-toggle="tooltip" datetime="<?= $model->date; ?>" data-original-title="Дата публикации"><?= app()->dateFormatter->format('dd MMMM y',$model->date); ?></time>
                                        </dd>				
                                    </dl>
                                    <h2>
                                        <a href="<?= createUrl('news/alias', array('alias' => $model->alias)); ?>"><?= $model->caption; ?></a>
                                    </h2>		
                                </div>
                                <p><img title="Medical Education" alt="Medical News" src="<?= imageUrl($model->image,1200,400,'3:1'); ?>"></p>
                                <p><?= $model->shortDescription ? $model->shortDescription : ExtHelpers::cropString($model->text,300); ?></p>	
                                <p class="readmore">
                                    <a href="<?= createUrl('news/alias', array('alias' => $model->alias)); ?>" class="btn btn-default"> Читать далее ... </a>
                                </p>
                            </article>
                        </div><!-- end col-sm-* -->
                    </div><!-- end row -->
                    <?php endforeach; ?>
                </div> 	
            </div>
        </div>
    </div>
</section>
<!-- /News -->