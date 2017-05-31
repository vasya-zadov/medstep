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

clientScript()->scriptMap = array(
    'jquery.js' => 'https://code.jquery.com/jquery-1.8.3.js'
);
clientScript()->coreScriptPosition = CClientScript::POS_HEAD;

clientScript()->registerScriptFile(assetUrl('js/main.js'), CClientScript::POS_END);

if(hasSuccessFlash())
//clientScript()->registerScript('adyn-dismiss-success-flash', '$(".alert.alert-success").delay(3000).slideUp();');
    clientScript()->registerScript('adyn-dismiss-success-flash', 'AdynCMSCore().dismissSuccessFlash()');

/* @var $this AdminControllerBase */
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <title><?= $this->pageTitle; ?></title>
        <link rel="stylesheet" href="<?= assetUrl('/css/main.css'); ?>" type="text/css" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="ru" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php
        if(!user()->isGuest):
            $this->widget('ext.booster.widgets.TbNavbar', array(
                'type'     => 'inverse',
                'fluid'    => true,
                'collapse' => true,
                'brand'    => CHtml::image(assetUrl('images/adyn.png')),
                'brandUrl' => '/root/',
                'items'    => array(
                    (user()->checkAccess('administrator')) ? array(
                        'class'       => 'ext.booster.widgets.TbMenu',
                        'type'        => 'navbar',
                        'encodeLabel' => false,
                        'items'       => CMap::mergeArray(Configurator::getModulesMenu(), array(
                            array('label' => 'Акции', 'url' => array('/root/specials/index')),
                            array('label' => 'Врачи', 'url' => array('/root/doctors/index')),
                            array('label' => 'Услуги', 'url' => array('/root/services/index')),
                            array('label' => 'Программы', 'url' => array('/root/programs/index')),
                            array('label' => 'Вопрос-ответ', 'url' => array('/root/questions/index'))
                        )),
                        ) : null,
                    array(
                        'class'       => 'ext.booster.widgets.TbMenu',
                        'type'        => 'navbar',
                        'htmlOptions' => array(
                            'class' => 'pull-right'),
                        'items'       => array(
                            (user()->checkAccess('administrator')) ? array(
                                'label'          => Yii::t('menuItems', 'Settings'),
                                'submenuOptions' => array(
                                    'class' => 'dropdown-menu-right'
                                ),
                                'items'          => CMap::mergeArray(SettingsGroups::getMenu(), array(
                                    '',
                                    (user()->checkAccess('developer')) ?
                                        array('label' => Yii::t('menuItems', 'Backup'), 'url'   => array('/root/default/backup'),
                                        'icon'  => 'glyphicon glyphicon-save') : null
                                ))
                                ) : null,
                            array(
                                'label'          => user()->model->name,
                                'submenuOptions' => array(
                                    'class' => 'dropdown-menu-right'
                                ),
                                'items'          => array(
                                    array(
                                        'label' => Yii::t('moduleCaptions', 'Users'),
                                        'url'   => array(
                                            '/root/users/index'),
                                        'icon'  => 'glyphicon glyphicon-user'
                                    ),
                                    /* array(
                                      'label' => Yii::t('menuItems', 'Actions Log'),
                                      'url'   => array(
                                      '/root/log/index'
                                      ),
                                      'icon'  => 'glyphicon glyphicon-align-left'
                                      ), */
                                    '',
                                    array(
                                        'label' => Yii::t('menuItems', 'Change Password'),
                                        'url'   => array(
                                            '/root/default/usersettings'),
                                        'icon'  => 'glyphicon glyphicon-cog'
                                    ),
                                    array(
                                        'label' => Yii::t('menuItems', 'Logout'),
                                        'url'   => array(
                                            '/root/default/logout'),
                                        'icon'  => 'glyphicon glyphicon-off'
                                    )
                                )
                            )
                        )
                    )
                ),
                'fixed'    => 'top'
            ));
        endif;
        ?>
        <div class="container-fluid page">

            <?php if(hasSuccessFlash()): ?>
                <div class="alert alert-success" role="alert">
                    <?= getSuccessFlash(); ?>
                </div>
            <?php endif; ?>

            <?php if(hasErrorFlash()): ?>
                <div class="alert alert-danger" role="alert">
                    <?= getErrorFlash(); ?>
                </div>
            <?php endif; ?>

            <?php if(!empty($this->breadcrumbs)): ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        $this->widget('booster.widgets.TbBreadcrumbs', array(
                            'homeLink' => CHtml::link(Yii::t('zii', 'Home'), array(
                                '/root/default/index/')),
                            'links'    => $this->breadcrumbs
                            )
                        );
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <?= $content; ?>
        </div>
        <nav class="nav navbar navbar-inverse navbar-footer">
            <div class="container">
                <p class="pull-left">
                    AdynCMS  v.<?= app()->settings->cmsVersion; ?>
                </p>
                <p class="pull-right">
                    Веб-студия <a href="http://adyn.ru">Динамика</a> &copy; <?= date('Y'); ?>
                </p>
            </div>
        </nav>
    </body>
</html>