<?php
class ElfinderController extends AdminControllerBase
{
    function actions()
    {
        return array(
            'connector' => array(
                'class' => 'ext.elFinder.ElFinderConnectorAction',
                'settings' => array(
                    'root' => Yii::getPathOfAlias('webroot') . '/uploads/',
                    'URL' => Yii::app()->baseUrl . '/uploads/',
                    'rootAlias' => Yii::t('formFields','Upload'),
                    'mimeDetect' => 'none'
                )
            ),
        );
    }
    public function actionBrowse()
    {
        $this->renderPartial('view',null,false,true);
    }
    
}
?>