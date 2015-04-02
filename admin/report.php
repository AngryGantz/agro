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
chkadmin('report');
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
$nav = 'board';
$navig = 'report';
switch ($_REQUEST['act'])
{
	case 'list':
		$report = array('1'=>$L['report_abuse_type_1'],'2'=>$L['report_abuse_type_2'],'3'=>$L['report_abuse_type_3'],'4'=>$L['report_abuse_type_4']);

		$page = empty($_REQUEST[page])? 1 : intval($_REQUEST['page']);
		$count = $db->getOne("SELECT COUNT(*) FROM {$table}report");
		$pager = get_pager('report.php',array('act'=>'list'),$count,$page,'10');
		
		$sql = "SELECT * FROM {$table}report ORDER BY id DESC LIMIT $pager[start],$pager[size]";
		$res = $db->query($sql);
		$reports = array();
		while($row=$db->fetchRow($res)) {
			$row['postdate'] = date('Y-m-d-H-i', $row['postdate']);
			$row['type']     = $report[$row['type']];
			$reports[]       = $row;
		}
	    include tpl('list_report');
	break;

	case 'delete':
		$id = intval($_REQUEST['id']);
		if(empty($id))show($L['a_invalid_request']);
	    $res = $db->query("DELETE FROM {$table}report WHERE id='$id'");
		admin_log("".$L['abuse_delete_log']." $id");
		show($L['done'], 'report.php?act=list');
	break;

	case 'batch':
		$id = !empty($_POST['id']) ? join(',', $_POST['id']) : 0;
		if(empty($id))show($L['choice_records']);
        $re = $db->query("DELETE FROM {$table}report WHERE id IN ($id)");
		admin_log("".$L['abuse_delete_log']." $id");
		show($L['done'], 'report.php?act=list');
	break;
	default:
	show($L['a_invalid_request'], './');
	break;

}
?>