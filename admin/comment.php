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
chkadmin('comment');
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
$nav = 'options';
$navig = 'comment';
switch ($_REQUEST['act'])
{
	case 'list':
		$page = empty($_REQUEST[page])? 1 : intval($_REQUEST['page']);
		$sql = "SELECT COUNT(*) FROM {$table}comment";
		$count = $db->getOne($sql);
		$pager = get_pager('comment.php',array('act'=>'list'),$count,$page,'10');
		$sql = "SELECT * FROM {$table}comment ORDER BY id DESC LIMIT $pager[start],$pager[size]";
		$res = $db->query($sql);
		$comment = array();
		while($row=$db->fetchRow($res)) {
			$row['username'] = $row['username'] ? $row['username'] : $L['guest'];
			$row['postdate'] = date('Y-m-d-H-i', $row['postdate']);
			$row['is_check'] = $row['is_check']==1;
			$row['content']  = cut_str($row['content'], 50);
			$comment[]       = $row;
		}
	    include tpl('list_comment');
	break;
	
	case 'view':
		$id = intval($_REQUEST['id']);
		$comment = $db->getRow("SELECT * FROM {$table}comment WHERE id = '$id'");
		@extract($comment);
		$postdate  = date('Y-m-d-H-i', $postdate);
		$username  = $username ? $username : $L['guest'];

		$refer  = $_SERVER['HTTP_REFERER'];
		include tpl('view_comment');
	break;

	case 'batch':
		$id = is_array($_REQUEST['id']) ? join(',', $_REQUEST['id']) : intval($_REQUEST['id']);
		if(empty($id))show($L['choice_records']);
		switch ($_REQUEST['type'])
		{
			case 'delete':
				$sql = "DELETE FROM {$table}comment WHERE id IN ($id)";
				$re = $db->query($sql);
				admin_log("".$L['comment_delete_log']." $id");
				show($L['done'], 'comment.php?act=list');
			break;

			case 'is_check':
				$sql = "UPDATE {$table}comment SET is_check=1 WHERE id IN ($id)";
				$re = $db->query($sql);
				admin_log("".$L['comment_check_log']." $id");
				show($L['done'], $_SERVER['HTTP_REFERER']);
			break;

			case 'no_check':
				$sql = "UPDATE {$table}comment SET is_check=0 WHERE id IN ($id)";
				$re = $db->query($sql);
				admin_log("".$L['comment_no_check_log']." $id");
				show($L['done'], $_SERVER['HTTP_REFERER']);
			break;
			default:
			show($L['a_invalid_request'], './');
			break;
		}
	break;
}
?>