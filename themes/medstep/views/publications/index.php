<?php
$this->pagetitle = 'Публикации';
$this->breadcrumbs = array('Публикации');
?>
<!-- Main Body -->
<section id="main-body" class="main-body appointment">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="module title2">
                    <h1 class="module-title">Публикации</h1>
                </div>
                <ul>
                    <?php foreach ($model->submenus as $item) {?>
                     
                  
                    <li><a href="/publications/<?=$item->alias?>.html"><?=$item->caption?></a></li>
                    <?php  }?>
                </ul>
                <?php // $this->widget('MLMenu',array('parent_id'=>21)); ?>
            </div>
        </div>
    </div>
</section>
<!-- /Main Body -->	 