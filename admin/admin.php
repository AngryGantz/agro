<?php
/***********************************************************************

************************************************************************/
define('IN_AWEBCOM', true);
require_once dirname(__FILE__) . '/include/common.php';
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
if($_REQUEST['act'] != 'modify' && $_REQUEST['act'] != 'repass')chkadmin('admin');
$nav = 'admins';
switch ($_REQUEST['act'])
{
	case 'list':
		$sql = "SELECT * FROM {$table}admin ORDER BY userid";
		$res = $db->query($sql);
		$admin = array();
		while($row = $db->fetchRow($res)){
			$admin[] = $row;
		}
		include tpl('list_admin');
	break;

	case 'add':
		include tpl('add_admin');
	break;

	case 'insert':
		$username = trim($_POST['username']);
		$email    = trim($_POST['email']);
		$truename    = trim($_POST['truename']);
		$purview  = is_array($_POST['purview']) ? implode(",", $_POST['purview']) : '';

		if(empty($username))show($L['enter_login']);
		if(!empty($username)) {
			$sql = "select count(*) from {$table}admin where username = '$username'";
			if($db->getOne($sql))show($L['username_already_taken']);
		}
		if(empty($_POST['password']))show($L['enter_password']);
		if(empty($_POST['repass']))show($L['enter_password_again']);
		if($_POST['password'] <> $_POST['repass'])show($L['passwords_do_not_match']);
		
		if(empty($email))show($L['enter_email']);
		if(!empty($email)) {
			if(!is_email($email))show($L['invalid_email']);
			$sql = "select count(*) from {$table}admin where email = '$email'";
			if($db->getOne($sql))show($L['email_already_use']);
		}
		
		$password = MD5($_POST['password']);
		$sql = "INSERT INTO {$table}admin (username,password,truename,email,purview) VALUES ('$username','$password','$truename','$email','$purview')";
		$res = $db->query($sql);

		$msg = $res ? $L['admin_successfully_added'] : $L['admin_error_added'];
		admin_log("".$L['admin_added_log']." $_POST[username]");
		$link = 'admin.php';
		show($L['admin_successfully_added'], $link);
	break;

	case 'edit':
		$userid = intval($_REQUEST['id']);
		$sql = "select * from {$table}admin where userid = '$userid'";
		$admin = $db->getRow($sql);
		$purview = explode(',',$admin['purview']);
		include tpl('edit_admin');
	break;

	case 'update':
		$userid  = trim($_GET['id']);
		$email   = trim($_POST['email']);
		$truename   = trim($_POST['truename']);
		$username   = trim($_POST['username']);
		$purview  = is_array($_POST['purview']) ? implode(",", $_POST['purview']) : '';

		if(!empty($_POST['password']) && !empty($_POST['repass'])){	
			if($_POST['password'] <> $_POST['repass'])show($L['passwords_do_not_match']);
			$password = MD5($_POST['password']);
			$pass = "password = '$password',";
		}
		
		if(empty($email))show($L['enter_email']);
		if(!empty($_POST['email'])){
			if(!is_email($email))show($L['invalid_email']);
			$sql = "select count(*) from {$table}admin where email = '$email' and userid <> '$_GET[id]' ";
			if($db->getOne($sql))show($L['email_already_use']);
		}
		
		$sql = "update {$table}admin set ".$pass." email = '$email', truename = '$truename', purview = '$purview' where userid = '$userid' ";
		$res = $db->query($sql);

		$msg = $res ? $L['admin_successfully_update'] : $L['admin_error_update'];
		admin_log("".$L['admin_update_log']." $username");

		$link = 'admin.php?act=list';
		show($L['admin_successfully_update'], $link);
	break;

	case 'modify':
		include tpl('modify');
	break;

	case 'repass':
		if(empty($_REQUEST[password]))show($L['enter_password']);
		if(empty($_REQUEST[repassword]))show($L['enter_password_again']);
		if($_REQUEST[password] <> $_REQUEST[repassword])show($L['passwords_do_not_match']);
		
		$password = md5($_REQUEST[password]);
		$sql = "UPDATE {$table}admin SET password = '$password' WHERE userid = '$_SESSION[adminid]'";
		$res = $db->query($sql);
		admin_log("".$L['admin_update_repass_log']." $_SESSION[adminid]");
		show($L['admin_update_repass'], 'admin.php');
	break;

	case 'delete':
		$userid = intval($_GET[id]);
		//check is_admin
		$sql = "select is_admin from {$table}admin where userid = '$userid' ";
		$is_admin = $db->getOne($sql);
		if($is_admin>0)show($L['not_remove_primary_admin']);
		//get username
		$username = $db->getOne("select username from {$table}admin where userid = '$userid' ");
		//delete user
		$sql = "delete from {$table}admin where userid = '$userid' ";
		$res = $db->query($sql);
		$msg = $res ? ''.$L['admin_one'].' $username '.$L['successfully_removed'].'' : ''.$L['error_removed_admin'].' $username';
		admin_log("".$L['admin_removed_log']." $username");
		$link = "admin.php?act=list";
		show($L['done'], $link);
	break;
	default:
	show($L['a_invalid_request'], './');
	break;
}
?>