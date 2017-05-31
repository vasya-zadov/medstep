<?php
defined('ADYN_BACKUP_DELAY_MULTIPLIER') or define('ADYN_BACKUP_DELAY_MULTIPLIER',604800);
error_reporting(E_ALL);
ini_set('display_errors', 1);
mb_internal_encoding ('UTF-8');

// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
require_once('functionDefinitions.php');
require_once('shortcuts.php');
Yii::setPathOfAlias('cmscore', dirname(__FILE__).'/protected/cmscore');
Yii::setPathOfAlias('cmsmodules', dirname(__FILE__).'/protected/cmscore/cmsmodules');
Yii::import('cmscore.*');
Yii::import('cmscore.backup.*');

if(!file_exists(dirname(__FILE__).'/protected/config/main.php'))
    $_GET['r']='system/installApp';

$config = Configurator::buildConfig();
//CVarDumper::dump($config, 10, true);
$app = Yii::createWebApplication($config);
$app->onEndRequest->add(array('Backup','ftpBackup'));
$app->run();
