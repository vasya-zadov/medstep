<?php echo '<?php' ?>

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

 
return array(
	'name'=>'<?=$appName;?>',
	'language'=>'ru',
	'theme'=>'base',
    
    'cmsmodules' => array('menu','pages','news','feedback','users'),
    
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
            'password'=>'<?=substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'),10);?>',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('*'),
		),
		*/
	),

	// application components
	'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=<?=$dbHost;?>;dbname=<?=$dbName;?>',
			'emulatePrepare' => true,
			'username' => '<?=$dbUserName;?>',
			'password' => '<?=$dbPassword;?>',
			'charset' => 'utf8',
			'tablePrefix'=>'<?=$tablePrefix;?>',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(),
);
<?php echo '?>'; ?>