<?php
$this->breadcrumbs = array('Врачи');
?>
<?php
$selectedCategory = 0;
$selectedSpec = 0;
if(isset($_GET['category']))
    $selectedCategory = $_GET['category'];
if(isset($_GET['spec']))
    $selectedSpec = $_GET['spec'];
?>
<style type="text/css">
    .drop {
        margin-bottom: 15px;
    }
    .drop .team2-filter {
        cursor: pointer;
    }
    .drop .drop-item {
        width: 100%;
        display: block;
        font-size: 14px;
        border: 5px solid rgba(0,0,0,0);
        padding: 5px;
        cursor: pointer;
    }
    .drop .drop-item:hover,
    .drop .drop-item.active {
        color: #fff;
        background: #2685db;
        transition: all .4s ease-in-out;
        border-color: rgba(0,0,0,0.2);
    }
    .drop .drop-item:nth-child(2n+1) {
        clear: both;
    }
    #spec .drop-item {
        width: 50%;
        float: left;
    }
    [data-uk-grid] {
        margin-bottom: 20px;
    }
</style>
<!-- Main Body -->
<section id="main-body" class="main-body">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="module title2">
                    <h1 class="module-title">Врачи</h1>
                </div>
            </div>
            <form>
                <div class="col-md-6 drop" id="category">
                    <div data-uk-dropdown="{mode:'click',justify:'#category'}">
                        <div class="team2-filter">Ученая степень / Категория</div>
                        <div class="uk-dropdown">
                            <div class="drop-item <?= !$selectedCategory ? 'active' : '' ?>" val="0">Ученая степень / Категория</div>
                            <?php foreach(Categories::model()->findAll() as $category): ?>
                                <div class="drop-item <?= $selectedCategory == $category->id ? 'active' : '' ?>" val="<?= $category->id; ?>"><?= $category->caption; ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 drop" id="spec">
                    <div data-uk-dropdown="{mode:'click',justify:'#spec'}">
                        <div class="team2-filter">Специализация</div>
                        <div class="uk-dropdown">
                            <div class="drop-item  <?= !$selectedSpec ? 'active' : '' ?>" val="0">Специализация</div>
                            <?php foreach(Specs::model()->findAll() as $spec): ?>
                                <div class="drop-item <?= $selectedSpec == $spec->id ? 'active' : '' ?>" val="<?= $spec->id; ?>"><?= $spec->caption; ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php if($selectedCategory || $selectedSpec): ?>
                    <div class="col-md-4 col-md-offset-4" style="margin-bottom: 15px;">
                        <a href="/doctors" class="col-md-12 uk-button uk-button-large uk-button-primary">Все врачи клиники</a>
                    </div>
                <?php endif; ?>
            </form>
            <div class="col-sm-12 col-md-12">
                <div data-uk-grid-match="{target:'.uk-panel'}" data-uk-grid="{gutter: ' 20',controls: '.drop'}" class="uk-grid-width-1-1 uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4 uk-grid-width-xlarge-1-4">
                    <?php foreach($dataProvider->data as $k => $model): ?>
                        <div data-uk-filter="cat<?= $model->categoryId; ?>,spec<?= $model->specId; ?>" data-uk-category2="<?= $model->specId; ?>" data-grid-prepared="true" class="team2-box" style="top: 0px; left: 0px;" aria-hidden="false">    
                            <div class="uk-panel team2-member">
                                <figure class="uk-overlay uk-overlay-hover team2-member-padding ">
                                    <div class="team2-member-image-container"><a href="<?= $this->createUrl('view', array('id' => $model->id)); ?>"><img alt="<?= $model->name; ?>" src="<?= imageUrl($model->photo, 200, 273, '200:273'); ?>"></a></div>
                                    <h4 class="uk-margin-small team2-member-head"><a href="<?= $this->createUrl('view', array('id' => $model->id)); ?>"><?= $model->name; ?></a></h4>
                                    <ul class="uk-margin-small">
                                        <?php if($model->patientType): ?>
                                            <li><?= $model->patientType; ?></li>
                                        <?php endif; ?>
                                        <?php if($model->spec): ?>
                                            <li><?= $model->spec; ?></li>
                                        <?php endif; ?>
                                        <?php if($model->category): ?>
                                            <li><?= $model->category; ?></li>
                                        <?php endif; ?>
                                    </ul>
                                </figure>
                            </div>
                        </div>  
                        <?php if(!(($k + 1) % 4)): ?>
                        </div>
                        <div data-uk-grid-match="{target:'.uk-panel'}" data-uk-grid="{gutter: ' 20',controls: '.drop'}" class="uk-grid-width-1-1 uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4 uk-grid-width-xlarge-1-4">
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>	
            </div>
        </div>
    </div>
</section>
<!-- /Main Body -->	
<?php
clientScript()->registerScript('filter', '
$(".drop .team2-filter").each(function(){
    $(this).html($(this).parent().find(".drop-item.active").html());
    var $item = $("<input type=\"hidden\" />");
    $item.attr("name",$(this).parents(".drop").attr("id"));
    $item.val($(this).parent().find(".drop-item.active").attr("val"));
    $(this).parent().append($item);
});
$(".drop .drop-item").click(function(){
    var $container = $(this).parents(".drop");
    $container.find(".drop-item").removeClass("active");
    $(this).addClass("active");
    $container.find("[type=hidden]").val($(this).attr("val"));
    $container.find(".team2-filter").html($(this).html());
    $container.parent().submit();
});
');
