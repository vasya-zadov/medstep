<?php

/**
 *  Расширенный и переопределенный виджет CMenu
 *  с возможностью генерировать многоуровневые пункты,
 *  с ограничением максимального уровня вложенности пунктов 
 *  меню и с возможностью работать с базой данных.
 *  
 *  Генерация ссылок производится на основе правила, 
 *  описанного в классе MLUrlRule.
 *
 *  Разработанно AlexLcDee для студии Динамика, 2014г.
 */
Yii::import('zii.widgets.CMenu');

class MLMenu extends CMenu
{

    /**
     *
     * @var Menu[]
     */
    private $models;

    /**
     * Экземпляр компонента
     * @var MLMenu
     */
    private static $_widgetInstance;

    /**
     * Допустимая глубина вложенности
     * @var integer
     */
    public $levels = 1;

    /**
     * Допустимая глубина вложенности для каталога
     * @var integer
     */
    public $catalog_levels = 0;

    /**
     * ID корневого пункта меню, от которого ведется отсчет.
     * @var integer
     */
    public $parent_id = 0;

    /**
     * Добавление к внешним ссылкам 'target="new"'.
     * @var boolean
     */
    public $externalNewPage = false;

    /**
     *
     * @var integer 
     */
    public $curentMenuId = 0;
    public $linkOptions = array();
    public $itemHtmlOptions = array();
    public $submenuTemplate = '';

    /**
     * Модифицированный init() из CMenu.
     *
     * Добавлена загрузка пунктов меню из БД.
     *
     * Изменено получение текущего URL в адресной строке
     *   (из CHttpRequest вместо getController).
     *
     * Добавлена автоматическая генерация массива 'items'.
     */
    public function init()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = "parent_id={$this->parent_id} AND active=1";
        $criteria->order = 'iNumber';
        /* @var $models Menu[] */
        $models = Menu::model()->findAll($criteria);

        $http = new ChttpRequest;
        $route = $http->pathInfo;

        $this->items = $this->makeItemsArray($models);

        if(isset($this->htmlOptions['id']))
            $this->id = $this->htmlOptions['id'];
        else
            $this->htmlOptions['id'] = $this->id;

