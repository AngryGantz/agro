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
$id = $_REQUEST['id'] ? intval($_REQUEST['id']) : '';
if(empty($id)) showmsg($L['invalid_request']);
$sql = "SELECT a.*,m.username FROM {$table}info AS a LEFT JOIN {$table}member AS m ON m.userid=a.userid WHERE a.id='$id'";
$info = $db->getRow($sql);
if(empty($info)) showmsg($L['view_does_not_exist'],'index.php');
$info['is_pro']   = $info['is_pro']>=time();
$info['is_top']   = $info['is_top']>=time();
$info['content'] = strip_tags($info['content']);
$info['mappoint'] = strip_tags($info['mappoint']);
$info['infouserid'] = $info['userid'];
unset($info['userid']);
extract($info);
$content = nl2br(htmlspecialchars($content));
$cat_array = get_cat_array();
$area_array = get_area_array();
$catname = $cat_array[$catid];
$areaname = $area_array[$areaid];

$phone_c = $phone;
$email_c = $email;
$icq_c    = $icq;

if($email)$crypt_email = encrypt($email,$CFG['crypt']);
if($icq)$js_icq = encrypt($icq, $CFG['crypt']);
$verf = get_one_ver();
$link_image = 1;
if($link_image == '1') {
	$phone = empty($phone) ? '' : '<img src="do.php?act=show&num='.encrypt($phone, $CFG['crypt']).'" align="absmiddle">';
	$email = empty($email)? '' : '<img src="do.php?act=show&num='.encrypt($email,	$CFG['crypt']).'" align="absmiddle">';
	$icq = empty($icq)? '' : '<img src="do.php?act=show&num='.encrypt($icq, $CFG['crypt']).'" align="absmiddle">';
} else {
	$phone = $phone_c;
	$email = $email_c;
	$icq = $icq_c;
}
if(!$CFG['visitor_view']) {
	if(empty($_userid)) {
		$phone=empty($phone) ? '' : ''.$L['available_only_after_registration'].'';
		$email=empty($email) ? '' : ''.$L['available_only_after_registration'].'';
		$icq=empty($icq) ? '' : ''.$L['available_only_after_registration'].'';
	}
}
if(!$CFG['expired_view']) {
	if($enddate<time() && $enddate>0) {
		$phone=empty($phone) ? '' : ''.$L['time_is_up'].'';
		$email=empty($email) ? '' : ''.$L['time_is_up'].'';
		$icq=empty($icq) ? '' : ''.$L['time_is_up'].'';
	}
}
$postdate = date('Y-m-d-H-i', $postdate);
$lastdate = enddate($enddate);
$mappoint = trim($mappoint);
if(!$is_check)showmsg($L['this_listing_verification'], 'index.php');
$custom = get_info_custom($id);
$images = $db->getAll("SELECT * FROM {$table}info_image WHERE infoid = '$id' ");
$db->query("UPDATE LOW_PRIORITY {$table}info SET click=click+1 WHERE id='$id'");/*Обновляем просмотры*/

$rec_info   = get_info('','',$INF['recinfo'],'pro','',$INF['imrecinfo']);//рекомендуемые.

/*ПОХОЖИЕ совпадение ключевых слов*/
$match_info = array();
$res = $db->query("SELECT id,title,thumb,keywords FROM {$table}info WHERE is_check=1 AND catid='$catid' AND id!=$id AND keywords='$keywords' ORDER BY id DESC LIMIT 0,5 ");
while($row = $db->fetchrow($res)) {
	if(!$row['keywords']) continue;
	$row['url'] = url_rewrite('view', array('vid'=>$row['id']));
	$match_info[] = $row;
}

$here_arr[] = array('name'=>$catname, 'url'=>url_rewrite('category',array('cid'=>$catid)));
$here_arr[] = array('name'=>$title);
$here = get_here($here_arr);

$seo['title'] = $title . ' - '.$catname. ' - '.$CFG['webname'].'';
$seo['keywords'] = $title.','.($catname ? str_replace(' ', ',', trim($keywords)).',' : '').strip_tags(trim($catname), ',');
if($keywords != $keywords) {
$keywords = str_replace("//", '', addslashes($keywords));
}
$seo['description'] = !empty($description) ? $description : cut_str(strip_tags($content),200);

$cat_info = get_cat_info($catid);
$template = $cat_info['viewtplname'] ? $cat_info['viewtplname'] : 'view';
include template($template);
?>