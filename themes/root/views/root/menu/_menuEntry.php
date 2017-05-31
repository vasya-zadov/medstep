<tr>
    <td>
        <?= $model->id; ?>
    </td>
    <td>
        <?=
        CHtml::link($model->caption, array(
            '/root/menu/view',
            'id' => $model->id), array(
            'title' => 'Просмотр подменю'));
        ?>
    </td>
    <td>
        <?php
        //активно или нет
        if($model->active == 1)
        {
            echo CHtml::link('<i class="glyphicon glyphicon-ok-sign"></i>', array(
                '/root/menu/active',
                'id' => $model->id), array(
                'title' => Yii::t('menuItems','Disable Menu item'))).' '.Yii::t('formFields','Yes');
        }
        else
        {
            echo CHtml::link('<i class="glyphicon glyphicon-remove-sign"></i>', array(
                '/root/menu/active',
                'id' => $model->id), array(
                'title' => Yii::t('menuItems','Enable Menu item'))).' '.Yii::t('formFields','No');
        }
        ?>
    </td>
    <td> 
        <a href="<?= Yii::app()->menu->createUrl($model); ?>" target="_blank"><?= Yii::app()->menu->createUrl($model); ?></a>
    </td>
    <td>
        <?= count($model->submenus); ?>
    </td>
    <td>
        <?=
        CHtml::link('<i class="glyphicon glyphicon-eye-open"></i>', array(
            '/root/menu/view',
            'id' => $model->id), array(
            'title' => Yii::t('menuItems','View Submenus')));
        ?>
        <?=
        CHtml::link('<i class="glyphicon glyphicon-pencil"></i>', array(
            '/root/menu/update',
            'id' => $model->id), array(
            'title' => Yii::t('menuItems','Update')));
        ?>
        <?=
        ($i > 1) ? CHtml::link('<i class="glyphicon glyphicon-arrow-up"></i>', array(
                '/root/menu/moveup',
                'id' => $model->id), array(
                'title' => Yii::t('menuItems','Sort'))) : '';
        ?>
        <div class="clear"></div>
        <?=
        CHtml::link('<i class="glyphicon glyphicon-plus"></i>', array(
            '/root/menu/create',
            'id' => $model->id), array(
            'title' => Yii::t('menuItems','Create Submenu')));
        ?>
        <?=
        (!in_array($model->id,$model->systemMenuItems))?CHtml::link('<i class="glyphicon glyphicon-trash"></i>', array(
            '#'), array(
            'submit'  => array(
                '/root/menu/delete',
                'id' => $model->id),
            'confirm' => Yii::t('menuItems','Are you really want to delete this item?'),
            'title'   => Yii::t('menuItems','Delete'))):'<i class="glyphicon glyphicon-trash" style="color:transparent"></i>';
        ?>
        <?=
        ($i < $count) ? CHtml::link('<i class="glyphicon glyphicon-arrow-down"></i>', array(
                '/root/menu/movedown',
                'id' => $model->id), array(
                'title' => Yii::t('menuItems','Sort'))) : '';
        ?>
    </td>
</tr>