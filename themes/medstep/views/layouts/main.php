<?php clientScript()->registerScript('blindMode','
    $("#blindMode").blindMode({
        sizes:[16,18,20,22,24],
        onAfterShow:function(){
            $("header[data-uk-sticky]").addClass("header-margin-top");
        },
        onAfterClose:function(){
            $("header[data-uk-sticky]").removeClass("header-margin-top");
        },
        onAfterImgsChange:function(sender,isHidden){
            if(!isHidden){
                $(".uk-cover-background").show();
            }
            else {
                $(".uk-cover-background").hide();
            }
        }
    });'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="yandex-verification" content="c461128885c60e10" />
        <!-- Meta -->
        <meta name="description" content="">
        <meta name="keywords" content="" />
        <meta name="robots" content="index, follow" />
        <meta name="revisit-after" content="3 days" />

        <title><?= $this->pageTitle; ?> | <?= app()->name; ?></title>

		<link id="favicon" type="image/x-icon" rel="shortcut icon" href="/favicon.ico"/>
        <!-- Styles -->	
        <!-- Bootstrap core CSS -->
        <link href="<?= assetUrl('bootstrap/css/bootstrap.css'); ?>" rel="stylesheet">		
        <!-- Uikit CSS -->
        <link href="<?= assetUrl('css/uikit.almost-flat.css'); ?>" rel="stylesheet">	
        <link href="<?= assetUrl('css/slidenav.almost-flat.css'); ?>" rel="stylesheet">
        <link href="<?= assetUrl('css/slideshow.almost-flat.css'); ?>" rel="stylesheet">
        <link href="<?= assetUrl('css/sticky.almost-flat.css'); ?>" rel="stylesheet">
        <link href="<?= assetUrl('css/tooltip.almost-flat.css'); ?>" rel="stylesheet">
        <!-- Animate CSS -->
        <link href="<?= assetUrl('css/animate.css'); ?>" rel="stylesheet" />	
        <!-- Google Fonts -->	
        <link type="text/css" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:regular,700&amp;latin-ext" rel="stylesheet">
        <link type="text/css" href="http://fonts.googleapis.com/css?family=Merriweather:700,300,regular&amp;latin-ext" rel="stylesheet">
        <!-- Pe-icon-7-stroke Fonts -->	
        <link href="<?= assetUrl('css/helper.css'); ?>" rel="stylesheet">	
        <link href="<?= assetUrl('css/pe-icon-7-stroke.css'); ?>" rel="stylesheet">	
        <!-- Template CSS -->
        <link href="<?= assetUrl('css/swiper.css'); ?>" rel="stylesheet">	
        <link href="<?= assetUrl('css/template.css'); ?>" rel="stylesheet">	
        <link href="<?= assetUrl('color/color1.css'); ?>" rel="stylesheet" type="text/css" title="color1">		
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>
        <!-- Wrap all page content -->
        <div class="body-wrapper" id="page-top">
            <!-- Top Bar -->	
            <section class="hidden-xs top-bar" id="top-bar">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-md-8" id="top2">
                            <ul class="contact-info">
                                <li>
                                    НОВОСЕЛОВ, 44, 
                                пн-пт 8:00–21:00, сб 8:00–18:00, 
                                вс 8:00-15:00, 1.01, 9.05 выходной
                                </li>
                                <li>
                                    <i class="uk-icon-envelope"></i> <a href="mailto:<?= app()->settings->contactEmail; ?>"><?= app()->settings->contactEmail; ?></a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <a id="blindMode" style="color: #000; font-weight: 600;" class="pull-right">
                                <span style="margin-right: 6px;"><span style="font-size: 24px">A</span><span style="font-size: 16px">A</span></span>
                                Версия для слабовидящих
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /Top Bar -->

            <!-- Sticky Menu -->	  
            <div id="header-sticky-wrapper" class="sticky-wrapper" style="height: 115px;">
                <header data-uk-sticky id="header" class="header">
                    <div class="container">
                        <div class="row" style="position: relative;">
                            <div class="col-xs-4 col-sm-2 col-md-2" id="logo">
                                <a href="/" class="logo">
                                    <h1>
                                        <img src="<?= assetUrl('images/logo.png'); ?>" class="default-logo"  style="width:190px;">
                                    </h1>
                                </a>

                            </div>
                              <div  class="adress col-sm-4 col-xs-5 ">
								<i class="uk-icon-phone"></i> <?= str_replace(',','<br />',app()->settings->contactPhone); ?>
                                
                              
                             </div>
                            <div class="col-xs-3 col-sm-6 col-md-8" id="menu">
                                <div><a href="#" id="offcanvas-toggler" class="hidden-lg"><i class="uk-icon-bars"></i></a></div>			  
                                <div class="main-menu">
                                    <?php
                                    $this->widget('MLMenu', array(
                                        'parent_id'          => 1,
                                        'levels'             => 2,
                                        'submenuTemplate'    => '
                                            <div style="width: 240px;" class="dropdown dropdown-main menu-right">
                                                <div class="dropdown-inner">
                                                    {container}
                                                        {items}
                                                    {/container}
                                                </div>
                                            </div>',
                                        'submenuHtmlOptions' => array('class' => 'dropdown-items'),
                                        'itemHtmlOptions'    => array('class' => 'menu-item'),
                                        'htmlOptions'        => array('class' => 'megamenu-parent menu-fade hidden-xs hidden-sm hidden-md')));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            </div>
            <!-- /Sticky Menu -->	

            <?php if(!$this->isIndex && !empty($this->breadcrumbs)): ?>
                <section class="page-title">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-12" id="title">
                                <div class="page-title-inner">
                                    <?php
                                    $this->widget('zii.widgets.CBreadcrumbs', array(
                                        'links'                => $this->breadcrumbs,
                                        'tagName'              => 'ol',
                                        'separator'            => '',
                                        'homeLink'             => '<li><a class="pathway" href="/">Главная</a></li>',
                                        'inactiveLinkTemplate' => '<li class="active">{label}</li>',
                                        'activeLinkTemplate'   => '<li><a class="pathway" href="{url}">{label}</a></li>',
                                        'htmlOptions'          => array(
                                            'class' => 'breadcrumb'
                                        )
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <?= $content; ?>	  


            <!-- Bottom -->	  
            <section id="bottom" class="bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3 col-md-3">
                            <div class="module title2">
                                <!--img src="<?= assetUrl('images/logo.png'); ?>" alt=""--><br>
                                <p>Имеются противопоказания. Необходима консультация врача. Получите консультацию специалиста по оказываемым услугам и возможным противопоказаниям. Лицензия № ЛО-62-01-001604. Материалы, размещенные на данной странице, носят информационный характер и не являются публичной офертой. Посетители сайта не должны использовать их в качестве медицинских рекомендаций.</p>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="module title2">
                                <h3 class="module-title">О нас</h3>
                                <?php
                                $this->widget('MLMenu', array(
                                    'parent_id'   => 37,
                                    'htmlOptions' => array(
                                        'class' => 'uk-list'
                                    )
                                ));
                                ?>
                                <?php
                                $this->widget('MLMenu', array(
                                    'parent_id'   => 17,
                                    'htmlOptions' => array(
                                        'class' => 'uk-list'
                                    )
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="module title2">
                                <h3 class="module-title">Правовая информация</h3>
                                <?php
                                $this->widget('MLMenu', array(
                                    'parent_id'   => 10,
                                    'htmlOptions' => array(
                                        'class' => 'uk-list'
                                    )
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="module title2">
                                <h3 class="module-title">Контакты</h3>
                                <p><a class="uk-icon-button uk-icon-home"></a>&nbsp;&nbsp; 390048, г.Рязань, ул. Новоселов,44 (остановка «Сбербанк»)</p>
                                <p><a class="uk-icon-button uk-icon-envelope"></a>&nbsp;&nbsp; <?= app()->settings->contactEmail; ?></p>
                                <p><a style="" class="uk-icon-button uk-icon-phone "></a>&nbsp;&nbsp;<u class="uk-text-primary"><?= app()->settings->contactPhone; ?></u></p>
                                  <p><a class="uk-icon-button uk-icon-map-signs"></a>&nbsp;&nbsp;<a href="/scheme.html">схема проезда</a></p>
                
                
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Bottom -->

            <!-- Off Canvas Menu -->
            <div class="offcanvas-menu">
                <a class="close-offcanvas" href="#"><i class="uk-icon-remove"></i></a>
                <div class="offcanvas-inner">
                    <?php
                    $this->widget('MLMenu', array(
                        'parent_id'       => 1,
                        'levels'          => 2,
                        'itemHtmlOptions' => array(
                            'class' => 'deeper parent'
                        ),
                        'htmlOptions'     => array(
                            'class' => 'nav menu'
                        )
                    ));
                    ?>
                    <?php
                    $this->widget('MLMenu', array(
                        'parent_id'       => 17,
                        'levels'          => 2,
                        'itemHtmlOptions' => array(
                            'class' => 'deeper parent'
                        ),
                        'htmlOptions'     => array(
                            'class' => 'nav menu'
                        )
                    ));
                    ?>
                </div>
            </div>
        </div>
        <!-- /Off Canvas Menu -->


        <!-- Scripts placed at the end of the document so the pages load faster -->

        <!-- Jquery scripts -->
        <script src="<?= assetUrl('js/jquery.min.js'); ?>"></script>

        <!-- Uikit scripts -->
        <script src="<?= assetUrl('js/uikit.min.js'); ?>"></script>	
        <script src="<?= assetUrl('js/slideshow.js'); ?>"></script> 
        <script src="<?= assetUrl('js/slideshow-fx.js'); ?>"></script> 
        <script src="<?= assetUrl('js/slideset.js'); ?>"></script> 	
        <script src="<?= assetUrl('js/sticky.js'); ?>"></script>
        <script src="<?= assetUrl('js/tooltip.js'); ?>"></script>	
        <script src="<?= assetUrl('js/parallax.js'); ?>"></script>
        <script src="<?= assetUrl('js/lightbox.js'); ?>"></script>
        <script src="<?= assetUrl('js/grid.min.js'); ?>"></script>
        <script src="<?= assetUrl('js/blind-mode.js'); ?>"></script>
        <script src="<?= assetUrl('js/swiper.js'); ?>"></script>

        <!-- WOW scripts -->
        <script src="<?= assetUrl('js/wow.min.js'); ?>"></script>
        <script> new WOW().init();</script>	

        <!-- Template scripts -->
        <script src="<?= assetUrl('js/template.js'); ?>"></script> 	

        <!-- Bootstrap core JavaScript -->
        <script src="<?= assetUrl('bootstrap/js/bootstrap.min.js'); ?>"></script>

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="<?= assetUrl('js/ie10-viewport-bug-workaround.js'); ?>"></script>


<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
	                try {
			   w.yaCounter44188719 = new Ya.Metrika({
			       id:44188719,
			       clickmap:true,
			       trackLinks:true,
			       accurateTrackBounce:true,
			       webvisor:true
	                });
               } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
																				        s.async = true;
	s.src = "https://mc.yandex.ru/metrika/watch.js";

	if (w.opera == "[object Opera]") {
	           d.addEventListener("DOMContentLoaded", f, false);
	} else { f(); }
})(document, window, "yandex_metrika_callbacks");
																				</script>
<noscript><div><img src="https://mc.yandex.ru/watch/44188719" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
    </body>
</html>
