<?php
/***********************************************************************
 AngryGantz Studio Web Pro
 (C)2008 StudioWeb.Pro - http://studioweb.pro/
 -----------------------------------------------------------------------
Данный материал является объектом  интеллектуальной собственности
компании StudioWeb.Pro. Воспроизведение (распространение, копирование, использование)
данного материала в целом или его фрагмента возможно только с разрешения
представителя компании StudioWeb.Pro
************************************************************************/
define('IN_AWEBCOM', true);
require dirname(__FILE__) . '/include/common.php';
if(isset($_REQUEST['id']))$id = intval($_REQUEST['id']);
if(empty($id)) showmsg($L['invalid_request']);
$static_info = $db->getRow("select * from {$table}static where id='$id'");
if(empty($static_info))showmsg($L['info_does_not_exist'], 'index.php');
extract($static_info);
$postdate = date('Y-m-d-H-i', $postdate);
if(!empty($url)) {
	header("Location: $url");
	exit;
}
if(!$is_show)showmsg($L['this_page_verification'], 'index.php');
$res = $db->query("select * from {$table}static order by id");
$statics = array();
while($row = $db->fetchRow($res)) {
	$row['title'] = cut_str($row['title'], '80');
	$row['url'] = url_rewrite('static', array('aid'=>$row['id']));
	$statics[] = $row;
}
$seo['title'] = $title . ' - '. $CFG['webname']. '';
$seo['keywords'] = str_replace("//", '', addslashes($keywords));
$seo['description'] = !empty($description) ? $description : cut_str(strip_tags($content),200);
include template('static');
?>