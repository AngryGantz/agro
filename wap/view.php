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
require dirname(__FILE__) . '/include/common.inc.php';

if(isset($_REQUEST['id']))$id = intval($_REQUEST['id']);
if(empty($id)) {
	header("Location: ./\n");
	exit;
}

$sql = "SELECT a.*,c.catname,r.areaname FROM {$table}info AS a LEFT JOIN {$table}category AS c ON c.catid=a.catid LEFT JOIN {$table}area AS r ON r.areaid = a.areaid WHERE id='$id'";
$info = $db->getrow($sql);
if(empty($info)){die($L['view_does_not_exist']);}
$info['content'] = strip_tags($info['content']);
extract($info);
if(!$is_check)die($L['this_listing_verification']);

if(!$CFG['expired_view']) {
	if($enddate<time() && $enddate>0) {
		$phone=empty($phone) ? '' : ''.$L['time_is_up'].'';
		$email=empty($email) ? '' : ''.$L['time_is_up'].'';
		$icq=empty($icq) ? '' : ''.$L['time_is_up'].'';
	}
}
	$phone = empty($phone) ? '' : '<img src="'.$CFG['weburl'].'/do.php?act=show&num='.encrypt($phone, $CFG['crypt']).'" align="absmiddle">';
	$email = empty($email)? '' : '<img src="'.$CFG['weburl'].'/do.php?act=show&num='.encrypt($email,	$CFG['crypt']).'" align="absmiddle">';
	$icq = empty($icq)? '' : '<img src="'.$CFG['weburl'].'/do.php?act=show&num='.encrypt($icq, $CFG['crypt']).'" align="absmiddle">';
$postdate = date('Y-m-d-H-i', $postdate);
$lastdate = enddate($enddate);
$custom = get_info_custom($id);
$db->query("UPDATE {$table}info SET click=click+1 WHERE id='$id'");
$seo['title'] = $title . ' - '.$catname. ' - '.$CFG['webtitle'].'';
include tpl('view');
?>