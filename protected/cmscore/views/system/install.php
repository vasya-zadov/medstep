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
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>AdynCMS — Install</title>
        <style type="text/css"><?= file_get_contents(dirname(__FILE__).'/assets/bootstrap.css'); ?></style>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="ru" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h1>Установка AdynCMS</h1>
                    <form action="" method="POST">
                        <?php if($error): ?>
                        <div class="alert alert-block alert-danger">Необходимо заполнить все поля</div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="appName">Название приложения</label>
                            <input type="text" class="form-control" id="appName" name="appName" value="<?=$appName;?>" />
                        </div>
                        <hr />
                        <h2>База данных</h2>
                        <div class="form-group">
                            <label for="dbHost">Хост БД</label>
                            <input type="text" class="form-control" id="dbHost" name="dbHost" value="<?=$dbHost;?>" />
                        </div>
                        <div class="form-group">
                            <label for="dbName">Название БД</label>
                            <input type="text" class="form-control" id="dbName" name="dbName" value="<?=$dbName;?>" />
                        </div>
                        <div class="form-group">
                            <label for="dbUserName">Имя пользователя БД</label>
                            <input type="text" class="form-control" id="dbUserName" name="dbUserName" value="<?=$dbUserName;?>" />
                        </div>
                        <div class="form-group">
                            <label for="dbPassword">Пароль пользователя БД</label>
                            <input type="text" class="form-control" id="dbPassword" name="dbPassword" value="<?=$dbPassword;?>" />
                        </div>
                        <div class="form-group">
                            <label for="tablePrefix">Префикс таблиц БД</label>
                            <input type="text" class="form-control" id="tablePrefix" name="tablePrefix" value="<?=$tablePrefix;?>" />
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <hr />
                                <h2>Учетная запись администратора</h2>
                                <p>Учетная запись администратора обладает самыми высокими правами в системе</p>
                                <div class="form-group">
                                    <label for="userName">Имя</label>
                                    <input type="text" class="form-control" id="userName" name="userName" value="<?=$userName;?>" />
                                </div>
                                <div class="form-group">
                                    <label for="userEmail">E-mail <small>(используется для в хода в систему управления и для уведомлений)</small></label>
                                    <input type="text" class="form-control" id="userEmail" name="userEmail" value="<?=$userEmail;?>" />
                                </div>
                                <div class="form-group">
                                    <label for="userPassword">Пароль</label>
                                    <input type="text" class="form-control" id="userPassword" name="userPassword" value="<?=$userPassword;?>" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <hr />
                                <h2>Учетная запись разработчика</h2>
                                <p>Учетная запись разработчика скрыта от администраторов и используется техподдержкой</p>
                                <div class="form-group">
                                    <label for="developerName">Имя</label>
                                    <input type="text" class="form-control" id="developerName" name="developerName" value="<?=$developerName;?>" />
                                </div>
                                <div class="form-group">
                                    <label for="developerEmail">E-mail <small>(используется для в хода в систему управления и для уведомлений)</small></label>
                                    <input type="text" class="form-control" id="developerEmail" name="developerEmail" value="<?=$developerEmail;?>" />
                                </div>
                                <div class="form-group">
                                    <label for="developerPassword">Пароль</label>
                                    <input type="text" class="form-control" id="developerPassword" name="developerPassword" value="<?=$developerPassword;?>" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success pull-right" name="install">Выполнить установку</button>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
                <div class="col-md-2"></div>
            </div>            
        </div>
    </body>
</html>