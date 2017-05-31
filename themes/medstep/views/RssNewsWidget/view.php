<?php ?>
<!-- Complete Healthcare Solution -->
<section id="healthcare-solution" class="main-body healthcare-solution">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="module title1">
                    <h3 class="module-title">Новости здравоохранения</h3>
                    <div class="uk-grid">
                        <?php foreach($this->data as $k => $item): ?>
                            <?php
                            if($k > 3): continue;
                            endif;
                            ?>
                            <div class="uk-width-medium-1-3">
                                <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-panel-hover">
                                    <div class="uk-panel-teaser">
                                        <a href="<?= $item['link']; ?>" target="_blank" rel="nofollow"><img style="max-width: 100%;min-width: 100%" src="<?= $item['image']; ?>"></a>
                                    </div>
                                    <h4><a href="<?= $item['link']; ?>" target="_blank" rel="nofollow"><?= $item['caption']; ?></a></h4>
                                    <p><?= $item['description']; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>	
            </div>
        </div>
    </div>
</section>
<!-- /Complete Healthcare Solution -->
