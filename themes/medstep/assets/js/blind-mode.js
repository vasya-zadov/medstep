;
(function ($) {

    "use strict";

    var blindMode = {
        blindMode: function (options) {

            this.options = $.extend({
                lang: "ru",
                fontSize: parseInt($('html').css('font-size')),
                sizes: [],
                allowDisableImgs: true,
                allowDisableColors: true,
                colors: [
                    ['#fff', '#000'],
                    ['#000', '#fff']
                ],
                onBeforeChange: function () {},
                onAfterChange: function () {},
                onBeforeInit: function () {},
                onAfterInit: function () {},
                onBeforeClose: function () {},
                onAfterClose: function () {},
                onBeforeShow: function () {},
                onAfterShow: function () {},
                onBeforeImgsChange: function () {},
                onAfterImgsChange: function () {}
            }, options);

            this.isShown = false;
            this.fontSize = this.options.fontSize;
            this.imgsIsHidden = false;
            this.colorsChanged = false;

            this.langs = {
                en: {
                    'show': 'show',
                    'disable': 'disable',
                    'Font Size:': 'Font Size:',
                    'Images:': 'Images:',
                    'Background:': 'Background:',
                    'Switch off': 'Switch off',
                    'A': 'A',
                    'X': 'X'
                },
                ru: {
                    'show': 'показать',
                    'disable': 'отключить',
                    'Font Size:': 'Размер шрифтов:',
                    'Images:': 'Изображения:',
                    'Background:': 'Фон:',
                    'Switch off': 'Выключить',
                    'A': 'A',
                    'X': 'X'
                }
            };

            this.sizeClickHandler = function (e) {
                e.preventDefault();
                var $sender = $(this);
                _blindMode.options.onBeforeChange($sender);
                handleChange($sender);
                _blindMode.options.onAfterChange($sender);
                save();
            };

            this.imgsClickHandler = function (e) {
                e.preventDefault();
                var $sender = $(this);
                _blindMode.options.onBeforeImgsChange($sender, _blindMode.imgsIsHidden);
                changeImages(!_blindMode.imgsIsHidden);
                _blindMode.options.onAfterImgsChange($sender, _blindMode.imgsIsHidden);
                save();
            };

            this.colorClickHandler = function (e) {
                e.preventDefault();
                var $sender = $(this);
                var colorData = [
                    $sender.css('background-color'),
                    $sender.css('color')
                ];
                changeColors(colorData);
                save();
            };

            this.colorClickResetHandler = function (e) {
                e.preventDefault();
                changeColors(false);
                save();
            };

            var $selector = $(this);
            var _blindMode = this;

            var setCookie = function (name, value) {
                var cookie_date = new Date(new Date().getTime() + 60 * 1000);
                document.cookie = "blindmode." + name + "=" + value +
                        ";expires=" + cookie_date.toUTCString() + ";path=/";
            };
            var getCookie = function (name) {
                var matches = document.cookie.match(new RegExp(
                        "(?:^|; )blindmode\." + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
                        ));
                return matches ? decodeURIComponent(matches[1]) : undefined;
            };

            var init = function () {
                _blindMode.options.onBeforeInit();
                $selector.click(launchPanel);
                restore();
                _blindMode.options.onAfterInit();
            };

            var save = function () {
                var values = {
                    isShown: _blindMode.isShown,
                    fontSize: _blindMode.fontSize,
                    imgsIsHidden: _blindMode.imgsIsHidden,
                    colorsChanged: _blindMode.colorsChanged ? JSON.stringify(_blindMode.colorsChanged) : false
                };
                for (var key in values) {
                    setCookie(key, values[key]);
                }
            };

            var restore = function () {
                var values = {
                    isShown: _blindMode.isShown,
                    fontSize: _blindMode.fontSize,
                    imgsIsHidden: _blindMode.imgsIsHidden,
                    colorsChanged: _blindMode.colorsChanged
                };

                for (var key in values) {
                    var cookieVal = getCookie(key);
                    if (typeof cookieVal !== "undefined") {
                        try {
                            values[key] = JSON.parse(cookieVal);
                        } catch (e) {
                            values[key] = cookieVal;
                        }
                    }
                }

                if (values.isShown) {
                    launchPanel();
                    changeSize(values.fontSize);
                    changeColors(values.colorsChanged);
                    changeImages(values.imgsIsHidden);
                }
            };

            var launchPanel = function (e) {
                _blindMode.options.onBeforeShow();
                if (typeof e !== "undefined")
                    e.preventDefault();
                makePannel();

                var blindModeCss = '' +
                        'body,.header-margin-top { margin-top: ' + ($('.blind-mode-pannel').outerHeight(true)+20) + 'px !important; }' +
                        '.blind-mode-pannel { position:fixed;top:0px;width:100%;background:#f5f5f5;z-index:999999;font-size:20px;padding:10px;text-align:center; }' +
                        '.blind-mode-pannel:after { content:"";display:block;clear:both; }' +
                        '.blind-mode-size-btn {}' +
                        '.blind-mode-size-btn.active { text-decoration:underline; }' +
                        '.blind-mode-imgs-btn { display:none; }' +
                        '.blind-mode-imgs-btn.active { display:inline-block; }' +
                        '.blind-mode-color-btn { display:inline-block;width:30px;height:30px;line-height:30px;border-radius:50%;text-align:center; }';

                $('body').append('<style id="blind-mode-styles">' + blindModeCss + '</style>');
                _blindMode.options.onAfterShow();
                _blindMode.isShown = true;
                if (typeof e !== "undefined")
                    save();
            };

            var handleChange = function ($sender) {
                if (_blindMode.fontSize === $sender.css('font-size'))
                    return;

                changeSize($sender.css('font-size'));

                $('.blind-mode-size-btn').removeClass('active');
                $sender.addClass('active');
            };

            var changeSize = function (size) {
                $('html').css({'font-size': size});
                _blindMode.fontSize = size;
            };

            var handleClose = function () {
                _blindMode.options.onBeforeClose();
                $("#blind-mode-styles").remove();
                $(".blind-mode-pannel").remove();
                changeSize(_blindMode.options.fontSize);
                changeColors(false);
                changeImages(false);
                $('html').off('click', '.blind-mode-imgs-btn', _blindMode.imgsClickHandler);
                _blindMode.isShown = false;
                _blindMode.options.onAfterClose();
                save();
            };

            var changeColors = function (colorData) {
                if (!colorData) {
                    $('*').each(function () {
                        if (!$(this).isChildOf('.blind-mode-pannel')) {
                            var oldColorData = $(this).data('colorData');
                            if (typeof oldColorData === "undefined") {
                                return;
                            }
                            $(this).css('background-color', oldColorData[0]);
                            $(this).css('color', oldColorData[1]);
                        }
                    });
                    _blindMode.colorsChanged = colorData;
                } else {
                    $('*').each(function () {
                        if (!$(this).isChildOf('.blind-mode-pannel')) {
                            var oldColorData = $(this).data('colorData');
                            if (typeof oldColorData === "undefined") {
                                oldColorData = [
                                    $(this).css('background-color'),
                                    $(this).css('color')
                                ];
                                $(this).data('colorData', oldColorData);
                            }
                        }
                    });
                    $("*:not(:isChildOf(.blind-mode-pannel))").css('background-color', colorData[0]);
                    $("*:not(:isChildOf(.blind-mode-pannel))").css('color', colorData[1]);
                    _blindMode.colorsChanged = colorData;
                }
            };

            var changeImages = function (isHidden) {
                if (isHidden)
                {
                    $('img').hide();
                    _blindMode.imgsIsHidden = true;
                } else
                {
                    $('img').show();
                    _blindMode.imgsIsHidden = false;
                }
                $('.blind-mode-imgs-btn').addClass('active');
                $('.blind-mode-imgs-btn.' + (!isHidden ? "show" : "hide") + "-images").removeClass('active');
            };

            var makePannel = function () {
                var $pannel = $('<div class="blind-mode-pannel"></div>');
                if (_blindMode.options.sizes.length) {
                    makeSizesPannel($pannel);
                }
                if (_blindMode.options.allowDisableImgs) {
                    makeImgsPannel($pannel);
                }
                if (_blindMode.options.allowDisableColors) {
                    makeColorsPannel($pannel);
                }
                var $closeBtn = $('<a>' + tr('Switch off') + '</a>');
                $closeBtn.click(handleClose);
                $pannel.append($closeBtn);
                $('body').prepend($pannel);
            };

            var makeSizesPannel = function ($pannel) {
                var $container = $('<span class="blind-mode-sizes-selection">' + tr('Font Size:') + " </span>");
                for (var key in _blindMode.options.sizes) {
                    var $button = $('<a></a>');
                    var size = _blindMode.options.sizes[key];
                    if (size === _blindMode.fontSize)
                        $button.addClass('active');
                    $button.addClass('blind-mode-size-btn');
                    $button.css({'font-size': size});
                    $button.html(tr('A'));
                    $button.click(_blindMode.sizeClickHandler);
                    $container.append($button);
                    $container.append(' ');
                }
                $container.append(' | ');
                $pannel.append($container);
            };

            var makeImgsPannel = function ($pannel) {
                var $container = $('<span class="blind-mode-imgs-pannel">' + tr('Images:') + ' </span>');
                $container.append('<a class="blind-mode-imgs-btn show-images">' + tr('show') + '</a>');
                $container.append('<a class="blind-mode-imgs-btn hide-images active">' + tr('disable') + '</a>');
                $container.append(' | ');
                $pannel.append($container);
                $('html').on('click', '.blind-mode-imgs-btn', _blindMode.imgsClickHandler);
            };

            var makeColorsPannel = function ($pannel) {
                var $container = $('<span class="blind-mode-imgs-pannel">' + tr('Background:') + ' </span>');
                for (var key in _blindMode.options.colors) {
                    var colorData = _blindMode.options.colors[key];
                    var $button = $('<a class="blind-mode-color-btn" style="background: ' + colorData[0] + ';color: ' + colorData[1] + ';">' + tr('A') + '</a>');
                    $button.click(_blindMode.colorClickHandler);
                    $container.append($button);
                    $container.append(' ');
                }
                var $button = $('<a class="blind-mode-color-btn" style="color: #f00;">' + tr('X') + '</a>');
                $button.click(_blindMode.colorClickResetHandler);
                $container.append($button);
                $container.append(' ');
                $pannel.append($container);
            };

            var tr = function (text) {
                if (typeof _blindMode.langs[_blindMode.options.lang][text] !== "undefined")
                    return _blindMode.langs[_blindMode.options.lang][text];
                return "";
            };

            init();
        }
    };

    $.extend($.fn, blindMode);

    $.fn.extend({
        isChildOf: function (filter) {
            return $(this).parents(filter).length > 0;
        }
    });
    $.fn.extend($.expr[':'], {
        isChildOf: function (selector, intStackIndex, arrProperties, arrNodeStack) {
            return $(selector).parents(arrProperties[3]).length > 0;
        }
    });
})(jQuery);