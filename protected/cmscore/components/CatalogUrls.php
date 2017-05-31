<?php
/**
 * CatalogUrls provides URL-in-path format for multilevel catalog
 *
 * @author AlexLcDee
 */
class CatalogUrls extends CBaseUrlRule
{
    /**
	 * Creates a URL based on this rule.
	 * @param CUrlManager $manager the manager
	 * @param string $route the route
	 * @param array $params list of parameters (name=>value) associated with the route
	 * @param string $ampersand the token separating name-value pairs in the URL.
	 * @return mixed the constructed URL. False if this rule does not apply.
	 */
    public function createUrl($manager, $route, $params, $ampersand)
    {
        if(substr($route, 0, 7) !== 'catalog')
            return false;
        
        $routeArray = explode('/', $route);
        
        $catalog = new Catalog;
        $pathArray = array();
        
        if(end($routeArray) === 'item')
        {
            $model = Catalog::model()->findByPk($params['id']);
            if($model === null)
                return false;
            
            $catalog = $model->category;

            $pathArray[] = $model->alias.'.html';
        }
        elseif(end($routeArray) === 'category')
        {
            $model = Catalog::model()->findByPk($params['id']);
            if($model === null)
                return false;
            
            $catalog = $model;
            
        }
        elseif(end($routeArray) !== 'catalog')
        {
            return false;
        }
        
        $path = $this->buildCatalogPath($catalog, $pathArray);
        
        /*if(end($routeArray) !== 'item')
            $path.='/';*/
        
        unset($params['id']);
        
        $params = $this->buildParams($ampersand,$params);
        
        return $path.($params ? '?'.$params : '');
    }

    private function buildParams($ampersand,$params)
    {
        $paramArray = array();
        foreach($params as $paramName=>$paramValue)
        {
            if($paramValue !== 0)
                $paramArray[] = $paramName.'='.$paramValue;
        }
        
        return implode($ampersand,$paramArray);
    }
    
    /**
     * Generates path of catalog.
     * @param Catalog $catalog
     * @param array $pathArray
     * @return string
     */
    private function buildCatalogPath($catalog, $pathArray)
    {
        if(!empty($catalog->alias))
            $pathArray[] = $catalog->alias;
        
        while(($catalog = $catalog->category) !== null)
        {
            $pathArray[] = $catalog->alias;
        }
        
        $pathArray[] = 'catalog';
        
        $path = implode('/', array_reverse($pathArray));
        return $path;
    }
    
    /**
	 * Parses a URL based on this rule.
	 * @param CUrlManager $manager the URL manager
	 * @param CHttpRequest $request the request object
	 * @param string $pathInfo path info part of the URL (URL suffix is already removed based on {@link CUrlManager::urlSuffix})
	 * @param string $rawPathInfo path info that contains the potential URL suffix
	 * @return mixed the route that consists of the controller ID and action ID. False if this rule does not apply.
	 */
    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        if(substr($pathInfo, 0, 7) !== 'catalog')
            return false;

        list($action, $_GET['id']) = $this->processPath($pathInfo);

        return 'catalog/'.$action;
    }
    
    /**
     * Processes path and returns action name and entity id.
     * @param string $pathInfo
     * @return array
     */
    private function processPath($pathInfo)
    {
        $pathArray = explode('/', $pathInfo);
        array_shift($pathArray);
        
        if(empty($pathArray))
            return array('index', null);
        
        if(($action=$this->checkController($pathArray)))
        {
            return array($action,null);
        }
        
        $end = array_pop($pathArray);
        
        $parent = $this->iteratePathArray($pathArray);
        
        if(stristr($end, '.html'))
        {
            $end = str_replace('.html', '', $end);
            $model = Catalog::model()->findByAttributes(array(
                'alias'      => $end,
                'parentId' => $parent));
           
            $this->throw404Exception($model, 'Товар');
            
            $action = 'item';
        }
        elseif(!empty($end))
        {
            $model = Catalog::model()->findByAttributes(array(
                'alias'     => $end,
                'parentId' => $parent));
            
            $this->throw404Exception($model, 'Каталог');
            
            $action = 'category';
        }
        
        return array($action,$model->id);
    }
    
    private function checkController($pathArray)
    {
        Yii::import('application.controllers.CatalogController');
        $controller = new CatalogController('catalog');
        foreach($pathArray as $action)
        {
            if(method_exists($controller, 'action'.$action))
                return $action;
        }
        
        return false;
    }
    
    /**
     * Iterates path array to find out which category entity belongs to.
     * @param array $pathArray
     * @return int ID of category
     */
    private function iteratePathArray($pathArray)
    {
        $parent = 0;
        foreach($pathArray as $segment)
        {
            $model = Catalog::model()->findByAttributes(array(
                'alias'     => $segment,
                'parentId' => $parent));
            
            $this->throw404Exception($model, 'Каталог');
            
            $parent = $model->id;
        }
        return $parent;
    }
    
    /**
     * Checks whether model exists or not. Throws CHttpException if not.
     * @param CActiveRecord $model
     * @param string $entity
     * @throws CHttpException
     */
    private function throw404Exception($model,$entity)
    {
            if($model === null)
                throw new CHttpException(404, $entity.' не найден');        
    }

}