<?php

/*
 * The MIT License
 *
 * Copyright 2016 Alexander Larkin <lcdee@andex.ru>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Description of Configurator
 *
 * @author Alexander Larkin <lcdee@andex.ru>
 */
class Configurator
{

    public $configuration = array();
    private static $_instance = null;
    private $_modules = array();

    public static function buildConfig()
    {
        $configurator = self::getInstance();
        $configurator->loadDefaultConfig();
        $configurator->loadAppConfig();
        $configurator->loadCmsModulesConfig();

        return $configurator->configuration;
    }

    private function loadAppConfig()
    {
        if(file_exists(dirname(__FILE__).'/../config/main.php'))
        {
            $config = require(dirname(__FILE__).'/../config/main.php');
            if(isset($config['cmsmodules']))
            {
                $this->_modules = $config['cmsmodules'];
                unset($config['cmsmodules']);
            }
            if(isset($config['components']['urlManager']['rules']))
            {
                $urlRules = array_reverse($config['components']['urlManager']['rules']);
                foreach($urlRules as $rule)
                {
                    array_unshift($this->configuration['components']['urlManager']['rules'], $rule);
                }
                unset($config['components']['urlManager']['rules']);
            }
            $this->configuration = CMap::mergeArray($this->configuration, $config);
        }
    }

    private function loadDefaultConfig()
    {
        $this->configuration = CMap::mergeArray($this->configuration, array(
                'basePath'       => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
                'sourceLanguage' => 'en',
                'modules'        => array(
                    'root' => array(
                        'theme'         => 'root',
                        'controllerMap' => array(
                            'system'   => 'application.cmscore.controllers.SystemController',
                            'settings' => 'cmsmodules.settings.AdminController'
                        ),
                        'components'    => array(
                            'user'         => array(
                                'class'           => 'WebUser',
                                'allowAutoLogin'  => true,
                                'autoRenewCookie' => true,
                                'loginUrl'        => array(
                                    '/root/default/login'),
                            ),
                            'errorHandler' => array(
                                'errorAction' => 'root/default/error',
                            )
                        )
                    ),
                ),
                'import'         => array(
                    'cmscore.models.*',
                    'cmscore.components.*',
                    'application.models.*',
                    'application.components.*',
                    'application.extensions.EMailerAdyn.EMailerAdyn'
                ),
                'controllerMap'  => array(
                    'system' => 'application.cmscore.controllers.SystemController'
                ),
                'preload'        => array(
                    'log'),
                'components'     => array(
                    'urlManager'   => array(
                        'urlFormat'        => 'path',
                        'rules'            => array(
                            ''                                                    => 'pages/index',
                            '/robots.txt'                                         => 'system/robots',
                            '/sitemap.xml'                                        => 'system/sitemap',
                            array(
                                'class' => 'CatalogUrls'
                            ),
                            array(
                                'class'        => 'MLUrlRule',
                                'connectionID' => 'db',
                                'urlSuffix'    => '.html',
                            ),
                            array(
                                'root/default/index',
                                'pattern' => 'root'),
                            array(
                                '<controller>/index',
                                'pattern' => '<controller:\w+>'),
                            array(
                                '<controller>/view',
                                'pattern' => '<controller:\w+>/<id:\d+>'),
                            array(
                                '<controller>/<action>',
                                'pattern' => '<controller:\w+>/<action:\w+>/<id:\d+>'),
                            array(
                                '<controller>/<action>',
                                'pattern' => '<controller:\w+>/<action:\w+>'),
                            '<module:\w+>/<controller:\w+>/<action:\w+>'          => '<module>/<controller>/<action>',
                            '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>'
                        ),
                        'showScriptName'   => false,
                        'useStrictParsing' => true
                    ),
                    'user'         => array(
                        'class'           => 'WebUser',
                        'allowAutoLogin'  => true,
                        'autoRenewCookie' => true,
                        'loginUrl'        => array(
                            'user/login'),
                    ),
                    'authManager'  => array(
                        'class'        => 'PhpAuthManager',
                        'defaultRoles' => array(
                            'guest'),
                    ),
                    'menu'         => array(
                        'class' => 'MLMenu'
                    ),
                    'errorHandler' => array(
                        'errorAction' => 'system/error',
                    ),
                    'log'          => array(
                        'class'  => 'CLogRouter',
                        'routes' => array(
                            array(
                                'class'  => 'CFileLogRoute',
                                'levels' => 'error, warning',
                            ),
                        //array('class' => 'CWebLogRoute')
                        ),
                    ),
                    'booster'      => array(
                        'class' => 'application.extensions.booster.components.Booster',
                    ),
                    'settings'     => array(
                        'class' => 'DbSettings'
                    )
                ),
        ));
    }

