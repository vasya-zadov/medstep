<?php
require_once('protected/cmscore/extensions/SimpleHtmlDom.php');

$data = file_get_html('http://medstep.su/?q=doctors-view');

$items = $data->find('.doctors-list li');
$doctorItems = array();
foreach($items as $item)
{
    $doctorItem = array(
        'link'=>$item->find('a',0)->getAttribute('href'),
        'name'=>$item->find('.views-field-view-node a',0)->innertext().' '.$item->find('.views-field-title a',0)->innertext()
    );
    $doctorItems[] = $doctorItem;
}
foreach($doctorItems as &$doctorItem)
{
    $data = file_get_html('http://medstep.su'.$doctorItem['link']);
    $doctorItem['image'] = $data->find('.field-items img',0)->getAttribute('src');
    $text = $data->find('.field-name-body p',0);
    if($text)
        $doctorItem['text'] = $text->innertext();
    
    $doctorItem['spec'] = $data->find('.taxonomy-term-reference-0',0)->innertext();
    $category = $data->find('.field-name-field-doctor-category .taxonomy-term-reference-0',0);
    if($category)
        $doctorItem['category'] = $category->innertext();
}
$mysql = mysql_connect('localhost','uzrf-mo','vaqzu4A9cFzCRwBY');
mysql_select_db('uzrf-mo',$mysql);
mysql_query('SET NAMES utf8',$mysql);
foreach($doctorItems as $k=>$doctorItem)
{
    $photo = file_get_contents($doctorItem['image']);
    $tst = 'uploads/doctors/'.$k.'.jpg';
    @file_put_contents('uploads/doctors/'.$k.'.jpg',$photo);
    
    $result = mysql_query('SELECT id FROM yiiadyncms33_categories WHERE caption="'.$doctorItem['category'].'"',$mysql);
    $line = mysql_fetch_assoc($result);
    $categoryId = $line['id'] ? $line['id'] : 0;
    
    $result = mysql_query('SELECT id FROM yiiadyncms33_specs WHERE caption="'.$doctorItem['spec'].'"');
    $line = mysql_fetch_assoc($result);
    $specId = $line['id'] ? $line['id'] : 0;
    
    $sql = "INSERT INTO yiiadyncms33_doctors (name,photo,text,categoryId,specId) VALUES ('{$doctorItem['name']}','/{$tst}','<p>{$doctorItem['text']}</p>',{$categoryId},{$specId});";
    mysql_query($sql,$mysql) or die(mysql_error().' SQL Executed '.$sql);
}
mysql_close($mysql);