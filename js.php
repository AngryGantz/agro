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
require dirname(__FILE__) . '/include/common.php';
switch($_REQUEST['act'])
{

	case 'call':
	    /* $num кол-во - выводимых $catid - ID категории $len - кол-во символов в названии
		 * Скрипт <script language=javascript src="http://www.domain.com/js.php?act=call&num=*&len=*&catid=*&charset=utf-8"></script>
		 */
		$char_set = empty($_GET['charset']) ? $charset : $_GET['charset'];
		if(strtolower($char_set) == 'CP1251')$char_set = 'windows-1251';
		if($char_set == 'UTF8')$char_set = 'utf-8';
		header('content-type: application/x-javascript; charset='.$char_set);

		$num   = $_REQUEST['num'] ? intval($_REQUEST['num']) : '10';
		$len   = $_REQUEST['len'] ? intval($_REQUEST['len']) : '10';
		$catid = $_REQUEST['catid'] ? intval($_REQUEST['catid']) : '';

		$where = !empty($catid) ? " and i.catid in (". get_cat_children($catid) .") " : '';

		$sql = "SELECT i.*,c.catid,c.catname FROM {$table}info AS i LEFT JOIN {$table}category AS c ON c.catid = i.catid WHERE 1 $where ORDER BY postdate LIMIT $num";
		$res = $db->query($sql);

		$call_info = array();
		while($row = $db->fetchRow($res))
		{
			if($char_set != $charset)
			{
				$row['catname'] = iconv($charset, $char_set, $row['catname']);
				$row['title']   = cut_str(iconv($charset, $char_set, $row['title']), $len);
			}else{
				$row['catname'] = $row['catname'];
				$row['title']   = cut_str($row['title'], $len);
			}
			$row['infourl'] = $CFG['weburl'].'/'.url_rewrite('view', array('vid'=>$row['id']));
			$row['caturl'] = $CFG['weburl'].'/'.url_rewrite('category', array('cid'=>$row['catid']));
			$call_info[] = $row;
		} 
		ob_start();
		include template('call_info');
		$output = ob_get_contents();
		ob_clean();
		$output = str_replace("\r", '', $output);
		$output = str_replace("\n", '', $output);
		echo "document.write('$output');";
	break;
	default:
	showmsg($L['invalid_request'], 'index.php');
	break;
}
?>

