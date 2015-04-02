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
chkadmin('type');
$navig = 'types';
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
$module = $_REQUEST['module'];
$nav = $module;
switch ($_REQUEST['act'])
{
	case 'list':
		$sql = "select * from {$table}type where module='$module' ";
		$type = $db->getAll($sql);
	    include tpl('list_type');
	break;

	case 'add':
		$maxorder = $db->getOne("SELECT MAX(listorder) FROM {$table}type where module='$module'");
		$listorder = $maxorder + 1;
	    include tpl('add_type');
	break;

	case 'insert':
		if(empty($_REQUEST['typename']))show($L['enter_name']);
		$len = strlen($_REQUEST['typename']);
		if($len<2 || $len>50)show($L['title_2_50_characters']);

		$typename    = trim($_REQUEST['typename']);
		$listorder   = intval($_REQUEST['listorder']);
		$keywords    = trim($_REQUEST['keywords']);
		$description = trim($_REQUEST['description']);

		if(empty($listorder)) {
			$sql = "SELECT MAX(listorder) FROM {$table}type";
			$maxorder = $db->getOne($sql);
			$listorder = $maxorder + 1;
		}
		$sql = "INSERT INTO {$table}type (typename,listorder,keywords,description,module) VALUES ('$typename','$listorder','$keywords','$description','$module')";
		$res = $db->query($sql);
		
		admin_log("".$L['category_added_log']." $typeaname");
		show($L['done'],"type.php?act=list&module=$module");
	break;

	case 'edit':
	    $typeid = intval($_REQUEST['id']);
		$sql = "SELECT * FROM {$table}type WHERE typeid = '$typeid'";
		$type = $db->getRow($sql);
		include tpl('edit_type');
	break;

	case 'update':
		if(empty($_REQUEST['typename']))show($L['enter_name']);
		$len = strlen($_REQUEST['typename']);
		if($len<2 || $len>50)show($L['title_2_50_characters']);
		
		$typeid      = intval($_REQUEST['typeid']);
		$typename    = trim($_REQUEST['typename']);
		$listorder   = intval($_REQUEST['listorder']);
		$keywords    = trim($_REQUEST['keywords']);
		$description = trim($_REQUEST['description']);

		if(empty($listorder)) {
			$sql = "SELECT MAX(listorder) FROM {$table}type where module='$module'";
			$maxorder = $db->getOne($sql);
			$listorder = $maxorder + 1;
		}
		$sql = "UPDATE {$table}type SET typename='$typename',listorder='$listorder',keywords='$keywords',description='$description' WHERE typeid = '$typeid'";
		$res = $db->query($sql);

		admin_log("".$L['category_changed_log']." $typename");
		$link = "type.php?act=list&module=$module";
		show($L['done'], $link);
	break;

	case 'delete':
		$typeid = intval($_REQUEST['id']);
		if(empty($typeid))show($L['a_parameter_error']);

		$sql = "SELECT COUNT(*) FROM {$table}help WHERE typeid = '$typeid' ";
		if($db->getOne($sql)>0)show($L['this_category_there_are_info']);

	    $db->query("DELETE FROM {$table}type WHERE typeid='$typeid'");

		admin_log("".$L['category_delete_log']." $typeid");
		$link = "type.php?act=list&module=$module";
		show($L['done'], $link);
	break;
	default:
	show($L['a_invalid_request'], './');
	break;
}
?>