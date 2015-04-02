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
if (!defined('IN_AWEBCOM'))
{
    die('Access Denied');
}

error_reporting(E_WARNING | E_PARSE);
define('AWEBCOM_ROOT', str_replace('wap/include/common.inc.php', '', str_replace('\\', '/', __FILE__)));
require AWEBCOM_ROOT . 'data/config.php';
require AWEBCOM_ROOT . 'include/global.fun.php';
$L = array();
include AWEBCOM_ROOT.'/lang/ru-ru/lang.php';
require AWEBCOM_ROOT . 'wap/include/wap.fun.php';
if(phpversion() < '5.3.0') {
	set_magic_quotes_runtime(0);
}
@ini_set('session.auto_start', 0);
session_start();
if(!get_magic_quotes_gpc())
{
	if (!empty($_GET))$_GET  = addslashes_deep($_GET);
    if (!empty($_POST))$_POST = addslashes_deep($_POST);
    $_COOKIE   = addslashes_deep($_COOKIE);
    $_REQUEST  = addslashes_deep($_REQUEST);
}
if(function_exists('date_default_timezone_set')){
    date_default_timezone_set('Europe/Moscow');
}
header('Content-type: text/html; charset=utf-8');
require AWEBCOM_ROOT . 'include/mysql.class.php';
$db = new mysql($db_host, $db_user, $db_pass, $db_name, '1');
$db_host = $db_user = $db_pass = $db_name = NULL;

$CFG = get_config();
if($CFG['closesystem'])die($CFG['close_tips']);
if(!$CFG['wap'])die($L['wap_version_disabled']);

$_userid = 0;
$_username = '';
if($_SESSION['userid'])
{
	$user_info = $db->getrow("select * from {$table}member where userid='$_SESSION[userid]' ");
	if($user_info) {
		$_userid = $user_info['userid'];
		$_username = $user_info['username'];
	}
}
define('AWEBCOM_PATH', $CFG['weburl'].'/');
echo "<?xml version='1.0' encoding='utf-8'?>";

?>