<?php

class MenuForm extends CFormModel
{

    public $menu;
    public $id;
    public $parent_id;
    public $caption;
    public $controller;
    public $alias;
    public $title;
    public $node_id_pages;
    public $node_id_news;
    public $node_id_articles;
    public $node_id_gallery;
    public $node_id_catalog;
    public $image;
    public $active;

    public function rules()
    {
        return array(
            array(
                'caption, alias',
                'required'),
            array(
                'id,parent_id, controller, active, node_id_pages,node_id_news,node_id_articles,node_id_gallery,title,image, node_id',
                'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'caption'          => Yii::t('formFields', 'Caption'),
            'alias'            => Yii::t('formFields', 'Alias/Link'),
            'controller'       => Yii::t('formFields', 'Type'),
            'node_id_pages'    => Yii::t('moduleCaptions', 'Pages'),
            'node_id_news'     => Yii::t('moduleCaptions', 'News'),
            'node_id_articles' => Yii::t('moduleCaptions', 'Articles'),
            'node_id_gallery'  => Yii::t('moduleCaptions', 'Galleries'),
            'title'            => Yii::t('formFields', 'Title attribute'),
            'image'            => Yii::t('formFields', 'Image'),
            'active'           => Yii::t('formFields', 'Active'),
            'parent_id'        => Yii::t('formFields', 'Parent ID'),
        );
    }

    public function getNodes()
    {
        return array(
            ''        => Yii::t('formFields', 'External Link'),
            'pages'   => Yii::t('moduleCaptions', 'Page'),
            'news'    => Yii::t('moduleCaptions', 'News post'),
            'gallery' => Yii::t('moduleCaptions', 'Gallery'),
            'catalog' => Yii::t('moduleCaptions', 'Catalog'),
            //  'catalog' => 'Каталог'
        );
    }

    public function getNode_id()
    {
        if($this->controller === 'pages')
        {
            return $this->node_id_pages;
        }
        elseif($this->controller === 'news')
        {
            return $this->node_id_news;
        }
        elseif($this->controller === 'articles')
        {
            return $this->node_id_articles;
        }
        elseif($this->controller === 'gallery')
        {
            return $this->node_id_gallery;
        }
        elseif($this->controller === 'catalog')
        {
            return $this->node_id_catalog;
        }
        else
        {
            return 0;
        }
    }

    public function setNode_id($value)
    {
        if($this->controller === 'pages')
        {
            $this->node_id_pages = $value;
        }
        elseif($this->controller === 'news')
        {
            $this->node_id_news = $value;
        }
        elseif($this->controller === 'articles')
        {
            $this->node_id_articles = $value;
        }
        elseif($this->controller === 'gallery')
        {
            $this->node_id_gallery = $value;
        }
        elseif($this->controller === 'catalog')
        {
            $this->node_id_catalog = $value;
        }
    }

}
