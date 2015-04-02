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
chkadmin('area');
$nav = 'board';
$navig = 'area';
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
switch ($_REQUEST['act'])
{
	case 'list':
		$area = get_area_list();
	    include tpl('list_area');
	break;

	case 'add':
		$area = $db->getAll("SELECT * from {$table}area WHERE parentid=0");
		$maxorder = $db->getOne("SELECT MAX(areaorder) FROM {$table}area");
		$maxorder = $maxorder + 1;
	    include tpl('add_area');
	break;

	case 'insert':
		if(empty($_REQUEST['areaname']))show($L['enter_name']);
		$len = strlen($_REQUEST['areaname']);
		if($len < 2 || $len > 50)show($L['title_2_50_characters']);
		$areaname  = trim($_REQUEST['areaname']);
		$parentid  = intval($_REQUEST['parentid']);
		$areaorder = intval($_REQUEST['areaorder']);

		if(empty($areaorder)) {
			$sql = "SELECT MAX(areaorder) FROM {$table}area";
			$maxorder = $db->getOne($sql);
			$areaorder = $maxorder + 1;
		}
		$sql = "INSERT INTO {$table}area (areaname,parentid,areaorder) VALUES ('$areaname','$parentid','$areaorder')";
		$res = $db->query($sql);
		
		clear_caches('phpcache');
		admin_log("".$L['area_added_log']." $areaname");
		show($L['done'],'area.php');
	break;

	case 'edit':
	    $areaid = intval($_REQUEST['areaid']);
		$sql = "SELECT * FROM {$table}area WHERE areaid = '$areaid'";
		$area = $db->getRow($sql);
		$sql  = "SELECT * FROM {$table}area WHERE parentid = '0'";
	    $areas = $db->getAll($sql);	
		include tpl('edit_area');
	break;

	case 'update':
		if(empty($_REQUEST['areaname']))show($L['enter_name']);
		$len = strlen($_REQUEST['areaname']);
		if($len < 2 || $len > 50)show($L['title_2_50_characters']);
        
		$areaid    = intval($_REQUEST['areaid']);
		$areaname  = trim($_REQUEST['areaname']);
		$parentid  = intval($_REQUEST['parentid']);
		$areaorder = intval($_REQUEST['areaorder']);

		$sql = "UPDATE {$table}area SET areaname='$areaname',
		parentid='$parentid',
		areaorder='$areaorder'
		WHERE areaid = '$areaid'";
		$res = $db->query($sql);
		clear_caches('phpcache');
		admin_log("".$L['area_changed_log']." $areaname");        
		$link = "area.php?act=list";
		show($L['done'], $link);
	break;

	case 'delete':
		$areaid = intval($_REQUEST['areaid']);
		if(empty($areaid))show($L['choice_records']);
		$sql = "DELETE FROM {$table}area WHERE areaid='$areaid'";
	    $res = $db->query($sql);
		clear_caches('phpcache');
		admin_log("".$L['area_delete_log']." $areaid");
		$link = "area.php?act=list";
		show($L['done'], $link);
	break;
	default:
	show($L['a_invalid_request'], './');
	break;
}
?>