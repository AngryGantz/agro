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
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'login' ;

if($_REQUEST['act'] == 'login')
{
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
	include tpl('login');
}

if($_REQUEST['act'] == 'act_login')
{
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

    $sql = "SELECT userid,username,password FROM {$table}admin WHERE username='".$username."' AND password='".md5($password)."'";
	$row = $db->getRow($sql);

	if($row)
	{
		$_SESSION['adminid']  = $row['userid'];
		$_SESSION['adminname'] = $row['username'];
        
		$sql = "UPDATE {$table}admin SET lastip='$_SERVER[REMOTE_ADDR]',lastlogin='". time() ."' WHERE userid='$_SESSION[adminid]'";
		$db->query($sql);

            admin_log("".$L['entered_control_panel']." $row[username]");
		show($L['go_control_panel'], 'index.php');
	}
	else
	{
        admin_log("".$L['error_control_panel_login']." $row[username]");
        show($L['error_control_panel_login'], 'index.php');
    }
}
?>

