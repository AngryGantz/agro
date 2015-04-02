<?php
/***********************************************************************
 (C)2015 AngryGantz - angrygantz@gmail.com
 -----------------------------------------------------------------------
************************************************************************/
define('IN_AWEBCOM', true);
require dirname(__FILE__) . '/include/common.php';
$slider = get_slider();//слайдер
$links = get_link_list();//ссылки, кнопки партнеров
$helps = get_index_help($INF['helpshome']);//FAQ
$company = get_index_com($INF['companyhome']);//Компании
$articles = get_index_article($INF['newsshome']);//Статьи
$comments   = get_new_comment($INF['commentshome']);//последние комментарии. Не используется в шаблоне по умолчанию
$new_info   = get_info('','',$INF['innew'],'','date',$INF['insimnew']);
$pro_info   = get_info('','',$INF['invip'],'pro','',$INF['insimvip']);
$top_info   = get_info('','',$INF['intop'],'top','',$INF['insimtop']);
$hot_info   = get_info('','',$INF['inhot'],'','click',$INF['insimhot']);
$thumb_info = get_info('','',$INF['innewizo'],'','date',$INF['insimnewizo'],'1'); //с изображениями. Не используется в шаблоне по умолчанию
$seo['title'] = $CFG['webtitle'];
$seo['keywords'] = $CFG['keywords'];
$seo['description'] = $CFG['description'];
include template('index');
?>