        $this->items = $this->normalizeItems($this->items, $route, $hasActiveChild);
    }

    public function run()
    {
        $this->renderMenu($this->items);
    }

    /**
     * Recursively renders the menu items.
     * @param array $items the menu items to be rendered recursively
     */
    protected function renderMenuRecursive($items)
    {
        $count = 0;
        $n = count($items);
        foreach($items as $item)
        {
            $count++;
            $options = isset($item['itemOptions']) ? $item['itemOptions'] : array();
            $class = array();
            if($item['active'] && $this->activeCssClass != '')
                $class[] = $this->activeCssClass;
            if($count === 1 && $this->firstItemCssClass !== null)
                $class[] = $this->firstItemCssClass;
            if($count === $n && $this->lastItemCssClass !== null)
                $class[] = $this->lastItemCssClass;
            if($this->itemCssClass !== null)
                $class[] = $this->itemCssClass;
            if($class !== array())
            {
                if(empty($options['class']))
                    $options['class'] = implode(' ', $class);
                else
                    $options['class'].=' '.implode(' ', $class);
            }

            echo CHtml::openTag('li', $options);

            $menu = $this->renderMenuItem($item);
            if(isset($this->itemTemplate) || isset($item['template']))
            {
                $template = isset($item['template']) ? $item['template'] : $this->itemTemplate;
                echo strtr($template, array('{menu}' => $menu));
            }
            else
                echo $menu;

            if(isset($item['items']) && count($item['items']))
            {
                if($this->submenuTemplate)
                    $template = $this->submenuTemplate;
                else
                    $template = "\n{container}\n{items}{/container}\n";

                $template = strtr($template, array(
                    '{container}'  => CHtml::openTag('ul', isset($item['submenuOptions']) ? $item['submenuOptions'] : $this->submenuHtmlOptions),
                    '{/container}' => CHtml::closeTag('ul'),
                ));
                ob_start();
                $this->renderMenuRecursive($item['items']);
                $submenuHtml = ob_get_contents();
                ob_end_clean();
                $template = strtr($template,array('{items}'=>$submenuHtml));
                echo $template;
            }

            echo CHtml::closeTag('li')."\n";
        }
    }

    /**
     * Рекурсивная генерация массива 'items'
     * для стандартной функции генерации
     * меню виджета CMenu.
     */
    protected function makeItemsArray($models, $currentLevel = 1)
    {
        $items = array();
        $sub = array();
        $linkOptions = $this->linkOptions;
        /* @var $models Menu[] */
        //CVarDumper::dump($this);
        foreach($models as $model)
        {
            $itemOptions = $this->itemHtmlOptions;

            if(isset($model->controller) && $model->controller == 'catalog' && $this->catalog_levels > 0)
            {
                //$level = 1;
                $catalog_level = 1;
                //VarDumper::dump(Catalog::model()->active()->findAllByAttributes(array('parentId' => '0','type'=>'1')));
                //die();
                $sub = $this->makeItemsCatalogArray(Catalog::model()->active()->findAllByAttributes(array('parentId' => '0', 'type' => '1'), array('order' => 'itemOrder ASC')), $catalog_level);
                //print_r($sub);
            }
            if($model->submenus != null && $currentLevel < $this->levels)
            {
                //print_r($model->submenus);
                $level = $currentLevel + 1;
                $sm = $model->submenus;
                $itemOptions['class'] .= ' has-child';
                $sub = $this->makeItemsArray($sm, $level);
            }
            /* if ($model->controller == 'catalog')
              $url = $this->createCatalogUrl($model);
              else */
            $url = $this->createUrl($model);

            if($this->externalNewPage && stristr($model->alias, 'http://'))
            {
                $linkOptions['target'] = '_blank';
            }
            else
            {
                $linkOptions['target'] = null;
            }

            if(!empty($model->title))
            {
                $linkOptions['title'] = $model->title;
            }
            else
            {
                $linkOptions['title'] = null;
            }

            if($model->image)
            {
                $itemOptions['class'] .= ' '.$model->image;
            }
            //$linkOptions['class']='';
            //print_r($sub);
            $items[] = array('label' => $model->caption, 'url' => $url, 'items' => $sub, 'itemOptions' => $itemOptions, 'linkOptions' => $linkOptions);
            // обнуляем $sub иначе дублируется во все пункты меню
            $sub = array();
        }
        return $items;
    }

    protected function makeItemsCatalogArray($models, $currentLevel = 1)
    {
        $items = array();
        $sub = array();
        $linkOptions = array();
        $itemOptions = array();
        /* @var $models Catalog[] */
        //if($currentLevel==2) {CVarDumper::dump($models);echo "------------------------------------------------------------";}
        //$sub=makeItemsCatalogArray($model->subcatalogs_show,$level);
        //CVarDumper::dump($currentLevel);
        foreach($models as $model)
        {

            if($model->subcatalogs_show != null && $currentLevel < $this->catalog_levels)
            {
                $level = $currentLevel + 1;
                $sub = $this->makeItemsCatalogArray($model->subcatalogs_show, $level);
                //CVarDumper::dump($model->subcatalogs_show);
                //echo "inner<br />";
            }
            $url = $this->createCatalogUrl($model);
            $items[] = array('label' => $model->caption, 'url' => $url, 'items' => $sub, 'itemOptions' => $itemOptions, 'linkOptions' => $linkOptions);
            $sub = array();
        }
        return $items;
    }

    /**
     * Упрощенная проверка активности элемента
     *
     * Было: проверялось, принадлежит ли
     * url в данном пункте меню к вызванному в данный момент
     * контроллеру.
     * 
     * Стало: проверяется, равен ли вызванный url
     * значению url в данном пункте меню.
     */
    protected function isItemActive($item, $route)
    {
        if(isset($item['url']) && $item['url'] && !strcasecmp(trim($item['url'], '/'), $route))
        {
            return true;
        }
        return false;
    }

    /**
     * Вспомогательная функция генерации URL для пунктов меню.
     *
     * Проверяется тип ссылки, указанной в базе данных:
     *
     *   1) если в поле 'controller' в БД указан существующий контроллер,
     *      то URL генерируется по поавилу из MLUrlRule.
     *
     *   2) если поле 'controller' пустое, но в качестве ссылки указана
     *      внешняя ссылка с "http://" (ссылка на другой домен),
     *      то данная ссылка выводится без какой либо обработки.
     *
     *   3) если поле 'controller' пустое и ссылка без "http://",
     *      то считается, что данная ссылка внутренняя и должна 
     *      обрабатываться внутренними правилами разбора URL,
     *      для этого вначале добавляется '/'.
     */
    protected function createUrl(Menu $model)
    {
        if(!empty($model->controller))
        {
            return Yii::app()->createUrl('menu/multilevel', array('menu_id' => $model->id));
        }
        elseif(stristr($model->alias, 'http://') || $model->alias === '#' || $model->alias === '/')
        {
            return $model->alias;
        }
        return Yii::app()->createUrl('/'.$model->alias);
    }

    protected function createCatalogUrl(Catalog $model)
    {

        return Yii::app()->createUrl('catalog/category', array('id' => $model->id));
    }

    public function getBreadcrumbs()
    {
        $model = Menu::model()->findByPk($this->curentMenuId);
        if($model === NULL)
            return null;
        $bc = array($model->caption);
        while(($model = $model->parent) !== null)
        {
            if(($link = $this->createUrl($model)) !== '')
                $bc[$model->caption] = $link;
        }
        return array_reverse($bc);
    }

    public static function staticWidget()
    {
        if(empty(self::$_widgetInstance))
        {
            self::$_widgetInstance = new self;
        }
        return self::$_widgetInstance;
    }

}
