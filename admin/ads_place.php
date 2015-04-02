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
require_once dirname(__FILE__) . '/include/common.php';
chkadmin('ads_place');
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
$nav = 'options';
$navig = 'ads_place';
switch ($_REQUEST['act'])
{
	case 'list':
		$sql = "SELECT * FROM {$table}ads_place";
		$place = $db->getAll($sql);
	    include tpl('list_ads_place');
	break;

	case 'add':
		include tpl('add_ads_place');
	break;

	case 'insert':
		if(empty($_POST['placename']))show($L['enter_name']);
		if(empty($_POST['width']))show($L['enter_width']);
		if(empty($_POST['height']))show($L['enter_height']);
		
		$placename = trim($_POST['placename']);
		$width     = intval($_POST['width']);
		$height    = intval($_POST['height']);
		$introduce = trim($_POST['introduce']);

		$sql = "INSERT INTO {$table}ads_place (placename,width,height,introduce) VALUES ('$placename','$width','$height','$introduce')";
		$res = $db->query($sql);

		admin_log("".$L['adv_block_added_log']." $title");
		$link = 'ads_place.php';
		show($L['done'], $link);
	break;
	
	case 'edit':
		$id = intval($_REQUEST['id']);
		$sql = "SELECT * FROM {$table}ads_place WHERE placeid = '$id'"; 
		$place = $db->getRow($sql);
		include tpl('edit_ads_place');
	break;

	case 'update':
		if(empty($_POST['placename']))show($L['enter_name']);
		if(empty($_POST['width']))show($L['enter_width']);
		if(empty($_POST['height']))show($L['enter_height']);
		
		$id        = intval($_POST['id']);
		$placename = trim($_POST['placename']);
		$width     = trim($_POST['width']);
		$height    = intval($_POST['height']);
		$introduce = trim($_POST['introduce']);

		$sql = "UPDATE {$table}ads_place SET 
		placename='$placename',
		width='$width',
		height='$height',
		introduce='$introduce' 
		WHERE placeid = '$id' ";
		$res = $db->query($sql);

		admin_log("".$L['adv_block_changed_log']." $placename");
		$link = 'ads_place.php';
		show($L['done'], $link);
	break;

	case 'delete':
		$id = intval($_REQUEST['id']);
		if(empty($id))show($L['a_parameter_error']);

		$sql = "select count(*) from {$table}ads where placeid='$id'";
		$count = $db->getOne($sql);
		if($count>0)show($L['first_remove_adv']);

		$sql = "DELETE FROM {$table}ads_place WHERE placeid='$id'";
	    $res = $db->query($sql);
		admin_log("".$L['adv_block_delete_log']." $id");
		$link = 'ads_place.php';
		show($L['done'], $link);
	break;
	default:
	show($L['a_invalid_request'], './');
	break;
}
?>