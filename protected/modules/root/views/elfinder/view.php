<?php
clientScript()->coreScriptPosition = CClientScript::POS_HEAD;
clientScript()->registerCoreScript('jquery');
?>
<html>
    <head>
        <title><?= Yii::t('formFields', 'Files'); ?></title>
    </head>
    <body>
        <?php
        $this->widget('ext.elFinder.ElFinderWidget', array(
            'connectorRoute' => 'root/elfinder/connector',
            'settings'       => array(
                'root'           => Yii::getPathOfAlias('webroot').'/uploads/',
                'URL'            => Yii::app()->baseUrl.'/uploads/',
                'rootAlias'      => 'Upload',
                'mimeDetect'     => 'none',
                'editorCallback' => 'js:function(url) {
                var funcNum = window.location.search.replace(/^.*CKEditorFuncNum=(\d+).*$/, "$1");
                window.opener.CKEDITOR.tools.callFunction(funcNum, url);
                window.close();
            }'
            )
        ));
        ?>
    </body>
</html>