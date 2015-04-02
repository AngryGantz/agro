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
chkadmin('help');
$nav = 'help';
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
switch($_REQUEST['act'])
{
	case 'list':
        $navig = 'help';
		$page = empty($_REQUEST[page])? 1 : intval($_REQUEST['page']);
		$sql = "SELECT COUNT(*) FROM {$table}help order by id desc";
		$count = $db->getOne($sql);
		$pager = get_pager('help.php',array('act'=>'list'),$count,$page,'10');
		
		$sql = "SELECT a.*,t.typename FROM {$table}help as a left join {$table}type as t on t.typeid=a.typeid ORDER BY id DESC LIMIT $pager[start],$pager[size]";
		$res = $db->query($sql);
		$data = array();
		while($row=$db->fetchRow($res)) {
			$row['addtime']  = date('Y-m-d-H-i', $row['addtime']);
			$row['is_index'] = $row['is_index']==1;
			$data[] = $row;
		}
	    include tpl('list_help');
	break;

	case 'add':
        $navig = 'help_add';
		$maxorder = $db->getOne("SELECT MAX(listorder) FROM {$table}help");
		$maxorder = $maxorder + 1;
		$type_select = type_select('help');
		include tpl('add_help');
	break;

	case 'insert':
		if(empty($_POST['title']))show($L['enter_name']);
		if(empty($_POST['typeid']))show($L['category_select']);
		if(empty($_POST['content']))show($L['enter_contents']);
		
		$title       = htmlspecialchars(trim($_POST['title']));
		$typeid      = intval($_POST['typeid']);
		$content     = trim($_POST['content']);
		$keywords    = trim($_POST['keywords']);
		$description = trim($_POST['description']);
		$listorder   = intval($_POST['listorder']);
		$is_index    = intval($_POST['is_index']);
		if(empty($description)) {
		$description = addslashes(get_intro($_POST['content'],150));
		}
		$addtime     = time();

		if(empty($listorder)) {
			$sql = "SELECT MAX(listorder) FROM {$table}help";
			$maxorder  = $db->getOne($sql);
			$listorder = $maxorder + 1;
		}
		$sql = "INSERT INTO {$table}help (title,typeid,keywords,description,content,listorder,addtime,is_index) VALUES ('$title','$typeid','$keywords','$description','$content','$listorder','$addtime','$is_index')";
		$res = $db->query($sql);

		admin_log("".$L['faq_added_log']." $title");
		$link = 'help.php';
		show($L['done'], $link);
	break;
	
	case 'edit':
		$id = intval($_REQUEST['id']);
		$sql = "SELECT * FROM {$table}help WHERE id = '$id'";
		$help = $db->getRow($sql);
		$type_select = type_select('help',$help['typeid']);
		$content = $help['content'];
		include tpl('edit_help');
	break;

	case 'update':
		if(empty($_POST['title']))show($L['enter_name']);
		if(empty($_POST['typeid']))show($L['category_select']);
		if(empty($_POST['content']))show($L['enter_contents']);
		
		$id          = intval($_POST['id']);
		$title       = htmlspecialchars(trim($_POST['title']));
		$typeid      = intval($_POST['typeid']);
		$content     = trim($_POST['content']);
		$keywords    = trim($_POST['keywords']);
		$description = trim($_POST['description']);
		$listorder   = intval($_POST['listorder']);
		$is_index    = intval($_POST['is_index']);
		if(empty($description)) {
		$description = addslashes(get_intro($_POST['content'],150));
		}

		if(empty($listorder)) {
			$sql = "SELECT MAX(listorder) FROM {$table}help";
			$maxorder  = $db->getOne($sql);
			$listorder = $maxorder + 1;
		}

		$sql = "UPDATE {$table}help SET title='$title',typeid='$typeid',keywords='$keywords',description='$description',content='$content',listorder='$listorder',is_index='$is_index' WHERE id='$id' ";
		$res = $db->query($sql);

		admin_log("".$L['faq_changed_log']." $title");
		$link = 'help.php?act=list';
		show($L['done'], $link);
	break;
	
	case 'delete':
		$id = intval($_REQUEST['id']);
		if(empty($id))show($L['a_invalid_request']);
	    $res = $db->query("DELETE FROM {$table}help WHERE id='$id'");
		admin_log("faq_delete_log $id");
		show($L['done'], 'help.php?act=list');
	break;

	case 'batch':
		$id = !empty($_POST['id']) ? join(',', $_POST['id']) : 0;
		if(empty($id))show($L['choice_records']);
		$sql = "DELETE FROM {$table}help WHERE id IN ($id)";
        $re = $db->query($sql);
		admin_log("faq_delete_log $id");
		$link = 'help.php?act=list';
		show($L['done'], $link);
	break;
	default:
	show($L['a_invalid_request'], './');
	break;
}
?>