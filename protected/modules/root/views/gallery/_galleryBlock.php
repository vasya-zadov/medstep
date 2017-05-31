<div class="galleryBlock">
	<div class="name"><?=CHtml::link($model->caption,array('gallery/view','id'=>$model->id));?></div>
	<?=CHtml::link((!empty($model->photos))?CHtml::image($model->photos[0]->image.'?width=178&cropratio=1:1'):'',array('gallery/view','id'=>$model->id));?>
	<div class="buttons">
		<div>
		<?=($i > 1)?CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/assets/images/left-arrow.png'),array('/root/gallery/moveup','id'=>$model->id), array('title'=>'Изменить порядок')):'';?>
		<?=CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/assets/images/add-single.png'),array('/root/galleryphoto/create','id'=>$model->id), array('title'=>'Добавить фото'));?>
		<?=CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/assets/images/viewico.png'),array('/root/gallery/view','id'=>$model->id), array('title'=>'Просмотреть'));?>
		<?=CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/assets/images/edit.png'),array('/root/gallery/update','id'=>$model->id), array('title'=>'Редактировать'));?>
		<?=CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/assets/images/delete.png'),array('#'),array('submit'=>array('/root/gallery/delete','id'=>$model->id),'confirm'=>'Вы действительно хотите удалить данный элемент?', 'title'=>'Удалить'));?>
		<?=($i < $count)?CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/assets/images/right-arrow.png'),array('/root/gallery/movedown','id'=>$model->id), array('title'=>'Изменить порядок')):'';?>
		</div>
	</div>
</div>