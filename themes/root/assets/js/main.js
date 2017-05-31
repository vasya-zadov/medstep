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


(function (window, undefined) {
    var _AdynCMSCore = window.AdynCMSCore,
            AdynCMSCore = function (selector) {
                return new AdynCMSCore.prototype.init(selector);
            };

    AdynCMSCore.prototype = {
        constructor: AdynCMSCore,
        init: function (selector) {

            this.dismissSuccessFlash = function () {
                $(".alert.alert-success").delay(3000).slideUp();
            };

            this.initSortable = function (params) {
                var params = params || {};
                var paramsInternal = {
                    url: "",
                    success: function (data) {
                    }
                };
                for (var key in params)
                {
                    paramsInternal[key] = params[key];
                }
                $(this.selector).sortable({
                    update: function (event, ui) {
                        var sorted = $(this).sortable("serialize", {key: "ids[]"});
                        $.ajax({
                            url: paramsInternal.url,
                            type: "post",
                            data: sorted
                        })
                                .success(paramsInternal.success)
                                .fail(function (xhr) {
                                    console.log(xhr.responseText);
                                });
                    }
                });
            }

            this.uploadFiles = function (files, $container, params) {
                var params = params || {};
                var paramsInternal = {
                    url: "",
                    success: function (data) {
                    },
                    error: function (data) {
                    },
                    maxFileSize: 2097152
                };
                for (var key in params)
                {
                    paramsInternal[key] = params[key];
                }
                $container.find('.progress').remove();
                for (var i = 0; i < files.length; i++) {
                    (function (i, file) {
                        var id = i + 1;
                        var $row = $('<div class="progress progress-striped active"><div class="progress-bar"></div></div>');
                        $container.find('.currentUploads').append($row);
                        
                        /*if(file.size>paramsInternal.maxFileSize)
                        {
                            $row.find('.progress-bar').width('100%');
                            $row.removeClass('active').removeClass('progress-striped');
                            $row.find('.progress-bar').html("File is too big");
                            $row.find('.progress-bar').addClass('progress-bar-danger');
                            return false;
                        }*/

                        var formData = new FormData();
                        formData.append("file", file);
                        var xhr = new XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (event) {
                            var percent = parseInt(event.loaded / event.total * 100);
                            $row.find('.progress-bar').width(percent + '%');
                            $row.find('.progress-bar').html(paramsInternal.uploadText + ': ' + percent + '%');
                        }, false);
                        xhr.onreadystatechange = function (event) {
                            printError = function(text){ $row.find('.progress-bar').html(text); };
                            if (event.target.readyState == 4) {
                                if (event.target.status == 200) {
                                    //$row.remove();
                                    $row.removeClass('active').removeClass('progress-striped');
                                    $row.find('.progress-bar').html(paramsInternal.successMessage);
                                    $row.find('.progress-bar').addClass('progress-bar-success');
                                    setTimeout(function(){ $row.fadeOut(300,function(){$row.remove()}); },3000);
                                    paramsInternal.success(xhr.responseText);
                                } else {
                                    console.log(event.target.responseText);
                                    $row.removeClass('active').removeClass('progress-striped');
                                    $row.find('.progress-bar').html(paramsInternal.errMessage);
                                    $row.find('.progress-bar').addClass('progress-bar-danger');
                                    paramsInternal.error(xhr.responseText);
                                }
                            }
                            ;
                        };
                        xhr.open("POST", paramsInternal.url);
                        xhr.send(formData);
                    })(i, files[i]);
                }
            }

            this.dropzoneInit = function ($container,params) {
                var $dropZone = $(".dropzone");
                var dropZoneText = $dropZone.find(".dropzone-inner").html();
                
                $dropZone[0].ondragover = function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    $dropZone.addClass("active");
                    //$dropZone.find(".dropzone-inner").html("");
                };
                $dropZone[0].ondragleave = function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    $dropZone.removeClass("active");
                    //$dropZone.find(".dropzone-inner").html(dropZoneText);
                };
                $dropZone[0].ondrop = function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    $dropZone.removeClass("active");
                    //$dropZone.find(".dropzone-inner").html(dropZoneText);
                    var files = event.dataTransfer.files;
                    AdynCMSCore().uploadFiles(files, $container, params);
                };
            }

            // Handle $(""), $(null), $(undefined), $(false)
            if (!selector) {
                return this;
            }

            // Handle $(DOMElement)
            if (selector.nodeType) {
                this.selector = this[0] = selector;
                return this;
            }

            // Handle HTML strings
            if (typeof selector === "string") {
                this.selector = $(selector);
                return this;
            }
        },
        selector: ""
    };


    window.AdynCMSCore = AdynCMSCore;
})(window);

jQuery(function ($) {

});