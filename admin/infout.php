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
chkadmin('infout');
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
$nav = 'config';
switch($_REQUEST['act'])
{
	case 'list':

		$sql = "SELECT setname,value FROM {$table}infout";
		$res = $db->query($sql);
		while($row=$db->fetchRow($res)){$sub[$row['setname']] = $row['value'];}
		$navig = 'infout';
		include tpl('infout');
	break;

	case 'infout':
		$sub = array();
		$sub['posttext'] = trim($_POST['posttext']);
		$sub['postcomtext'] = trim($_POST['postcomtext']);
		$sub['homeflash_check'] = trim($_POST['homeflash_check']);
		$sub['innew']      = intval($_POST['innew']);
		$sub['insimnew']   = intval($_POST['insimnew']);
		$sub['invip']      = intval($_POST['invip']);
		$sub['insimvip']   = intval($_POST['insimvip']);
		$sub['intop']      = intval($_POST['intop']);
		$sub['insimtop']   = intval($_POST['insimtop']);
		$sub['inhot']      = intval($_POST['inhot']);
		$sub['insimhot']   = intval($_POST['insimhot']);
		$sub['innewizo']      = intval($_POST['innewizo']);
		$sub['insimnewizo']   = intval($_POST['insimnewizo']);
		$sub['companyhome']   = intval($_POST['companyhome']);
		$sub['helpshome']   = intval($_POST['helpshome']);
		$sub['newsshome']   = intval($_POST['newsshome']);
		$sub['commentshome']   = intval($_POST['commentshome']);
		$sub['catw']       = intval($_POST['catw']);
		$sub['catvip']     = intval($_POST['catvip']);
		$sub['catsimvip']  = intval($_POST['catsimvip']);
		$sub['cathot']     = intval($_POST['cathot']);
		$sub['catsimhot']  = intval($_POST['catsimhot']);
		$sub['maxday']     = intval($_POST['maxday']);
		$sub['maxupload']  = intval($_POST['maxupload']);
		$sub['searchw']  = intval($_POST['searchw']);
		$sub['searchhot']  = intval($_POST['searchhot']);
		$sub['searchsimhot']  = intval($_POST['searchsimhot']);
		$sub['recinfo']  = intval($_POST['recinfo']);
		$sub['imrecinfo']  = intval($_POST['imrecinfo']);
		$sub['maxcomment']  = intval($_POST['maxcomment']);

		foreach($_POST as $key=>$val)
		{
			$sql = "UPDATE {$table}infout SET value = '$sub[$key]' WHERE setname = '$key' ";
			$res = $db->query($sql);
			$res ? $msg.='' : $msg.='1';
		}
		empty($msg) ? $msg = $L['infout_settings_changed']: $msg = $L['infout_settings_failed'];

		admin_log("$msg");
		$link = "infout.php";
		show($msg, $link);
	break;
	default:
	show($L['a_invalid_request'], './');
	break;
}


?>