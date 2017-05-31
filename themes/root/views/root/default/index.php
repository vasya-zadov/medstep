<?php
/* @var $this DefaultController */
?>
<h1><?= Yii::t('moduleCaptions', 'Content management system'); ?></h1>

<?php if(count(param('adminAlerts'))): ?>
    <div class="alert alert-block alert-danger">
        <ul>
            <?php foreach(param('adminAlerts') as $alert): ?>
                <li><?= $alert; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php
if(in_array('feedback', param('enabledModules')))
{
    $fbDataProvider = call_user_func(function ()
    {
        $model = new Feedback;
        $model->isNew = 1;
        return $model->search();
    });
    if(count($fbDataProvider->data))
        $this->widget('booster.widgets.TbGridView', array(
            'dataProvider'          => $fbDataProvider,
            'filter'                => null,
            'rowCssClassExpression' => '$data->isNew?"warning":""',
            'columns'               => array(
                array(
                    'name'        => 'id',
                    'htmlOptions' => array(
                        'width' => '50')
                ),
                array(
                    'name' => 'name',
                ),
                array(
                    'name' => 'email',
                ),
                array(
                    'name' => 'theme',
                ),
                array(
                    'htmlOptions'     => array(
                        'width' => '100'),
                    'class'           => 'booster.widgets.TbButtonColumn',
                    'template'        => '{view} {seen} {delete}',
                    'buttons'         => array(
                        'seen' => array(
                            'url'     => 'createUrl("/root/feedback/seen",array("id"=>$data->id))',
                            'icon'    => 'check',
                            'visible' => '$data->isNew',
                            'label'   => Yii::t('menuItems', 'Set as seen'))),
                    'viewButtonUrl'   => 'createUrl("/root/feedback/view",array("id"=>$data->id))',
                    'deleteButtonUrl' => 'createUrl("/root/feedback/delete",array("id"=>$data->id))'
                )
            )
        ));
}