<?php
/***********************************************************************
************************************************************************/
if (!defined('IN_AWEBCOM')) {
    die('Access Denied');
}

define('IN_ADMIN', true);
error_reporting(E_WARNING);
define('AWEBCOM_ROOT', str_replace('admin/include/common.php', '', str_replace('\\', '/', __FILE__)));
if(phpversion() < '5.3.0') {
	set_magic_quotes_runtime(0);
}
session_start();
include AWEBCOM_ROOT.'/lang/ru-ru/admin.php';
require AWEBCOM_ROOT . 'data/config.php';
require AWEBCOM_ROOT . 'admin/include/global.fun.php';
require AWEBCOM_ROOT . 'include/global.fun.php';
header('Content-type: text/html; charset='.$charset);
unset($_REQUEST['table']);
if(!get_magic_quotes_gpc()) {
	$_POST   = addslashes_deep($_POST);
	$_GET    = addslashes_deep($_GET);
	$_COOKIE = addslashes_deep($_COOKIE);
}

if (!empty($_REQUEST)){
	$_REQUEST  = sql_replace($_REQUEST);key_replace($_REQUEST);
}
if (!empty($_POST)){
	$_POST  = sql_replace($_POST);key_replace($_POST);
}
if (!empty($_GET)){
	$_POST  = sql_replace($_POST);key_replace($_POST);
}

require AWEBCOM_ROOT . 'include/mysql.class.php';
$db = new mysql($db_host, $db_user, $db_pass, $db_name);
$db_host = $db_user = $db_pass = $db_name = NULL;

if(empty($_SESSION['adminid']) &&  !strstr($_SERVER['SCRIPT_FILENAME'],'login.php')){
//if(empty($_SESSION['adminid']) && $_REQUEST['act'] != 'login' && $_REQUEST['act'] != 'act_login'){
    header("Location: ./login.php?act=login");
	exit;
}
$CFG = get_config();
define('AWEBCOM_PATH', $CFG['weburl'].'/');
?>