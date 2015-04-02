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
if(!defined('IN_AWEBCOM'))
{
	die('Access Denied');
}

function credit_add($username, $number, $note = '')
{
	global $db, $table, $L;
	$number = intval($number);
	$username = htmlspecialchars($username);
	if($number < 0)	showmsg($L['amount_must_greater_0']);
	$db->query("UPDATE {$table}member SET credit=credit+$number WHERE username='$username'");
	$note = addslashes($note);
	$time = time();
	$ip = get_ip();
	if($db->affected_rows() == 0) showmsg($L['parameter_error']);
	$db->query("INSERT INTO {$table}pay_exchange  (`username`,`type`,`value`,`note`,`addtime`,`ip`) VALUES('$username','credit','$number','$note','$time','$ip')");
}

function credit_diff($username, $number, $note = '')
{
	global $db, $table, $L;
	$number = intval($number);
	$username = htmlspecialchars($username);
	if($number < 0) showmsg($L['amount_must_greater_0']);
	$note = addslashes($note);
	$r = member_info($username,'2');
	if(!$r) showmsg($L['member_does_not_exist']);
	extract($r);
	$time = time();
	$ip = get_ip();
	if($chargetype == 0) {
		if($number > $credit) showmsg($L['points_account_short']);
        $db->query("UPDATE {$table}member SET credit=credit-$number WHERE username='$username'");
	    $db->query("INSERT INTO {$table}pay_exchange  (`username`,`type`,`value`,`note`,`addtime`,`ip`) VALUES('$username','credit','-".$number."','$note','$time','$ip')");
	}
	return TRUE;
}

function money_add($username, $number, $note = '')
{
	global $db,$table, $L;
	$username = htmlspecialchars($username);
	$number = round(floatval($number) ,2);
	if($number < 0) showmsg($L['amount_must_greater_0']);
	$note = addslashes($note);
	$r = member_info($username,'2');
	if(!$r) showmsg($L['member_does_not_exist']);
	extract($r);
	$money = $money + $number;
	$db->query("UPDATE {$table}member SET money=$money WHERE username='$username'");
	if($db->affected_rows() == 0) show($L['parameter_error']);
	$time = time();
	$year = date('Y', $time);
	$month = date('m', $time);
	$date = date('Y-m-d', $time);
	$ip = get_ip();
	$coming = $L['coming'];
	$db->query("INSERT INTO {$table}pay (typeid,note,paytype,amount,balance,username,year,month,date,inputtime,inputer,ip) VALUES('1','$note','$coming','$number','$money','$username','$year','$month','$date','$time','system','$ip')");

	$db->query("INSERT INTO {$table}pay_exchange (`username`,`type`,`value`,`note`,`addtime`,`ip`) VALUES('$username','money','$number','$note','$time','$ip')");
}

function money_diff($username, $number, $note = '')
{
	global $db, $table, $L;
	$username = htmlspecialchars($username);
	$number = round(floatval($number) ,2);
	if($number == 0) return true;
	if($number < 0) showmsg($L['amount_must_greater_0']);
	$note = addslashes($note);
	$r = member_info($username,'2');
	if(!$r) showmsg($L['member_does_not_exist']);
	extract($r);
	if($number > $money) showmsg($L['insufficient_funds_balance']);
	$money = $money - $number;
	$db->query("UPDATE {$table}member SET money=$money WHERE username='$username'");
	
	$time = time();
	$year = date('Y', $time);
	$month = date('m', $time);
	$date = date('Y-m-d', $time);
	$ip = get_ip();
	$expense = $L['expense'];
	$db->query("INSERT INTO {$table}pay (typeid,note,paytype,amount,balance,username,year,month,date,inputtime,inputer,ip) VALUES('2','$note','$expense','$number','$money','$username','$year','$month','$date','$time','system','$ip')");

	$db->query("INSERT INTO {$table}pay_exchange (`username`,`type`,`value`,`note`,`addtime`,`ip`) VALUES('$username','money','-".$number."','$note','$time','$ip')");

	return true;
}

?>