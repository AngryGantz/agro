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
	if($number < 0)	show($L['amount_must_greater_0']);
	$db->query("UPDATE {$table}member SET credit=credit+$number WHERE username='$username'");
	$note = addslashes($note);
	$time = time();
	$ip = get_ip();
	if($db->affected_rows() == 0) show($L['a_parameter_error']);
	$db->query("INSERT INTO {$table}pay_exchange  (`username`,`type`,`value`,`note`,`addtime`,`ip`) VALUES('$username','credit','$number','$note','$time','$ip')");
}

function credit_diff($username, $number, $note = '')
{
	global $db, $table, $L;
	$number = intval($number);
	$username = htmlspecialchars($username);
	if($number < 0)	show($L['amount_must_greater_0']);
	$note = addslashes($note);
	$r = member_info($username,'2');
	if(!$r) show($L['user_does_not_exist']);
	extract($r);
	$time = time();
	$ip = get_ip();
	if($chargetype == 0)
	{
		if($number > $credit) show($L['credit_number_user_not']);
        $db->query("UPDATE {$table}member SET credit=credit-$number WHERE username='$username'");
	    $db->query("INSERT INTO {$table}pay_exchange  (`username`,`type`,`value`,`note`,`addtime`,`ip`) VALUES('$username','credit','-".$number."','$note','$time','$ip')");
	}
	return TRUE;
}

function money_add($username, $number, $note = '')
{
	global $db, $table, $L;
	$number = round(floatval($number) ,2);
	$username = htmlspecialchars($username);
	if($number < 0) show($L['amount_must_greater_0']);
	$note = addslashes($note);
	$r = member_info($username,'2');
	if(!$r) show($L['user_does_not_exist']);
	extract($r);
	$money = $money + $number;
	$db->query("UPDATE {$table}member SET money=$money WHERE username='$username'");
	if($db->affected_rows() == 0) show($L['a_parameter_error']);
	$time = time();
	$year = date('Y', $time);
	$month = date('m', $time);
	$date = date('Y-m-d', $time);
	$ip = get_ip();
	$accrual = $L['accrual'];
	$db->query("INSERT INTO {$table}pay (typeid,note,paytype,amount,balance,username,year,month,date,inputtime,inputer,ip) VALUES('1','$note','$accrual','$number','$money','$username','$year','$month','$date','$time','system','$ip')");

	$db->query("INSERT INTO {$table}pay_exchange (`username`,`type`,`value`,`note`,`addtime`,`ip`) VALUES('$username','money','$number','$note','$time','$ip')");
}

function money_diff($username, $number, $note = '')
{
	global $db, $table, $L;
	$username = htmlspecialchars($username);
	$number = round(floatval($number) ,2);
	if($number == 0) return true;
	if($number < 0) show($L['amount_must_greater_0']);
	$note = addslashes($note);
	$r = member_info($username,'2');
	if(!$r) show($L['user_does_not_exist']);
	extract($r);
	if($number > $money) show($L['money_number_user_not']);
	$money = $money - $number;
	$db->query("UPDATE {$table}member SET money=$money WHERE username='$username'");
	
	$time = time();
	$year = date('Y', $time);
	$month = date('m', $time);
	$date = date('Y-m-d', $time);
	$ip = get_ip();
	$deduction = $L['deduction'];
	$db->query("INSERT INTO {$table}pay (typeid,note,paytype,amount,balance,username,year,month,date,inputtime,inputer,ip) VALUES('2','$note','$deduction','$number','$money','$username','$year','$month','$date','$time','system','$ip')");
	$db->query("INSERT INTO {$table}pay_exchange (`username`,`type`,`value`,`note`,`addtime`,`ip`) VALUES('$username','money','-".$number."','$note','$time','$ip')");

	return true;
}
?>