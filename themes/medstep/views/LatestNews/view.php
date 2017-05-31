<div class="uk-block">
    <div data-uk-slideset="{default: 2}">
        <ul class="uk-grid uk-slideset">
            
            <?php foreach($this->models as $model): ?>
            
                <li class="sprocket-strips-s-block" data-strips-item="">
                    <div class="sprocket-strips-s-item" data-strips-content="">
                        <div class="sprocket-strips-s-content">
                            <h4 class="sprocket-strips-s-title" data-strips-toggler="">
                                <a href="<?= createUrl('news/alias', array('alias' => $model->alias)); ?>"><?= $model->caption; ?></a>
                            </h4>
                            <span class="date"><?= app()->dateFormatter->format('d MMM y', $model->date); ?></span>
                            <p class="sprocket-strips-s-text"> <?php if($model->image && file_exists('.'.$model->image)): ?><img src="<?= imageUrl($model->image, 570, 300, '570:300'); ?>"> <?php endif; ?></p> 
                            <p class="sprocket-strips-s-text"><?=$model->shortDescription?$model->shortDescription:ExtHelpers::cropString($model->text, 200);?></p>
                            <a href="<?= createUrl('news/alias', array('alias' => $model->alias)); ?>" class="readon"><span>Читать далее</span></a>
                        </div>
                    </div>
                </li>
                
            <?php endforeach; ?>
                
        </ul>
        <div class="uk-grid">
            <div class="uk-width-small-1-5 uk-push-2-5 uk-flex uk-flex-center" >
                <a href="" class="uk-slidenav uk-slidenav-previous" data-uk-slideset-item="previous"></a>							
                <a href="" class="uk-slidenav uk-slidenav-next" data-uk-slideset-item="next"></a>						  
            </div>							  							  
        </div>
    </div>
</div>	