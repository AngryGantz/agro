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
include_once dirname(__FILE__) . '/include/pay.fun.php';

$STATUS = array(0=>'<span class="label">'.$L['waiting'].'</span>', 3=>'<span class="label label-success">'.$L['paid'].'</span>', 1=>'<span class="label label-important">'.$L['payment_error'].'</span>');
$today = date('Y-m-d');
$nav = 'payonline';
extract($_REQUEST);

if($_REQUEST['act'] == 'setting')
{
	$settings = array();
	$result = $db->query("SELECT * FROM {$table}payment ORDER BY payorder");
	while($r = $db->fetchrow($result))
	{
		$settings[] = $r;
	}
	$navig = 'payonline_setting';
	include tpl('payonline_setting');
}
elseif($_REQUEST['act'] == 'act_setting')
{
	$name = $_POST['name'];
	foreach($name as $id=>$v) {
		$db->query("UPDATE {$table}payment SET enable='$enable[$id]',name='$name[$id]',bankurl='$bankurl[$id]',currency='$currency[$id]',partnerid='$partnerid[$id]',keycode='$keycode[$id]',percent='$percent[$id]',email='$email[$id]',payorder='$payorder[$id]' where id='$id'");
	}
	clear_caches('phpcache', 'pay_setting');
	show($L['paysystem_settings_changed'], 'payonline.php?act=setting');
}
elseif($_REQUEST['act'] == 'check')
{
	$payid = intval($payid);
	$r = $db->getRow("SELECT * FROM {$table}pay_online WHERE payid=$payid");
	if(!$r) show($L['id_not_found']);
	if($r['status'] == 3) show($L['transaction_marked_paid']);
	$amount = $r['amount'];
	$username = $r['username'];
	$db->query("UPDATE {$table}pay_online SET status=3, receivetime='".time()."' WHERE payid=$payid");
	money_add($username, $amount, $L['activated_operator']);

	$r = $db->getOne("SELECT money FROM {$table}member WHERE username='$username'");
	$money = $r['money'];
	$year = date('Y', time());
	$month = date('m', time());
	$date = date('Y-m-d', time());
	$time = time();
	$ip = get_ip();
	$recharge = $L['recharge'];
	$online_payment = $L['online_payment'];
	$db->query("INSERT INTO {$table}pay (typeid,note,paytype,amount,balance,username,year,month,date,inputtime,inputer,ip) VALUES('1','$recharge','$online_payment','$amount','$money','$username','$year','$month','$date','$time','$_username','$ip')");
	show($L['done'], $forward);
}
elseif($_REQUEST['act'] == 'delete')
{
	$payid = is_array($id) ? implode(',', $id) : intval($id);
	if(!$id)show($L['choice_records']);
	$db->query("DELETE FROM {$table}pay_online WHERE payid IN ($payid)");
	show($L['done'], $_SERVER['HTTP_REFERER']);
}


elseif($_REQUEST['act'] == 'view')
{
	$payid = intval($payid);
	$r = $db->getRow("SELECT * FROM {$table}pay_online WHERE payid=$payid");
	if(!$r) show($L['record_does_not_exist']);
    extract($r);
	$sendtime = date('Y-m-d h:i:s', $sendtime);
	$receivetime = $receivetime ? date('Y-m-d h:i:s', $receivetime) : '';
	$navig = 'payonline_list';
	include tpl('payonline_view');
}
else
{
	$page = isset($page) ? intval($page) : 1;
	$pagesize = 10;
	$sql = isset($status) ? ($status ? " WHERE status=$status " : " WHERE status=0 ") : '';
	if(isset($date)) {
		$todaytime = strtotime($date.' 00:00:00');
		$tomorrowtime = strtotime($date.' 23:59:59');
	    $sql .= $sql ? " and sendtime>=$todaytime and sendtime<=$tomorrowtime" : " where sendtime>=$todaytime and sendtime<=$tomorrowtime";
	}

	$r = $db->getOne("SELECT count(*) FROM {$table}pay_online $sql");
	$pager['search'] = array();
	$pager = get_pager('payonline.php',$pager['search'], $r, $page, $pagesize);

	$pays = array();
	$result = $db->query("SELECT * FROM {$table}pay_online $sql ORDER BY payid DESC LIMIT $pager[start],$pager[size]");
	while($r = $db->fetchrow($result)) {
		$pays[] = $r;
	}
	$navig = 'payonline_list';
	include tpl('payonline');
}
?>