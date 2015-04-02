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
require_once 'include/common.php';
require '../include/com.fun.php';
chkadmin('comcat');
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
$nav = 'company';
$navig = 'comcat';
switch ($_REQUEST['act'])
{
	case 'list':
		$cat = get_com_cat_list();
	    include tpl('list_com_cat', 'com');
	break;

	case 'add':
        $cat = get_com_cat_list();
		$cats = $db->getAll("SELECT * from {$table}com_cat WHERE parentid=0");
		$maxorder = $db->getOne("SELECT MAX(catorder) FROM {$table}com_cat");
		$maxorder = $maxorder + 1;
	    include tpl('add_com_cat', 'com');
	break;

	case 'insert':
		if(empty($_REQUEST[catname]))show($L['enter_name']);
		$len = strlen($_REQUEST[catname]);
		if($len < 2 || $len > 50)show($L['title_2_50_characters']);

		$catname     = trim($_REQUEST['catname']);
	    $parentid    = intval($_REQUEST['parentid']);
		$catorder    = intval($_REQUEST['catorder']);
		$keywords    = trim($_REQUEST['keywords']);
		$description = trim($_REQUEST['desc']);

		if(empty($catorder)) {
			$sql = "SELECT MAX(catorder) FROM {$table}com_cat";
			$maxorder = $db->getOne($sql);
			$catorder = $maxorder + 1;
		}
		$sql = "INSERT INTO {$table}com_cat (catname,keywords,description,parentid,catorder) VALUES ('$catname','$keywords','$description','$parentid','$catorder')";
		$res = $db->query($sql);

		clear_caches('phpcache');
		admin_log("".$L['category_com_added_log']." $cataname");
		show($L['done'],'comcat.php');
	break;

	case 'edit':
	    $catid = intval($_REQUEST['catid']);
		$sql = "SELECT * FROM {$table}com_cat WHERE catid = '$catid'";
		$cat = $db->getRow($sql);
		$sql  = "SELECT * FROM {$table}com_cat WHERE parentid = '0'";
	    $cats = $db->getAll($sql);

		include tpl('edit_com_cat', 'com');
	break;
	
	case 'update':
		if(empty($_REQUEST[catname]))show($L['enter_name']);
		$len = strlen($_REQUEST[catname]);
		if($len < 2 || $len > 50)show($L['title_2_50_characters']);
        
		$catid       = intval($_REQUEST['catid']);
		$catname     = trim($_REQUEST['catname']);
	    $parentid    = intval($_REQUEST['parentid']);
		$catorder    = intval($_REQUEST['catorder']);
		$keywords    = trim($_REQUEST['keywords']);
		$description = trim($_REQUEST['desc']);

		$sql = "UPDATE {$table}com_cat SET catname='$catname',keywords='$keywords',description='$description',parentid='$parentid',catorder='$catorder' WHERE catid = '$catid'";
		$res = $db->query($sql);
		
		clear_caches('phpcache');
		admin_log("".$L['category_com_changed_log']." $catname");
		$link = "comcat.php?act=list";
		show($L['done'], $link);
	break;

	case 'delete':
		$catid = intval($_REQUEST['catid']);
		if(empty($catid))show($L['a_parameter_error']);
		
		$sql = "SELECT COUNT(*) FROM {$table}com_cat WHERE parentid = '$catid' ";
		if($db->getOne($sql)>0)show($L['this_category_there_are_subcategories']);
		
		$sql = "SELECT COUNT(*) FROM {$table}com WHERE catid = '$catid' ";
		if($db->getOne($sql)>0)show($L['this_category_there_are_company']);

		$sql = "DELETE FROM {$table}com_cat WHERE catid='$catid'";
	    $db->query($sql);

		clear_caches('phpcache');
		admin_log("".$L['category_com_delete_log']." $catid");
		$link = 'comcat.php?act=list';
		show($L['done'], $link);
	break;
	default:
	show($L['a_invalid_request'], './');
	break;
}
?>