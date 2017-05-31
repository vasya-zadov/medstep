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

/**
 * Description of Sitemap
 *
 * @author Alexander Larkin <lcdee@andex.ru>
 */
class Sitemap
{
    private $_levels = null;
    private $_host;
    
    private static $_instance;
    public static function buildLinks($args)
    {
        $instance = self::getInstance($args);
        
        return $instance->makeLinks();
    }
    
    public static function getInstance($args = array())
    {
        if(!self::$_instance)
        {
            self::$_instance = new self($args);
        }
        return self::$_instance;
    }
    
    private function __construct($args)
    {
        foreach($args as $name=>$value)
        { 
            if(method_exists($this, 'set'.ucFirst($name)))
                call_user_func(array($this,'set'.ucFirst($name)),$value);
            else
                throw new CHttpException(500);
        }
    }
    
    private function makeLinks()
    {
        if(!$this->getHost())
            throw new CHttpException(500,'Please specify host');
        
        set_time_limit(0);
        
        require_once 'SimpleHtmlDom.php';
        
        $links = array('/'=>'');
        
        $page = file_get_html($this->getHost());
        
        $this->getLinks($page, $links);
        
        return $links;
    }
    
    private function getLinks($page,&$links,$level=1)
    {
        if(!($page instanceof simple_html_dom))
            return;
        
        if($this->getLevels() && $level>$this->getLevels())
            return;
        
        /* @var $linksItems simple_html_dom_node[] */
        $linksItems = $page->find('a');
        
        foreach($linksItems as $item)
        {
            $attributes = $item->getAllAttributes();
            $text = trim(strip_tags($item->innertext()));
            
            if(!isset($attributes['href']))
                continue;
            
            if(isset($attributes['nofollow']))
                continue;
            
            if($text=='')
                continue;
            
            if(stristr($attributes['href'], '#'))
                continue;
            
            if(strpos($attributes['href'], '/')!==0)
                continue;
            
            if(!isset($links[$attributes['href']]))
            {
                $links[$attributes['href']] = $text;
                
                $code = get_headers($this->getHost().'/'.ltrim($attributes['href'],'/'));
                if($code[0]=='HTTP/1.1 200 OK')
                {
                    $level+=1;
                    $this->getLinks(file_get_html($this->getHost().$attributes['href']), $links, $level);
                }
            }
        }
        
        return $links;
    }
    
    public function setHost($value)
    {
        $this->_host = $value;
    }
    public function getHost()
    {
        if(empty($this->_host))
            return request()->hostInfo;
        return $this->_host;
    }
    public function setLevels($value)
    {
        $this->_levels = $value;
    }
    public function getLevels()
    {
        if($this->_levels===null)
            return 0;
        return $this->_levels;
    }
    
}
