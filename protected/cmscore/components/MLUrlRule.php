<?php

/** 
 *  Расширенное правило генерации и разбора URL,
 *  позволяющее создавать и разбирать URL с бесконечной
 *  вложенностью категорий.
 *
 *  Для работы данного правила в генерации 
 *  необходимо в createUrl в параметр 'route' передавать
 *  menu/multilevel.
 *
 *  Данное правило работает на основе таблицы БД Menu
 *  и выводит в качестве URL весь путь от корневого пункта меню до
 *  указанного в параметре 'menu_id'.
 *  
 *  Разработанно AlexLcDee для студии Динамика, 2014г.
 */

class MLUrlRule extends CBaseUrlRule
{
	public $connectionID = 'db';
	public $urlSuffix = '';
	private $state;
	
	public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
	{
		if (!empty($this->urlSuffix))
			if (!stristr($pathInfo,$this->urlSuffix))
				return false;
		
		$path = str_replace($this->urlSuffix,'',$pathInfo);
		$path = explode('/',$path);

		$menuItem = $this->findAlias($path);
		if ($menuItem)
		{
			Yii::app()->menu->curentMenuId = $menuItem->id;
			if (empty($menuItem->node_id))
			{
				return $menuItem->controller.'/index';
			}
			$_GET['id'] = $menuItem->node_id;
			return $menuItem->controller.'/view';
		}
		return false;
	}
	
	public function createUrl($manager,$route,$params,$ampersand)
	{
		if ($route === 'menu/multilevel' && isset($params['menu_id']) && ($menu = Menu::model()->findByPk($params['menu_id']))!==null)
		{
            if ($menu->alias === '/')
                return false;

            if (empty($menu->controller))
                return $menu->alias;

            if($menu->controller !== 'pages')
            {
                if($menu->node_id)
                {
                    $modelName = ucfirst($menu->controller);
                    $node = $modelName::model()->findByPk($menu->node_id);

                    return ltrim(Yii::app()->createUrl($menu->controller.'/alias',array('alias'=>$node->alias)),'/');
                }
                return ltrim(Yii::app()->createUrl($menu->controller.'/index'),'/');
            }

            $path[] = $menu->alias;
            while ($menu->parent !== null)
            {
                $menu = $menu->parent;
                if (!empty($menu->alias))
                    $path[] = $menu->alias;
            }

            $path = array_reverse($path);
            $path = implode('/',$path);
            $path = $path.$this->urlSuffix;
            return $path;
		}
		return false;
	}
	
	public function findAlias($route)
	{
		foreach($route as $k=>$alias)
		{
			if ($k==0)
				$model=Menu::model()->findByAttributes(array('alias'=>$alias));
			else
				$model=Menu::model()->findByAttributes(array('alias'=>$alias,'parent_id'=>$model->id));
				
			if($model == null)
				return false;
		}
		return $model;
	}

}