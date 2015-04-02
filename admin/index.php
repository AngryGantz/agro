<?php
/***********************************************************************
************************************************************************/
define('IN_AWEBCOM', true);
require_once dirname(__FILE__) . '/include/common.php';
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'index' ;

switch ($_REQUEST['act'])
{
	case 'top':
		include tpl('top');
	break;

	case 'left':
		include tpl('left');
	break;

	case 'index':
		$sql = "SELECT * FROM {$table}admin WHERE userid='$_SESSION[adminid]'";
		$row = $db->getRow($sql); 
		$admin['lastip']    = $row['lastip'];
		$admin['lastlogin'] = date('Y-m-d-s', $row['lastlogin']);
		
		$info_num    = $db->getOne("SELECT COUNT(*) FROM {$table}info");
		$report_num  = $db->getOne("SELECT COUNT(*) FROM {$table}report");
		$member_num  = $db->getOne("SELECT COUNT(*) FROM {$table}member");
		$comment_num = $db->getOne("SELECT COUNT(*) FROM {$table}comment");
		$com_num     = $db->getOne("SELECT COUNT(*) FROM {$table}com");
		$article_num = $db->getOne("SELECT COUNT(*) FROM {$table}article");
		include_once AWEBCOM_ROOT . 'include/version.inc.php';
		if(file_exists('../install'))$install='1';

		include tpl('index');
	break;

	case 'clear_caches':
		$phpchche = clear_caches('phpcache');
		$compiled = clear_caches('compiled');
		$sqlcache = clear_caches('sqlcache');
		if($phpcache && $compiled && $sqlcache) echo '1';
		show($L['cache_successfully_updated']);
	break;

	case 'phpinfo':
		phpinfo();
	break;

	default:
	show($L['a_invalid_request'], './');
	break;
}
?>