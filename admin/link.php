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
chkadmin('link');
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
$nav = 'options';
$navig = 'link';
switch($_REQUEST['act'])
{
	case 'list':
		$sql = "SELECT * FROM {$table}link ORDER BY id DESC";
		$links = $db->getAll($sql);
	    include tpl('list_link');
	break;

	case 'add':
		$maxorder = $db->getOne("SELECT MAX(linkorder) FROM {$table}link");
		$maxorder = $maxorder + 1;
	    include tpl('add_link');
	break;

	case 'insert':
		if(empty($_POST['webname']))show($L['enter_name']);
		if(empty($_POST['url']))show($L['enter_url']);

		$webname   = trim($_POST['webname']);
		$url       = trim($_POST['url']);
		$linkorder = intval($_POST['order']);
		$logo      = trim($_POST['logo']);
		
		if(empty($linkorder)) {
			$sql = "SELECT MAX(linkorder) FROM {$table}link";
			$maxorder  = $db->getOne($sql);
			$linkorder = $maxorder + 1;
		}

		$sql = "INSERT INTO {$table}link (webname,url,linkorder,logo) VALUES ('$webname','$url','$linkorder','$logo')";
		$res = $db->query($sql);
		clear_caches('phpcache', 'link');
		admin_log("".$L['link_added_log']." $webname");
		show($L['done'],'link.php');
	break;

	case 'edit':
	    $linkid = intval($_REQUEST['linkid']);
		$sql = "SELECT * FROM {$table}link WHERE id = '$linkid'";
		$link = $db->getRow($sql);
		include tpl('edit_link');
	break;

	case 'update':
		if(empty($_POST['webname']))show($L['enter_name']);
		if(empty($_POST['url']))show($L['enter_url']);

        $linkid    = intval($_POST['linkid']);
		$webname   = trim($_POST['webname']);
		$url       = trim($_POST['url']);
		$linkorder = intval($_POST['order']);
		$logo      = trim($_POST['logo']);
		
		if(empty($linkorder)) {
			$sql = "SELECT MAX(linkorder) FROM {$table}link";
			$maxorder  = $db->getOne($sql);
			$linkorder = $maxorder + 1;
		}
		$sql = "UPDATE {$table}link SET webname='$webname',url='$url',linkorder='$linkorder',logo='$logo' WHERE id = '$linkid'";
		$res = $db->query($sql);
		clear_caches('phpcache', 'link');
		admin_log("".$L['link_changed_log']." $webname");
		$link = "link.php";
		show($L['done'], $link);
	break;

	case 'delete':
		$id = intval($_REQUEST['linkid']);
		if(empty($id))show($L['choice_records']);
		$sql = "DELETE FROM {$table}link WHERE id='$id'";
	    $res = $db->query($sql);
		clear_caches('phpcache', 'link');
		admin_log("".$L['link_delete_log']." $id");
		show($L['done'], 'link.php');
	break;

	case 'batch':
		$id = !empty($_POST['id']) ? join(',', $_POST['id']) : 0;
		if(empty($id))show($L['choice_records']);
		$sql = "DELETE FROM {$table}link WHERE id IN ($id)";
        $re = $db->query($sql);

		clear_caches('phpcache', 'link');
		admin_log("".$L['link_delete_log']." $id");
		show($L['done'], 'link.php');
	break;
	default:
	show($L['a_invalid_request'], './');
	break;
}
?>