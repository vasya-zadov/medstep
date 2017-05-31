<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RssNewsWidget
 *
 * @author Alexander Larkin <lcdee@andex.ru>
 */
class RssNewsWidget extends CWidget
{

    protected $_cached = array();
    public $data = array();

    public function init()
    {
        if(!file_exists(Yii::getPathOfAlias('application.runtime').DIRECTORY_SEPARATOR.'RssNewsWidget.cache'))
        {
            file_put_contents(Yii::getPathOfAlias('application.runtime').DIRECTORY_SEPARATOR.'RssNewsWidget.cache', json_encode(array()));
        }

        $this->_cached = json_decode(file_get_contents(Yii::getPathOfAlias('application.runtime').DIRECTORY_SEPARATOR.'RssNewsWidget.cache'), true);

        if(app()->settings->rssFeedActive && app()->settings->rssFeedLink)
        {
            $rssHeaders = @get_headers(app()->settings->rssFeedLink, 1);
            if($rssHeaders && $rssHeaders[0] = 'HTTP/1.1 200 OK')
            {
                $this->parseRss();
            }
            else
            {
                $this->data = $this->_cached;
            }
        }
        array_splice($this->_cached, 3);
        file_put_contents(Yii::getPathOfAlias('application.runtime').DIRECTORY_SEPARATOR.'RssNewsWidget.cache', json_encode($this->_cached));
    }

    public function parseRss()
    {
        $contents = @file_get_contents(app()->settings->rssFeedLink);
        if(!$contents)
            return;
        $xm = simplexml_load_string($contents);
        $data = $xm->channel;
        $dataItems = array();
        $k = 0;
        foreach($xm->channel->item as $item)
        {
            $k++;
            if($k > 3)
                continue;
            $cachedItem = $this->getCached($item->link);
            if($cachedItem)
            {
                $dataItems[$k] = (array) $cachedItem;
                $this->setCached($item->link, $cachedItem);
                continue;
            }
            $dataItems[$k] = array(
                'link'        => (string) $item->link,
                'image'       => (string) $item->enclosure['url'],
                'caption'     => (string) $item->title,
                'description' => (string) $item->description
            );
            if(!$dataItems[$k]['caption'] || !$dataItems[$k]['description'])
            {
                $dataItems[$k] = $this->parseFromSite($dataItems[$k]);
            }
            $this->setCached($dataItems[$k]['link'], $dataItems[$k]);
        }
        $this->data = $dataItems;
    }

    public function parseFromSite($item)
    {
        require_once(Yii::getPathOfAlias('cmscore.extensions.SimpleHtmlDom').'.php');

        $html = file_get_html($item['link']);
        if($html)
        {
            if(!$item['caption'])
            {
                $item['caption'] = trim(iconv('CP1251', 'UTF-8', $html->find('.news_title', 0)->text()));
            }
            if(!$item['description'])
            {
                $item['description'] = trim(iconv('CP1251', 'UTF-8', $html->find('.news_annotation', 0)->text()));
            }
        }
        return $item;
    }

    public function getCached($link)
    {
        return isset($this->_cached[(string) $link]) ? $this->_cached[(string) $link] : false;
    }

    public function setCached($link, $data)
    {
        $this->_cached = CMap::mergeArray(array((string) $link => $data), $this->_cached);
    }

    public function run()
    {
        if(!empty($this->data))
            $this->render('view');
    }

}
