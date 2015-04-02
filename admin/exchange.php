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
$nav = 'payonline';
$navig = 'exchange';
extract($_REQUEST);
$page = empty($page)? 1 : intval($page);
$sql = '';
if($username) $sql .= " AND username='$username' ";
if($type) $sql .= " AND type='$type' ";

if($_POST['begindate']) {
	$begintime = strtotime($_POST['begindate'].' 00:00:00');
	$sql .= " AND addtime>=$begintime ";
}
if($_POST['enddate']) {
	$endtime = strtotime($_POST['enddate'].' 23:59:59');
	$sql .= " AND addtime<=$endtime";
}
if($sql) $sql = " WHERE 1 $sql";
$count = $db->getOne("SELECT count(*) as number FROM {$table}pay_exchange $sql");
$pager = get_pager('exchange.php', array(), $count, $page,'10');
$units = array('money'=>$CFG['currency'], 'credit'=>$L['min_points']);
$types = array('money'=>$CFG['currency'], 'credit'=>$L['max_points']);
$exchanges = array();
$result = $db->query("SELECT * FROM {$table}pay_exchange $sql ORDER BY exchangeid DESC LIMIT $pager[start],$pager[size]");
while($r = $db->fetchrow($result)) {
	$r['unit'] = $units[$r['type'].$r['unit']];
	$r['type'] = $types[$r['type']];
	$r['addtime'] = date('Y-m-d h:i:s', $r['addtime']);
	$exchanges[] = $r;
}
include tpl('list_exchange');
?>