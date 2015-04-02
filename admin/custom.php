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
chkadmin('custom');
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
$nav = 'board';
$navig = 'custom';
switch ($_REQUEST['act'])
{
	case 'list':
		$cat_list = cat_options();
		$catid = isset($_REQUEST['catid']) ? intval($_REQUEST['catid']) : 0;
		$sql = "SELECT * FROM {$table}custom where catid='$catid'";
		$res = $db->query($sql);
		$cus = array();
		$type = array($L['textbox'],$L['drop_down_list'],'Checkbox');
		while($row = $db->fetchRow($res)) {
			$row['custype']   = $type[$row['custype']];
			$row['is_search'] = $row['search']>0 ? $L['yes'] : $L['no'];
			$cus[] = $row;
		}
		include tpl('list_custom');
	break;

	case 'add':
		$cat_list = cat_options();
		include tpl('add_custom');
	break;

	case 'insert':
		$cusname = trim($_POST['cusname']);
		$catid   = intval($_POST['catid']);
		$search  = intval($_POST['search']);
		$custype = intval($_POST['custype']);
		$value   = trim($_POST['value']);
		$unit    = trim($_POST['unit']);
		
		if(empty($cusname))show($L['enter_name']);
		if(empty($catid))show($L['category_select']);
		if(($custype=='1' || $custype=='2') && empty($_POST['value']))show($L['fill_out_the']);
		
		$sql = "INSERT INTO {$table}custom (catid,cusname,custype,value,search,unit,listorder) VALUES ('$catid','$cusname','$custype','$value','$search','$unit','$listorder')";
		$db->query($sql);
		
		clear_caches('phpcache');
		admin_log("".$L['cus_added_log']." $cusname");
		$link = 'custom.php?act=add';
		show($L['done'], $link);
	break;

	case 'edit':
		$id = intval($_REQUEST['id']);
		$sql = "SELECT * FROM {$table}custom WHERE cusid = '$id' ";
		$custom = $db->getRow($sql);
		@extract($custom, EXTR_PREFIX_SAME, '');
		$cat_list = cat_options($catid);
		foreach((array)$cats AS $cat) {
			$option .= "<option value=$cat[catid] style='color:red;'";
			$option .= ($catid == $cat[catid]) ? " selected='selected'" : '';
			$option .= ">$cat[catname]</option>";
		}
		include tpl('edit_custom');
	break;

	case 'update':
		if(empty($_REQUEST['cusname']))show($L['enter_name']);
		if(empty($_REQUEST['catid']))show($L['category_select']);
		if(($custype=='1' || $custype=='2') && empty($_POST['value']))show($L['fill_out_the']);
		
		$id        = intval($_REQUEST['id']);
		$cusname   = trim($_REQUEST['cusname']);
		$catid     = intval($_REQUEST['catid']);
		$is_search = intval($_REQUEST['is_search']);
		$custype   = intval($_REQUEST['custype']);
		$value	   = trim($_REQUEST['value']);
		$unit      = trim($_REQUEST['unit']);

		$sql = "UPDATE {$table}custom SET catid='$catid',cusname='$cusname',custype='$custype',value='$value',search='$is_search',listorder='$listorder',unit='$unit' WHERE cusid = '$id' ";
		$db->query($sql);
		
		clear_caches('phpcache');
		admin_log("".$L['cus_changed_log']." $cusname");
		$link = trim($_REQUEST['refer']);
		show($L['done'], $link);
	break;

	case 'delete':
		$id = intval($_REQUEST['id']);
		if(empty($id))show($L['a_parameter_error']);
		$row = $db->getRow("select * from {$table}custom where cusid='$id' ");

	    $db->query("delete from {$table}custom where cusid='$id'");
		$db->query("delete from {$table}cus_value where cusid='$id'");
		
		clear_caches('phpcache');
		admin_log("".$L['cus_delete_log']." $id");
		$link = 'custom.php?act=list';
		show($L['done'], $link);
	break;
	default:
	show($L['a_invalid_request'], './');
	break;
}
?>
