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
$infoid = empty($_REQUEST['infoid']) ? 0 : intval($_REQUEST['infoid']);
$page = empty($_REQUEST['page'])? 1: intval($_REQUEST['page']);
$count = $db->getOne("SELECT COUNT(*) FROM {$table}comment WHERE is_check=1 AND type = 'com' and infoid = '$infoid'" );
$pager['search'] = array('infoid' => $infoid);
$pager = get_pager('comment_com.php', $pager['search'], $count, $page, $INF['maxcomment']);
$sql = "SELECT * FROM {$table}comment WHERE infoid = '$infoid' AND is_check = 1 AND type = 'com' ORDER by id DESC LIMIT $pager[start],$pager[size]";
$res = $db->query($sql);
$comment = array();
while($row = $db->fetchRow($res)) {
	$row['username'] = $row['username'] ? $row['username'] : ''.$L['guest'].'' ;
	$row['postdate'] = date('Y-m-d H:i:s', $row['postdate']);
	$comment[] = $row;
}
include template('comment');
?>