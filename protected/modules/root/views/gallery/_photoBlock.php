<div class="galleryBlock photo">
	<div class="name"><span><?=$model->caption;?></span></div>
	<?=CHtml::link(CHtml::image($model->image.'?width=178&cropratio=1:1'),array('/root/galleryphoto/update','id'=>$model->id));?>
	<div class="buttons">
		<div>
		<?=($i > 1)?CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/assets/images/left-arrow.png'),array('/root/galleryphoto/moveup','id'=>$model->id), array('title'=>'Изменить порядок')):'';?>
		<?=CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/assets/images/edit.png'),array('/root/galleryphoto/update','id'=>$model->id), array('title'=>'Редактировать'));?>
		<?=CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/assets/images/delete.png'),array('#'),array('submit'=>array('/root/galleryphoto/delete','id'=>$model->id),'confirm'=>'Вы действительно хотите удалить данный элемент?', 'title'=>'Удалить'));?>
		<?=($i < $count)?CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/assets/images/right-arrow.png'),array('/root/galleryphoto/movedown','id'=>$model->id), array('title'=>'Изменить порядок')):'';?>
		</div>
	</div>
</div>