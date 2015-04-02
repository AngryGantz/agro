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
chkadmin('static');
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
$nav = 'options';
$navig = 'static';
switch ($_REQUEST['act'])
{
	case 'list':
		$res = $db->query("SELECT * FROM {$table}static ORDER BY id DESC");
		$static = array();
		while($row = $db->fetchRow($res)) {
			$row['postdate'] = date('Y-m-d-H-i',$row['postdate']);
			$row['is_show'] = ($row['is_show']=='1') ? $L['active_a'] : $L['moderated'];
			$static[] = $row;
		}
	    include tpl('list_static');
	break;

	case 'add':
		$maxorder = $db->getOne("SELECT MAX(staticorder) FROM {$table}static");
		$maxorder = $maxorder + 1;
		include tpl('add_static');
	break;

	case 'insert':
		if(empty($_POST['title']))show($L['enter_name']);
		if(empty($_POST['content']))show($L['enter_contents']);
		
		$title       = htmlspecialchars(trim($_POST['title']));
		$url         = trim($_POST['url']);
		$staticorder  = intval($_POST['staticorder']);
		$content     = trim($_POST['content']);
		$keywords    = htmlspecialchars(trim($_POST['keywords']));
		$description = addslashes(get_intro($_POST['content'],150));
		//$description = htmlspecialchars(trim($_POST['description']));
		$type     = trim($_POST['type']);
		$is_show     = trim($_POST['is_show']);
		$postdate    = time();

		if(empty($staticorder)) {
			$sql = "SELECT MAX(staticorder) FROM {$table}static";
			$maxorder  = $db->getOne($sql);
			$listorder = $maxorder + 1;
		}
		$sql = "INSERT INTO {$table}static (title,url,keywords,description,content,postdate,staticorder,type,is_show) VALUES ('$title','$url','$keywords','$description','$content','$postdate','$listorder','$type','$is_show')";
		$res = $db->query($sql);

		admin_log("".$L['page_added_log']." $title");
		$link = 'static.php';
		show($L['done'], $link);
	break;
	
	case 'edit':
		$id = intval($_REQUEST['id']);
		$sql = "SELECT * FROM {$table}static WHERE id = '$id'";
		$static = $db->getRow($sql);
		$content = $static['content'];
		include tpl('edit_static');
	break;

	case 'update':
		if(empty($_POST['title']))show($L['enter_name']);
		if(empty($_POST['content']))show($L['enter_contents']);
		
		$id          = htmlspecialchars(intval($_POST['id']));
		$title       = trim($_POST['title']);
		$url         = trim($_POST['url']);
		$staticorder  = intval($_POST['staticorder']);
		$keywords    = htmlspecialchars(trim($_POST['keywords']));
		$description = addslashes(get_intro($_POST['content'],150));
		//$description = htmlspecialchars(trim($_POST['description']));
		$content     = trim($_POST['content']);
		$type        = trim($_POST['type']);
		$is_show     = trim($_POST['is_show']);

		if(empty($staticorder)) {
			$sql = "SELECT MAX(staticorder) FROM {$table}static";
			$maxorder  = $db->getOne($sql);
			$staticorder = $maxorder + 1;
		}

		$sql = "UPDATE {$table}static SET title='$title',url='$url',keywords='$keywords',description='$description',content='$content',staticorder='$staticorder',type='$type',is_show='$is_show' WHERE id = '$id' ";
		$res = $db->query($sql);

		admin_log("".$L['page_changed_log']." $title");
		$link = 'static.php?act=list';
		show($L['done'], $link);
	break;

	case 'batch':
		$id = is_array($_REQUEST['id']) ? join(',', $_REQUEST['id']) : intval($_REQUEST['id']);
		if(empty($id))show($L['choice_records']);
		$sql = "delete from {$table}static where id in ($id)";
        $re = $db->query($sql);
		admin_log("".$L['page_delete_log']." $id");
		$link = 'static.php?act=list';
		show($L['done'], $link);
	break;
	default:
	show($L['a_invalid_request'], './');
	break;

}
?>