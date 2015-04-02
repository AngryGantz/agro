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
chkadmin('config');
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
$nav = 'config';
switch($_REQUEST['act'])
{
	case 'list':
		$CFG = '';
		$sql = "select setname,value from {$table}config";
		$res = $db->query($sql);
		while($row=$db->fetchRow($res)) {
			$CFG[$row['setname']] = $row['value'];
		}
		$tpl_dir = tpl_dir();
		$navig = 'config';
		include tpl('set_config');
	break;

	case 'set_config':
		$_POST['webname']	    = $_POST['webname'] ? trim($_POST['webname']) : '';
		$_POST['weburl']		= trim($_POST['weburl']);
		$_POST['sysmail']		= trim($_POST['sysmail']);
		$_POST['mailspam']		= trim($_POST['mailspam']);
		$_POST['icq']		    = trim($_POST['icq']);
		$_POST['tplname']		= trim($_POST['tplname']);
		$_POST['crypt']		    = trim($_POST['crypt']);
		$_POST['post_check']    = intval($_POST['post_check']);
		$_POST['rewrite']		= intval($_POST['rewrite']);
		$_POST['maxpost']		= intval($_POST['maxpost']);
		$_POST['banwords']	    = trim($_POST['banwords']);
		$_POST['annouce']		= trim($_POST['annouce']);
		$_POST['slogan']		= trim($_POST['slogan']);
		$_POST['description']   = trim($_POST['description']);
		$_POST['keywords']      = trim($_POST['keywords']);
		$_POST['memberanons']     = trim($_POST['memberanons']);
		$_POST['comment_check'] = trim($_POST['comment_check']);
		$_POST['youtube_check'] = trim($_POST['youtube_check']);
		$_POST['map_check']     = trim($_POST['map_check']);
		$_POST['del_m_info']    = intval($_POST['del_m_info']);
		$_POST['del_m_comment'] = intval($_POST['del_m_comment']);
		$_POST['pagesize']      = intval($_POST['pagesize']);
		$_POST['postfile']      = trim($_POST['postfile']);
		$_POST['expired_view']  = intval($_POST['expired_view']);
		$_POST['visitor_post']  = intval($_POST['visitor_post']);
		$_POST['visitor_view']  = intval($_POST['visitor_view']);
		$_POST['visitor_comment'] = intval($_POST['visitor_comment']);
		$_POST['closesystem']   = intval($_POST['closesystem']);
		$_POST['close_tips']    = trim($_POST['close_tips']);
		$_POST['info_top_gold'] = trim($_POST['info_top_gold']);
		$_POST['info_recomend'] = trim($_POST['info_recomend']);
		$_POST['com_pagesize'] = intval($_POST['com_pagesize']);
		
		$_POST['login_credit']     = intval($_POST['login_credit']);
		$_POST['register_credit']  = intval($_POST['register_credit']);
		$_POST['post_info_credit'] = intval($_POST['post_info_credit']);
		$_POST['post_comment_credit'] = intval($_POST['post_comment_credit']);
		$_POST['creditexchange']	  = intval($_POST['creditexchange']);

		$_POST['max_login_credit']   = intval($_POST['max_login_credit']);
		$_POST['max_comment_credit'] = intval($_POST['max_comment_credit']);
		$_POST['max_info_credit']	 = intval($_POST['max_info_credit']);
		
		$_POST['email']	= trim($_POST['email']);
		$_POST['phone']	= trim($_POST['phone']);
		$_POST['close_register']	= intval($_POST['close_register']);
		$_POST['reg_check']	= intval($_POST['reg_check']);
		$_POST['com_thumbwidth'] = floatval($_POST['com_thumbwidth']);
		$_POST['com_thumbheight']	= floatval($_POST['com_thumbheight']);
		
		if($_POST['weburl']=='' || $_POST['weburl']=="http://studioweb.pro") {
			$_POST['weburl'] = get_url();
		}
		unset($_POST['act']);
		unset($_POST['submit']);
		foreach($_POST as $key=>$val) {
			$data = $db->getone("SELECT * FROM {$table}config WHERE setname='$key'");
			if($data) {
				$sql = "UPDATE {$table}config SET value = '$val' WHERE setname = '$key' ";
			} else {
				$sql = "INSERT INTO {$table}config (setname,value) VALUES ('$key','$val') ";
			}
			$res = $db->query($sql);
			$res ? $msg.='' : $msg.='1';
		}
		empty($msg) ? $msg = $L['basic_settings_changed']: $msg = $L['basic_settings_failed'];
		admin_log("$msg");
		clear_caches('phpcache');
		$link = "set_config.php";
		show($msg, $link);
	break;
	default:
	show($L['a_invalid_request'], './');
	break;
}

//--------function--------
function tpl_dir()
{
	$datadir = opendir(AWEBCOM_ROOT . "templates");
	while($file = readdir($datadir)) {
		if($file!='.' && $file!='..' && $file!="index.htm"){
			$files[] = $file;
		}
	}
	closedir($datadir);
	return $files;
}
?>