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
chkadmin('admin_log');
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
$nav = 'admins';
switch ($_REQUEST['act'])
{
	case 'list':
		$page = empty($_REQUEST[page])? 1 : intval($_REQUEST['page']);
		$sql = "SELECT COUNT(*) FROM {$table}admin_log";
		$count = $db->getOne($sql);
		$pager = get_pager('admin_log.php',array('act'=>'list'),$count,$page,'10');
		
		$sql = "SELECT * FROM {$table}admin_log ORDER BY logid DESC LIMIT $pager[start],$pager[size]";
		$res = $db->query($sql);
		$log = array();
		while($row=$db->fetchRow($res)) {
			$row['logdate']   = date('Y-m-d-H-i', $row['logdate']);
			$log[]            = $row;
		}
	    include tpl('list_admin_log');
	break;
	
	case 'truncate':
		$db->query("TRUNCATE TABLE {$table}admin_log");
		show($L['done'], 'admin_log.php?act=list');
	break;

	case 'batch':
		$id = is_array($_REQUEST['id']) ? join(',', $_REQUEST['id']) : intval($_REQUEST['id']);
		if(empty($id))show($L['choice_records']);
		$sql = "DELETE FROM {$table}admin_log WHERE logid IN ($id)";
        $re = $db->query($sql);
		show($L['selected_logs_removed'], 'admin_log.php?act=list');
	break;
	default:
	show($L['a_invalid_request'], './');
	break;
}
?>