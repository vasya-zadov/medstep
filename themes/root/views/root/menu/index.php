<?php
/* @var $this MenuController */
/* @var $dataProvider CActiveDataProvider */
$i = 1;
$count = count($models);
$caption = array();

$bc = array();

$this->menu = array(
    array(
        'label' => Yii::t('menuItems','Create Menu item'),
        'url'   => array(
            'create',
            'id' => $model->id)),
);

if(!empty($model) && !empty($model->caption))
{
    $caption[] = $model->caption;
    $bc[] = $model->caption;
    while($model->parent !== null)
    {
        $model = $model->parent;
        $caption[] = $model->caption;
        $bc[$model->caption] = array(
            'view',
            'id' => $model->id);
    }
    $caption = array_reverse($caption);
    $caption = implode(' &rarr; ', $caption);
}

$bc['Меню'] = array(
    'index');

$bc = array_reverse($bc);

$this->breadcrumbs = $bc;
?>

<h2><?= (!empty($caption)) ? $caption : ''; ?></h2>


<table class="table table-striped">
    <thead>
        <tr>
            <th><?=$model->getAttributeLabel('id');?></th>
            <th><?=$model->getAttributeLabel('caption');?></th>
            <th><?=$model->getAttributeLabel('active');?></th>
            <th><?=$model->getAttributeLabel('link');?></th>
            <th width="95"><?=$model->getAttributeLabel('submenuCount');?></th>
            <th width="68"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($models as $model)
        {
            $this->renderPartial('_menuEntry', array(
                'model' => $model,
                'i'     => $i,
                'count' => $count));
            $i++;
        }
        ?>
    </tbody>
</table>