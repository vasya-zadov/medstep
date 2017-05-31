<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RedirectUrls
 *
 * @author Alexander Larkin <lcdee@andex.ru>
 */
class RedirectUrls extends CBaseUrlRule
{
    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {
        $model = Redirects::model()->findByAttributes(array('redirectFrom'=>$pathInfo));
        if($model === null)
            return false;
        $_GET['redirect']=$model->redirectTo;
        return 'site/redirectPage';
    }
    public function createUrl($manager, $route, $params, $ampersand)
    {
        return false;
    }
}
