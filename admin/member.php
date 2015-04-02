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
chkadmin('member');
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
$nav = 'member';
switch ($_REQUEST['act'])
{
	case 'list':
		$page = empty($_REQUEST['page'])? 1 : intval($_REQUEST['page']);
		$sql = "SELECT COUNT(*) FROM {$table}member";
		$count = $db->getOne($sql);
		$pager = get_pager('member.php',array('act'=>'list'),$count,$page,'10');
		
		$sql = "SELECT * FROM {$table}member ORDER BY lastlogintime DESC LIMIT $pager[start],$pager[size]"; 
		$res = $db->query($sql);
		$userinfo = array();
		while($row=$db->fetchRow($res)) {
			$row['username'] = cut_str($row['username'],20);
			$row['registertime']  = date('Y-m-d H:i:s',$row['registertime']);
			$row['lastlogintime'] = date('Y-m-d H:i:s',$row['lastlogintime']);
			$userinfo[] = $row;
		}
	    include tpl('list_member');
	break;

	case 'edit':
	    $userid = intval($_REQUEST['id']);
		$sql = "SELECT * FROM {$table}member WHERE userid = '$userid'";
		$userinfo = $db->getRow($sql);
		include tpl('edit_member');
	break;

	case 'update':
		$userid = $_REQUEST['id'] ? intval($_REQUEST['id']) : '';
		$username = $_REQUEST['username'] ? trim($_REQUEST['username']) : '';
		$password = $_REQUEST['password'] ? trim($_REQUEST['password']) : '';
		$repassword = $_REQUEST['repassword'] ? trim($_REQUEST['repassword']) : '';
		$email = $_REQUEST['email'] ? trim($_REQUEST['email']) : '';
		$status = $_REQUEST['status'] ? trim($_REQUEST['status']) : '0';

		if($password != $repassword)show($L['enter_email']);
		if($password && (strlen($password) < 5 || strlen($password) > 30))show($L['limit_passw_5_30']);
		if(empty($email))show($L['enter_email']);
	    if(!is_email($email))show($L['invalid_email']);
		//if(!preg_match("/^[0-9a-zA-Z_-]+@[0-9a-zA-Z_-]+\.[0-9a-zA-Z_-]+$/",$email))show($L['invalid_email']);
		
		$sql = "select count(*) from {$table}member where email='$email' and userid<>'$userid' ";
		if($db->getOne($sql)>0)show($L['email_already_use']);
		
		if($password)$set[] = " password = '".MD5($password)."' ";
		$set[] = " email = '$email' ";
		$set[] = " status = '$status' ";
		if(!empty($set)) $set = join(',', $set);

		$res = $db->query("UPDATE {$table}member SET $set WHERE userid = '$userid'");
		

		admin_log("".$L['member_changed_log']." $username");
		$link = "member.php?act=list";
		show($L['done'], $link);
	break;
	
	case 'delete':
		$userid = is_array($_REQUEST['id']) ? join(',',$_REQUEST['id']) : intval($_REQUEST['id']);
		if(empty($userid))show($L['a_parameter_error']);

		if($CFG['del_m_info'])
		{
			$sql = "SELECT id FROM {$table}info WHERE userid in ($userid) ";
			$infos = $db->getAll($sql);

			foreach($infos as $info)
			{
				$db->query("DELETE FROM {$table}comment WHERE infoid = '$info[id]'");
				$sql = "select * from {$table}info_image where infoid='$info[id]'";
				$res = $db->query($sql);
				while($row=$db->fetchrow($res)) {
					if($row['path'] != '' && is_file(AWEBCOM_ROOT.$row['path']))
					@unlink(AWEBCOM_ROOT.$row['path']);
				}
				$sql = "DELETE FROM {$table}info_image WHERE infoid = $info[id]";
				$db->query($sql);
				$sql = "DELETE from {$table}cus_value WHERE infoid = $info[id]";
				$sql = $db->query($sql);
				$sql = "DELETE FROM {$table}info WHERE id = '$info[id]'";
				$db->query($sql);
			}
		}
		if($CFG['del_m_comment']) $db->query("delete from {$table}comment where userid in ($userid) ");
	    $db->query("DELETE FROM {$table}member WHERE userid in ($userid) ");

		admin_log("".$L['member_delete_log']." $userid");
		$link = 'member.php?act=list';
		show($L['done'], $link);
	break;

	case 'batch':
		$userid = is_array($_REQUEST['id']) ? join(',',$_REQUEST['id']) : intval($_REQUEST['id']);
		if(empty($userid))show($L['choice_records']);
		
		if($CFG['del_m_info'])
		{
			$sql = "SELECT id FROM {$table}info WHERE userid in ($userid) ";
			$infos = $db->getAll($sql);

			foreach($infos as $info)
			{
				$db->query("DELETE FROM {$table}comment WHERE infoid = '$info[id]'");
				$sql = "select * from {$table}info_image where infoid='$info[id]'";
				$res = $db->query($sql);
				while($row=$db->fetchrow($res)) {
					if($row['path'] != '' && is_file(AWEBCOM_ROOT.$row['path']))
					@unlink(AWEBCOM_ROOT.$row['path']);
				}
				$sql = "DELETE FROM {$table}info_image WHERE infoid = $info[id]";
				$db->query($sql);
				$sql = "DELETE from {$table}cus_value WHERE infoid = $info[id]";
				$sql = $db->query($sql);
				$sql = "DELETE FROM {$table}info WHERE id = '$info[id]'";
				$db->query($sql);
			}
		}

		if($CFG['del_m_comment']) $db->query("delete from {$table}comment where userid in ($userid) ");
	    $db->query("DELETE FROM {$table}member WHERE userid in ($userid) ");

		admin_log("".$L['member_delete_log']." $userid");
		$link = 'member.php?act=list';
		show($L['done'], $link);
	break;
	default:
	show($L['a_invalid_request'], './');
	break;
}
?>