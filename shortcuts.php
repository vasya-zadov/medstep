<?php

/**
 * This is the shortcut to DIRECTORY_SEPARATOR
 */
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

/**
 * Returns an instance of CWebApplication class
 * @return CWebApplication
 */
function app()
{
    return Yii::app();
}

/**
 * Returns an Instance of CWebUser component
 * @return WebUser
 */
function user()
{
    return app()->user;
}

/**
 * Returns an Instance of CClientScript component
 * @return CClientScript
 */
function clientScript()
{
    return app()->clientScript;
}

/**
 * Returns an Instance of CHttpRequest component
 * @return CHttpRequest
 */
function request()
{
    return app()->request;
}

/**
 * Creates a relative URL based on the given controller and action information.
 * @param string $route the URL route. This should be in the format of 'ControllerID/ActionID'.
 * @param array $params additional GET parameters (name=>value). Both the name and value will be URL-encoded.
 * @param string $ampersand the token separating name-value pairs in the URL.
 * @return string the constructed URL
 */
function createUrl($route, $params = array(), $ampersand = '&')
{
    return app()->createUrl($route, $params, $ampersand);
}

/**
 * Looks for param in config and returns it if successfull, otherwise return
 * default param value passed to function
 * @param string $name name of param to be returned
 * @param mixed $default any value to be returned if no results found
 * @return mixed
 */
function param($name, $default = null)
{
    return isset(app()->params[$name]) ? app()->params[$name] : $default;
}

/**
 * Looks for param in config and returns it if successfull, otherwise return
 * default param value passed to function
 * @param string $name name of param to be returned
 * @param mixed $default any value to be returned if no results found
 * @return mixed
 */
function setParam($name, $value)
{
    app()->params[$name] = $value;
}

/**
 * Sets up flash-message with 'adyn-success' key. Message will be translated if
 * translation exists in messages/<lang>/flashMessages.php
 * @param string $message
 */
function setSuccessFlash($message)
{
    user()->setFlash('adyn-success', Yii::t('flashMessages', $message));
}

/**
 * Return flash-message with 'adyn-success' key and clean it.
 * @return string Flash message from 'adyn-success'
 */
function getSuccessFlash()
{
    return user()->getFlash('adyn-success');
}

/**
 * Check if 'adyn-success' flash message is set
 * @return bool 
 */
function hasSuccessFlash()
{
    return user()->hasFlash('adyn-success');
}

/**
 * Sets up flash-message with 'adyn-error' key. Message will be translated if
 * translation exists in messages/<lang>/flashMessages.php
 * @param string $message
 */
function setErrorFlash($message)
{
    user()->setFlash('adyn-error', Yii::t('flashMessages', $message));
}

/**
 * Return flash-message with 'adyn-error' key and clean it.
 * @return string Flash message from 'adyn-success'
 */
function getErrorFlash()
{
    return user()->getFlash('adyn-error');
}

/**
 * Check if 'adyn-error' flash message is set
 * @return bool 
 */
function hasErrorFlash()
{
    return user()->hasFlash('adyn-error');
}

/**
 * This is the shortcut to Yii::app()->request->baseUrl
 * If the parameter is given, it will be returned and prefixed with the app baseUrl.
 * @param string $url string to append to app's baseUrl
 * @return string application's base url
 */
function baseUrl($url = null)
{
    static $baseUrl;
    if($baseUrl === null)
        $baseUrl = request()->getBaseUrl();
    return $url === null ? $baseUrl : $baseUrl.'/'.ltrim($url, '/');
}

/**
 * Get relative url of selected asset from theme
 * @param string $url url of selected theme's asset file
 * @return string relative url of selected asset
 */
function assetUrl($url, $params = array())
{
    if(defined('YII_DEBUG'))
        $params['nocache'] = time();
    return app()->theme->baseUrl.'/assets/'.ltrim($url, '/').(!empty($params) ? '?'.http_build_query($params) : '');
}

/**
 * Get url of image cropped with image.php
 * @param integer $image
 * @param integer $width
 * @param integer $height
 * @param integer|string $cropratio
 * @return string Url of requested image with GET params for image.php
 * @todo Check if cropped image allready exists and return it, else return image.php cropped image
 */
function imageUrl($image, $width = 0, $height = 0, $cropratio = '')
{
    $params = array();
    if($width)
        $params['width'] = $width;
    if($height)
        $params['height'] = $height;
    if($cropratio)
        $params['cropratio'] = $cropratio;

    return baseUrl($image).(!empty($params) ? '?'.http_build_query($params) : '');
}

/**
 * Get, set or clear a global value from persistent application storage (runtime/state.bin)
 * @param string $key name of persistent value
 * @param mixed $value value to be saved in persistent storage
 * @param mixed $defaultValue default value to be returned if named global value doesn't exists. If the named global value is the same as this value, it will be cleared from the current storage.
 * @return mixed the named global value
 */
function globalState($key, $value = null, $defaultValue = null)
{
    if($value === null)
        return app()->getGlobalState($key, $defaultValue);
    else
        app()->setGlobalState($key, $value, $defaultValue);
}