    private function loadCmsModulesConfig()
    {
        foreach($this->_modules as $moduleName)
        {
            $configFileName = Yii::getPathOfAlias('cmsmodules.'.$moduleName).'/config.php';
            if(file_exists($configFileName))
            {
                $moduleConfig = require($configFileName);
                $this->configuration = CMap::mergeArray($this->configuration, $moduleConfig);
            }
            $this->configuration['params']['enabledModules'][] = $moduleName;
        }
    }

    public static function getModulesMenu()
    {
        $config = self::getInstance();
        $menuItems = array();

        if(in_array('menu', $config->configuration['params']['enabledModules']))
            $config->appendMenuItem($menuItems, 'menu');

        if(in_array('pages', $config->configuration['params']['enabledModules']) || in_array('news', $config->configuration['params']['enabledModules']))
        {
            $items = array();

            if(in_array('pages', $config->configuration['params']['enabledModules']))
                $config->appendMenuItem($items, 'pages');
            if(in_array('news', $config->configuration['params']['enabledModules']))
                $config->appendMenuItem($items, 'news');

            $menuItems[] = array(
                'label' => Yii::t('moduleCaptions', 'Text Pages'),
                'items' => $items
            );
        }

        if(in_array('feedback', $config->configuration['params']['enabledModules']))
            $config->appendMenuItem($menuItems, 'feedback');

        if(in_array('gallery', $config->configuration['params']['enabledModules']))
            $config->appendMenuItem($menuItems, 'gallery');
        if(in_array('slider', $config->configuration['params']['enabledModules']))
            $config->appendMenuItem($menuItems, 'slider');

        if(in_array('directory', $config->configuration['params']['enabledModules']))
        {
            $items = array();

            if(in_array('materials', $config->configuration['params']['enabledModules']))
                $config->appendMenuItem($items, 'materials');
            if(in_array('colors', $config->configuration['params']['enabledModules']))
                $config->appendMenuItem($items, 'colors');
            if(in_array('purposes', $config->configuration['params']['enabledModules']))
                $config->appendMenuItem($items, 'purposes');
            if(in_array('piece', $config->configuration['params']['enabledModules']))
                $config->appendMenuItem($items, 'piece');

            $menuItems[] = array(
                'label' => Yii::t('moduleCaptions', 'directory'),
                'items' => $items
            );
        }

        return $menuItems;
    }

    private function appendMenuItem(&$menuItems, $moduleName)
    {
        $moduleClassName = ucfirst($moduleName);
        $menuItems[] = array(
            'label' => Yii::t('moduleCaptions', $moduleClassName).$this->getCounter($moduleName),
            'url'   => array(
                '/root/'.$moduleName.'/index')
        );
    }

    private function getCounter($moduleName)
    {
        $moduleClassName = ucfirst($moduleName);
        if(class_exists($moduleClassName) && method_exists($moduleClassName::model(), 'getNewItemsCounter') && $moduleClassName::model()->newItemsCounter)
        {
            return' <span class="badge">'.$moduleClassName::model()->newItemsCounter.'</span>';
        }
        return '';
    }

    private function __construct()
    {
        
    }

    private function __wakeup()
    {
        
    }

    public function __clone()
    {
        
    }

    /**
     * 
     * @return Configurator
     */
    public static function getInstance()
    {
        if(self::$_instance == null)
            self::$_instance = new self;
        return self::$_instance;
    }

}
