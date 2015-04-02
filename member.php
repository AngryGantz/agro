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
require AWEBCOM_ROOT . 'include/json.class.php';
require AWEBCOM_ROOT . 'include/pay.fun.php';
$act = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'index';
//разрешено гостям
$not_login = array('login','act_login','register','act_register','logout',  'ajax', 'get_password', 'reset_password', 'send_pwd_email', 'email_edit_password','table_charges','receive', 'check_info_gold', 'delinfo', 'editinfo', 'updateinfo', 'delimg', 'report', 'comment');
//разрешено зарегистрированным
$must_login = array('index','modify','act_modify', 'edit_password', 'act_edit_password', 'info','info_comment', 'pay', 'confirm', 'send', 'exchange', 'inout', 'act_gold', 'com_comment', 'com_list', 'editcom', 'updatecom', 'delcom', 'top', 'recom', 'send_info_mail' );

if(empty($_userid)) {
    if (!in_array($act, $not_login)) {
        if (in_array($act, $must_login)) {
            showmsg($L['log_into_the_control_panel'], 'member.php?act=login&refer='.$PHP_URL);
        } else {
			showmsg($L['information_only_available_registered']);
		}
    }
}

switch($act)
{
	case 'index':
	$seo['title'] = $L['f_control_panel'] . ' - '. $CFG['webname']. '';
		$userinfo = member_info($_userid);
		extract($userinfo);
		$email = htmlspecialchars($email);
		$username = htmlspecialchars($username);
		$surname = htmlspecialchars($surname);
		$registertime = date('Y-m-d', $registertime);
		if(empty($email) || empty($icq) || empty($phone))$notice=1;
		include template('member');
	break;

	case 'login':
		if(!empty($_userid)) {
			showmsg($L['log_into_the_control_panel'], "member.php");
		}
		$verf = get_one_ver();
		$refer = trim(htmlspecialchars_deep($_SERVER['HTTP_REFERER']));
		$seo['title'] = $L['f_login_control_panel'] . ' - '. $CFG['webname']. '';
		include template('login');
	break;

	case 'act_login':
		if(!submitcheck('submit')) showmsg($L['login_failed']);
		$username = $_POST['username'] ? htmlspecialchars_deep(trim($_POST['username'])) : '';
		$password = $_POST['password'] ? trim($_POST['password']) : '';
		$checkcode = $_POST['checkcode'] ? trim($_POST['checkcode']) : '';
		$md5_password = MD5($password);
		if(empty($username))showmsg($L['f_login_enter']);
		if(empty($password))showmsg($L['f_password_enter']);
		check_ver(intval($_REQUEST['vid']), trim($_REQUEST['answer']));

		if(login($username,$md5_password)) {
	        $memologin = $L['for_adding_login'];
			$credit_count = $db->getOne("select count(*) from {$table}pay_exchange where username='$username' and addtime>".mktime(0,0,0)." and note='$memologin' ");
			if($credit_count < $CFG['max_login_credit']) {
				if(!empty($CFG['login_credit'])) credit_add($username, $CFG['login_credit'],$L['for_adding_login']);
			}
			$url= $_REQUEST['refer'] ? rawurldecode($_REQUEST['refer']) : 'member.php';
			showmsg($L['go_to_control_panel'], $url);
		} else {
			showmsg($L['erroneous_data'],'member.php?act=login');
		}
	break;
	
	case 'logout':
		logout();
		$link = "index.php";
		showmsg($L['you_are_out_control_panel'],$link);
	break;

	case 'register':
		if($CFG['close_register'] == '1') showmsg($L['registration_new_members_temporarily_closed']);
		if(!empty($_userid)) {
			$link = "member.php?act=index";
			showmsg($L['you_are_already_registered'], $link);
		}
		$ip = get_ip();
		$verf = get_one_ver();
		$seo['title'] = $L['f_registration'] . ' - '. $CFG['webname']. '';
		include template('register');
	break;

	case 'act_register':
		$ip = get_ip();
		if(!submitcheck('submit')) showmsg($L['registration_error']);

		$username   = $_POST['username'] ? htmlspecialchars_deep(trim($_POST['username'])) : '';
		$password   = $_POST['password'] ? trim($_POST['password']) : '';
		$repassword = $_POST['repassword'] ? trim($_POST['repassword']) : '';
		$email      = $_POST['email']?trim($_POST['email']):'';
		$checkcode  = $_POST['checkcode']?trim($_POST['checkcode']):'';
		$md5_password = MD5($password);

		if(empty($username))showmsg($L['f_login_enter']);
		if(empty($password))showmsg($L['f_password_enter']);
		if(empty($repassword))showmsg($L['password_again_empty']);
		if(empty($email))showmsg($L['email_empty']);
		if($password != $repassword)showmsg($L['f_passwords_do_not_match']);
		if(!is_email($email))showmsg($L['f_invalid_email']);
		check_ver(intval($_REQUEST['vid']), trim($_REQUEST['answer']));

		if(empty($res)) {
			if(register($username,$md5_password,$email)) {
				if(!empty($CFG['register_credit']))credit_add($_SESSION['username'], $CFG['register_credit'],$L['for_register']);

				$link='member.php';
				showmsg($L['successfully_registered'],$link);
			} else {
				$link = "member.php?act=register";
				showmsg($L['unsuccessful_attempt_register'],$link);
			}
		}
		login($username, $md5_password);
		showmsg($L['successfully_registered'], 'member.php');
	break;

	case 'modify':
		$userinfo = member_info($_userid);
		$seo['title'] = $L['modifying_data'] . ' - '. $CFG['webname']. '';
		include template('member_modify');
	break;

	case 'act_modify':
		$surname    = $_POST['surname'] ? htmlspecialchars_deep(trim($_POST['surname'])) : '';
		$phone    = $_POST['phone'] ? htmlspecialchars_deep(trim($_POST['phone'])) : '';
		$icq       = $_POST['icq'] ? htmlspecialchars(intval($_POST['icq'])) : '';
		$address  = $_POST['address'] ? htmlspecialchars_deep(trim($_POST['address'])) : '';
		$mappoint = $_POST['mappoint'] ? trim($_POST['mappoint']) : '';
		$userid   = $_SESSION['userid'];
		$username = $_SESSION['username'] ? htmlspecialchars_deep($_SESSION['username']) : '';
		$email    = trim($_POST['email']);
		if(!is_email($email))showmsg($L['f_invalid_email']);


		$sql = "update {$table}member set 
				surname = '$surname',
				phone = '$phone',
				icq = '$icq',
				address = '$address',
				mappoint = '$mappoint',
				email = '$email'
				where userid='$_userid' and username='$username' ";
		$res = $db->query($sql);

		showmsg($L['data_were_changed'], 'member.php?act=modify');
	break;

	case 'edit_password':
		$seo['title'] = $L['changing_password'] . ' - '. $CFG['webname']. '';
		include template('member_edit_password');
	break;

	case 'act_edit_password':
		$oldpassword = $_POST['oldpassword'] ? trim($_POST['oldpassword']) : '';
		$password = $_POST['password'] ? trim($_POST['password']) : '';
		$repassword = $_POST['repassword'] ? trim($_POST['repassword']) : '';
		
		if(empty($oldpassword) && !empty($password))showmsg($L['enter_existing_password']);
		if(empty($password))showmsg($L['new_password_empty']);
		if(empty($repassword))showmsg($L['new_password_again_empty']);
		if($password && $repassword && $password!=$repassword)showmsg($L['f_passwords_do_not_match']);

		$sql = "SELECT password FROM {$table}member WHERE userid='$_userid' LIMIT 1";
		if(MD5($oldpassword) != $db->getOne($sql))showmsg($L['current_password_incorrect']);

		$password = MD5($password);
		$query = $db->query("UPDATE {$table}member SET password='$password' WHERE userid='$_userid' ");


		showmsg($L['password_successfully_changed'],'member.php?act=edit_password');
	break;

	case 'ajax':
		$json = new Services_JSON;
		switch($_REQUEST['type'])
		{
			case 'username':
				$username = trim($_REQUEST['username']);
				$sql = "SELECT count(*) FROM {$table}member WHERE username='$username'";
				$count = $db->getOne($sql);
				if($count>0) {
					echo $json->encode(false);
					exit;
				} else {
					echo $json->encode(true);
					exit;
				}
			break;

			case 'email':
				$count = $uc_count = 0;
				$email = trim($_REQUEST['email']);
				$sql = "SELECT userid FROM {$table}member WHERE email='$email'";
				$count = $db->getOne($sql);


				if($count>0 || $uc_count<0) {
					echo $json->encode(false);
					exit;
				} else {
					echo $json->encode(true);
					exit;
				}
			break;
		}
	break;
	
	case 'pay':
		$payonline_setting = get_pay_setting();
		//$paycenter = $_COOKIE['paycenter'];
		if($paycenter) $selected[$paycenter] = 'selected';
		if(!isset($amount)) $amount = '';
		$memberinfo = member_info($_userid);
		$email = $memberinfo['email'];
		$typepay = MD5($orderid.$AWEBCOM_TIME);
		$seo['title'] = $L['fill_up_balance'] . ' - '. $CFG['webname']. '';
		include template('pay');
	break;

	case 'confirm':
		$payonline_setting = get_pay_setting();
		$paycenter = trim($_POST['paycenter']);
		$email = trim($_POST['email']);
		$amount = round(floatval($_POST['amount']), 2);
		if($amount < 0.1) showmsg($L['minimum_payment_amount']);

        array_key_exists($paycenter, $payonline_setting);
		//array_key_exists($paycenter, $payonline_setting) or showmsg($L['payment_system_does_not_exist']);//ну бред полный, если не хочет работать
		@extract($payonline_setting[$paycenter]);
		$percent = round(floatval($percent), 2);
		$money = round($amount * $percent, 2);
		$total_amount = round($amount * $percent, 2);
		$seo['title'] = $L['confirmation_payment'] . ' - '. $CFG['webname']. '';
		include template('payconfirm');
	break;
	
	case 'send':
		$paycenter = trim($_POST['paycenter']);
		$contactname = trim($_POST['contactname']);
		$telephone = trim($_POST['telephone']);
		$email = trim($_POST['email']);
		$len = strlen($to);
		if($len > 11)showmsg($L['mobile_length_10']);
		$to = trim($_POST['to']);
		$username = trim($_POST['username']);
		$memberinfo = member_info($_userid);
		$memail = $memberinfo['email'];		
		$time = time();
		$ip = get_ip();
		$payonline_setting = get_pay_setting();
		array_key_exists($paycenter, $payonline_setting) or showmsg($L['payment_system_does_not_exist']);
		@extract($payonline_setting[$paycenter]);
		setcookie('paycenter', $paycenter, time() + 3600*24*365);

		//$r = $db->getOne("SELECT payid FROM {$table}pay_online WHERE `orderid`='$orderid'");
		//if($r) showmsg('Не надо обновлять страницу');
		//$moneytype = $CFG['currency'];
		$percent = round(floatval($percent), 2);
		$amount = floatval($_POST['amount']);
		$money = round($amount * $percent, 2);
		$db->query("INSERT INTO {$table}pay_online (`paycenter`,`username`,`amount`,`money`,`percent`,`telephone`,`email`,`sendtime`,`ip`) VALUES('$paycenter','$_username','$amount','$money','$percent','$telephone','$email','$time','$ip')");
			$orderid = $db->insert_id();
			$receive_url = ''.$CFG['weburl'].'/member.php?act=receive';
			$fail_url = ''.$CFG['weburl'].'/member.php?act=receive&fail';
			$status_url = ''.$CFG['weburl'].'/api/pay/'.$paycenter.'/charge.php';
			$sr = MD5($orderid.$AWEBCOM_TIME.$_username);
			$amount = round($amount * $percent, 2);
			include AWEBCOM_ROOT.'/api/pay/'.$paycenter.'/send.inc.php';
	break;
	
	case 'receive':
		extract($_REQUEST);
		$payonline_setting = get_pay_setting();
		array_key_exists($paycenter, $payonline_setting) or showmsg($L['payment_error']);
		@extract($payonline_setting[$paycenter]);
		$charge_errcode = '';
		$charge_status = 0;
		$r = $db->getRow("SELECT * FROM {$table}pay_online WHERE username='$_username' ORDER BY payid DESC");
		if($r) {
			$charge_orderid = $r['payid'];
			$charge_money = round($r['amount'] * $r['percent'], 2);
			$charge_amount = round($r['amount'], 2);
			if($r['status'] == 0) {
				$charge_status = 3;
				if(isset($fail)) {
					$charge_status = 2;		
					$charge_errcode = $L['charge_msg_order_cancel'].$charge_orderid;
				}
			} else if($r['status'] == 1) {
				$charge_status = 2;		
				$charge_errcode = $L['charge_msg_order_fail'].$charge_orderid;
			} else if($r['status'] == 2) {
				$charge_status = 2;		
				$charge_errcode = $L['charge_msg_order_cancel'].$charge_orderid;
			} else {
				$charge_status = 1;
			}
		} else {
			$charge_status = 2;		
			$charge_errcode = $L['charge_msg_not_order'];
			if(isset($fail)) {
				$charge_status = 2;		
				$charge_errcode = $L['charge_msg_order_cancel'].$charge_orderid;
			}
		}
		$seo['title'] = $L['payment_status'] . ' - '. $CFG['webname']. '';
		include template('payreceive');
	break;

	case 'exchange':
		$units = array('money'=>$CFG['currency'], 'credit'=>$L['min_points']);
		$types = array('money'=>$CFG['currency'], 'credit'=>$L['max_points']);
		$notes = array('login'=>$L['for_adding_login'], 'post_info_credit'=>$L['for_adding_topic'] ,'post_comment_credit'=>$L['for_adding_comment'] ,'info_top'=>$L['adding_top'] , 'creditexchange'=>$L['exchange'], 'exchange'=>$L['exchange']);
		extract($_REQUEST);
		$page = isset($page) ? intval($page) : 1;
	    $pagesize = $CFG['pagesize'];

		$sql = '';
		if($type) $sql .= " AND type='$type' ";
		if($begindate) {
			$begintime = strtotime($begindate.' 00:00:00');
			$sql .= " AND addtime>=$begintime ";
		}
		if($enddate) {
			$endtime = strtotime($enddate.' 23:59:59');
			$sql .= " AND addtime<=$endtime";
		}
		$r = $db->getOne("SELECT count(*) as number FROM {$table}pay_exchange WHERE username='$_username' $sql");
		$pager['search'] = array('act' => 'exchange');
		$pager = get_pager('member.php', $pager['search'], $r, $page, $pagesize);

		$exchanges = array();
		$result = $db->query("SELECT * FROM {$table}pay_exchange WHERE username='$_username' $sql ORDER BY exchangeid DESC LIMIT $pager[start],$pager[size]");
		while($r = $db->fetchrow($result)) {
			$r['unit'] = $units[$r['type']];
			$r['type'] = $types[$r['type']];
			$r['note'] = !empty($notes[$r['note']]) ? $notes[$r['note']] : $r['note'];
			$r['addtime'] = date('Y-m-d H:i:s', $r['addtime']);
			$exchanges[] = $r;
		}
		$seo['title'] = $L['usage_charges'] . ' - '. $CFG['webname']. '';
		include template('member_exchange');
	break;

	case 'get_password':
		if(!$CFG['sysmail'])showmsg($L['no_settings_sending_mail']);
		if(!empty($_userid)) {
			$link = "member.php?act=edit_password";
			showmsg($L['redirect_to_change_password'], $link);
		}
		if (isset($_GET['code']) && isset($_GET['userid'])) {
			$code = trim($_GET['code']);
			$userid  = intval($_GET['userid']);
			/* Определяем корректность перехода */
			$user_info = member_info($userid);
			if (empty($user_info) || ($user_info && md5($user_info['userid'] . $CFG['crypt'] . $user_info['registertime']) != $code)) {
				showmsg($L['parameter_error']);
			}
		    $seo['title'] = $L['changing_password'] . ' - '. $CFG['webname']. '';
			include template('reset_password');
		} else {
		    $seo['title'] = $L['password_reset'] . ' - '. $CFG['webname']. '';
		    $verf = get_one_ver();
			include template('get_password');
		}
	break;

	case 'send_pwd_email':
		$username = !empty($_POST['username']) ? trim($_POST['username']) : '';
		$email     = !empty($_POST['email'])     ? trim($_POST['email'])     : '';
		$user_info = member_info($username,'2');
	    check_ver(intval($_REQUEST['vid']), trim($_REQUEST['answer']));
		if ($user_info && $user_info['email'] == $email) {
			$code = md5($user_info['userid'] . $CFG['crypt'] . $user_info['registertime']);
			if (send_pwd_email($user_info['userid'], $username, $email, $code)) {
				showmsg($L['send_pwd_email'] , 'index.php');
			} else {
				showmsg($L['failed_send_message'] , 'index.php');
			}
		} else {
			showmsg($L['no_user_with_password_email']);
		}
	break;

	case 'email_edit_password':
		$new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
		$confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
		$userid  = isset($_POST['userid']) ? intval($_POST['userid']) : $userid;
		$code = isset($_POST['code']) ? trim($_POST['code'])  : '';

		if (strlen($new_password) < 6)showmsg($L['password_least_6_characters']);
		if($new_password != $confirm_password)showmsg($L['f_passwords_do_not_match']);
		$user_info = member_info($userid);

		if (($user_info && (!empty($code) && md5($user_info['userid'] . $CFG['crypt'] . $user_info['registertime']) == $code))) {
			$password = MD5($new_password);
			$sql = "UPDATE {$table}member SET password='$password' WHERE userid='$userid' ";
			$query = $db->query($sql);

			showmsg($L['password_successfully_changed'], 'index.php');
		} else {
			showmsg($L['failed_change_password'], 'index.php');
		}
	break;

	case 'inout':
		$userinfo = member_info($_userid);
		if($CFG['creditexchange'] >0) {
		$_inout = $userinfo['credit'] / $CFG['creditexchange'];//макс. кол-во можно получить
		}
		$seo['title'] = $L['exchange_points'] . ' '. $CFG['currency']. ' - '. $CFG['webname']. '';
		include template('member_inout');
	break;
//рассчет обмена
	case 'act_gold':
		$type = $_POST['type'];
		$number = $type == 'exchange' ? intval($_POST['m_number']) : intval($_POST['c_number']);
        $CFG['exchange'] = 1;//единица валюты
		if($number <= 0)showmsg($L['amount_must_greater_0']);
		$userinfo = member_info($_userid);
		$_credit = $number * $CFG['creditexchange'];
		if($type == 'exchange') {
			//if($_money > $userinfo['money']) showmsg('Недостаточно средств для обмена');
			//money_diff($_username, $_money, $type);
		} else {
			if($_credit > $userinfo['credit']) showmsg($L['not_have_many_points']);
			credit_diff($_username, $_credit, $type);
		}
		money_add($_username, $number, $type);

		showmsg($L['exchange_completed'] , 'member.php?act=inout');
	break;

	case 'table_charges':
		$user_info = member_info($_userid);
		$seo['title'] = $L['f_table_of_charges'] . ' - '. $CFG['webname']. '';
		include template('table_charges');
	break;

	case 'check_creditmoney':
		$json = new Services_JSON;
		$number = intval($_REQUEST['number']);
		$sql = "select credit from {$table}member where userid='$_userid'";
		$user_credit = $db->getOne($sql);
		$pay_credit = $number * $CFG['creditexchange'];
		$data = $pay_credit > $user_credit ? '0' : '1';
		echo $json->encode($data);
	break;

	case 'check_info_money':
		$json = new Services_JSON;
		$number = intval($_REQUEST['number']);
		$m_money = $db->getOne("select money from {$table}member where userid='$_userid' ");
		$data['kou'] = $CFG['info_top_gold'] * intval($number);
		$data['money'] = $m_money - $data['kou'];
		$data=$json->encode($data);
		echo $data;
	break;
	

	case 'info':
		$page = !empty($_REQUEST['page'])  && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;
		$size = !empty($CFG['pagesize']) && intval($CFG['pagesize']) > 0 ? intval($CFG['pagesize']) : 10;
		$sql = "SELECT COUNT(*) FROM {$table}info WHERE userid='$_userid'";
		$count = $db->getOne($sql);
		$max_page = ($count> 0) ? ceil($count / $size) : 1;
		if($page>$max_page)$page = $max_page;
		$pager['search'] = array('act' => 'info');
		$pager = get_pager('member.php', $pager['search'], $count, $page, $size);
		$sql = "SELECT i.*,a.areaname FROM {$table}info as i left join {$table}area as a on a.areaid=i.areaid WHERE userid='$_userid' ORDER BY id desc LIMIT $pager[start],$pager[size]";
		$res = $db->query($sql);
		$infos = array();
		while($row = $db->fetchRow($res)) {
			$row['title']    = cut_str($row['title'],'38');
			$row['postdate'] = date('Y-m-d-H-i', $row['postdate']);
			$row['lastdate'] = enddate($row['enddate']);
			$row['is_pro']   = $row['is_pro']>=time();
			$row['is_top']   = $row['is_top']>=time();
			$row['url']      = url_rewrite('view',array('vid'=>$row['id']));
			$infos[] = $row;
		}
		$seo['title'] = $L['f_my_listing'] . ' - '. $CFG['webname']. '';
		include template('member_info');
	break;

	case 'delinfo':
		$id = intval($_REQUEST['id']);
		if(empty($id)) showmsg($L['invalid_request']);
		$info = getInfo($id);
		if(empty($info)){showmsg($L['view_does_not_exist'],'index.php');}
		checkInfoUser($id, trim($_REQUEST['password']));
		delInfo($id);

		showmsg($L['listing_successfully_removed'], $_SERVER['HTTP_REFERER']);
	break;

	case 'editinfo':
		$id = intval($_REQUEST['id']);
		$sql = "SELECT * FROM {$table}info WHERE id = '$id'";
		$info = $db->getRow($sql);
		if(empty($info)){showmsg($L['view_does_not_exist'],'index.php');}
		checkInfoUser($id, trim($_REQUEST['password']));
		extract($info);
		$sql = "SELECT * FROM {$table}info_image WHERE infoid = '$id' ";
		$images = array();
		$images = $db->getAll($sql);
		$up_img_count = count($images);
		$img_count = 6-$up_img_count;
		$postdate = date('Y-m-d-H-i', $postdate);
		$lastdate  = round(($enddate>0 ? ($enddate-time()) : '0')/(3600*24));
		//$lastdate = round(($enddate-time())/(3600*24));
		//$lastdate = $lastdate ? $lastdate : '30';
		$custom = cat_post_custom($catid,$id);
		$info_area = area_options($areaid);
		$seo['title'] = $L['modifying_topic'] . ' - '. $CFG['webname']. '';
		include template('edit_info');
	break;

	case 'updateinfo':
		$id       = intval($_POST['id']);
		$title    = $_POST['title'] ? htmlspecialchars_deep(trim($_POST['title'])) : '';
		$areaid   = $_POST['areaid'] ? intval($_POST['areaid']) : '';
		$enddate  = !empty($_POST['enddate']) ? (intval($_POST['enddate']*3600*24)) + time() : '0';
		$content  = $_POST['content'] ? htmlspecialchars_deep(trim($_POST['content'])) : '';
	    $keywords  = $_POST['keyword'] ? htmlspecialchars_deep(trim($_POST['keyword'])) : '';
        $description = addslashes(get_intro($content, 200));
		$linkman  = $_POST['linkman'] ? htmlspecialchars_deep(trim($_POST['linkman'])) : '';
		$phone    = $_POST['phone'] ? trim($_POST['phone']) : '';
		$icq       = $_POST['icq'] ? intval($_POST['icq']) : '';
		$email    = $_POST['email'] ? htmlspecialchars_deep(trim($_POST['email'])) : '';
		$address  = $_POST['address'] ? htmlspecialchars_deep(trim($_POST['address'])) : '';
		$youtube  = $_POST['youtube'] ? htmlspecialchars(trim($_POST['youtube'])) : '';
		$price  = $_POST['price'] ? htmlspecialchars_deep(trim($_POST['price'])) : '';
		$unit  = $_POST['unit'] ? htmlspecialchars_deep(trim($_POST['unit'])) : '';
		$mappoint = $_POST['mappoint'] ? trim($_POST['mappoint']) : '';
		$thumb = trim($_POST['thumb']);
		if(empty($title))showmsg($L['title_empty']);
		if(empty($content))showmsg($L['content_empty']);
		if(empty($phone) && empty($icq) && empty($email))showmsg($L['enter_your_contact_details']);
		check_words(array($title,$content));

		$items = array(
			'areaid' => $areaid,
			'title' => $title,
		    'keywords' => $keywords,
		    'description' => $description,
			'content' => $content,
			'linkman' => $linkman,
			'email' => $email,
			'icq' => $icq,
			'phone' => $phone,
			'mappoint' => $mappoint,
			'address' => $address,
		    'youtube' => $youtube,
		    'price' => $price,
		    'unit' => $unit,
			'enddate' => $enddate
		);
		
		$count = count($_FILES);
		for($i=1;$i<=$count;$i++)
		{
			$alled = array('png','jpg','gif','jpeg');
			$exname = strtolower(trim(substr(strrchr($_FILES['file'. $i]['name'], '.'), 1)));
			if(!checkupfile($_FILES['file'. $i]['tmp_name']) || !($_FILES['file'. $i]['tmp_name'] != 'none' && $_FILES['file'. $i]['tmp_name'] && $_FILES['file'. $i]['name']) || $_FILES['file'. $i]['size']>'523298' || !in_array($exname,$alled)){
				continue;
			}
			$name = date('ymdhis');
			for($a = 0;$a < 6;$a++){ $name .= chr(mt_rand(97, 122));}
			$thumb_name = $name.'_thumb'. '.' . end(explode('.', $_FILES['file'. $i]['name']));;
			$name .= '.' . end(explode('.', $_FILES['file'. $i]['name']));
			
			$dir = AWEBCOM_ROOT . 'data/infoimage/' . date('ymd');
			if(!is_dir($dir))if(@mkdir(rtrim($dir,'/'), 0777))@chmod($dir, 0777);
			$to = $dir.'/'. $name;
			if(move_uploaded_file($_FILES['file'. $i]['tmp_name'], $to)) {
				$image = 'data/infoimage/' . date('ymd').'/'. $name;
				$sql = "INSERT INTO {$table}info_image (infoid,path) VALUES ('$id','$image')";
				$db->query($sql);
			}
			if(empty($thumb)) {
				if(!$do) {
					$newimg ='data/infoimage/' . date('ymd').'/'.$thumb_name;
					$thumb = CreateSmallImage( AWEBCOM_ROOT.$image,  AWEBCOM_ROOT.$newimg, 154, 134);
					$sql = "update {$table}info set thumb='$newimg' where id='$id' ";
					$db->query($sql);
					$do = true;
				}
			}
		}
		
		if (isset($_POST['cus_value']))
		{
		$infoid = $id;
		$cus_value_list = array();

		$res = $db->query("SELECT * FROM {$table}cus_value WHERE infoid = '$infoid'");
		while ($row = $db->fetchRow($res)) {
		$cus_value_list[$row['cusid']][$row['cusvalue']] = array('query' => 'delete', 'id' => $row['id']);
		}
		foreach ($_POST['cus_value'] AS $key => $val)
		{
		if(is_array($val))$val=implode(",", $val);

		$cusvalue = $val;
		if (!empty($cusvalue))
		{
		if (isset($cus_value_list[$key][$cusvalue]))
		{
		$cus_value_list[$key][$cusvalue]['query'] = 'update';
		}
		else
		{
		$cus_value_list[$key][$cusvalue]['query'] = 'insert';
		}
		}
		}
		foreach ($cus_value_list as $cusid => $value_list)
		{
		foreach ($value_list as $cusvalue => $infos)
		{

		if ($infos['query'] == 'insert')
		{
		$sql = "INSERT INTO {$table}cus_value (cusid, infoid, cusvalue) VALUES ('$cusid', '$infoid', '$cusvalue')";
		}
		elseif ($infos['query'] == 'delete')
		{
		$sql = "DELETE FROM {$table}cus_value WHERE id = '$infos[id]' LIMIT 1";
		}
		elseif ($infos['query'] == 'update')
		{
		$sql = "update {$table}cus_value set cusvalue='$cusvalue' where id='$infos[id]' ";
		}
		$db->query($sql);
		}
		}
		}
		$res = editInfo($items, $_POST['cus_value'], $id);

		$res ? $msg=$L['data_updated'] : $msg=$L['failed_update_data'];
		$link = "view.php?id=$id";
		showmsg($msg, $link);
	break;
	
	case 'delimg':
		$imgid = $_REQUEST['imgid'];
		$img = $db->getOne("select path from {$table}info_image where imgid='$imgid' ");

		if($img != '' && is_file(AWEBCOM_ROOT.$img)){
			unlink(AWEBCOM_ROOT.$img);
		}
		$sql = "delete from {$table}info_image where imgid='$imgid' ";
		$db->query($sql);
		if(!empty($_userid)) {
	    showmsg($L['done'], 'member.php?act=info');
		} else {
	    showmsg($L['done'], "index.php");
		}
	break;

	case 'report':
		$info     = intval($_REQUEST['id']);
		$type     = intval($_REQUEST['types']);
		$ip       = get_ip();
		$postdate = time();
		
		$yes = $db->getOne("SELECT COUNT(*) FROM {$table}report WHERE info='$info' AND ip='$ip'");
		if($yes) showmsg($L['you_have_already_reported_abuse']);

		$db->query("INSERT INTO {$table}report (info,type,ip,postdate) VALUES ('$info','$type','$ip','$postdate')");
		showmsg($L['message_sent_thank'], trim(htmlspecialchars_deep($_SERVER['HTTP_REFERER'])));
	break;

	case 'comment':
		if(!$CFG['visitor_comment'] && empty($_userid)) showmsg($L['comment_add_reg']);
		$infoid = intval($_POST['id']);
		$userid = $_userid;
		$username = $_username;
		$content = htmlspecialchars_deep(trim($_POST['content']));
		$checkcode = trim($_POST['checkcode']);
		if(empty($infoid)) {
			showmsg($L['view_does_not_exist']);
		}
		$ip = get_ip();
		if(empty($content))showmsg($L['enter_content_comment']);
		if(empty($checkcode))showmsg($L['enter_verification_code']);
		check_code($checkcode);
		check_words(array($content));

		$postdate = time();
		$check = $CFG['comment_check'] == '0' ? '1' : '0' ;
		$sql = "INSERT INTO {$table}comment (infoid,userid,username,content,postdate,is_check,ip,type) VALUES ('$infoid','$userid','$username','$content','$postdate','$check','$ip','$type')";
		$res = $db->query($sql);

		if($_username) {
	        $memo = $L['for_adding_comment'];
			$credit_count = $db->getOne("select count(*) from {$table}pay_exchange where username='$_username' and addtime>".mktime(0,0,0)." and note='$memo' ");
			if($credit_count < $CFG['max_comment_credit']) {
				if(!empty($CFG['post_comment_credit']))credit_add($_username, $CFG['post_comment_credit'],$L['for_adding_comment']);
			}
		}
		if($CFG['comment_check'] == '1')$msg = "<br>".$L['comment_posted_and_will_available_checking']."";
		if($type=='com') 
		$link = "com.php?act=view&id=$infoid";
		else if($type=='article') {
		$link = "article.php?act=view&id=$infoid";
		} else {
		$link = "view.php?id=$infoid";
		}
		showmsg("".$L['comment_added_successfully']." $msg", $link);
	break;

	case 'info_comment':
        $page = empty($_REQUEST['page']) ? '1' : intval($_REQUEST['page']);
	    $size = $CFG['pagesize'];
		$count = $db->getOne("SELECT COUNT(*) FROM {$table}comment where userid='$_userid'");
		$pager = get_pager('member.php',array('act'=>'info_comment'),$count,$page,$size);
		$sql = "SELECT * FROM {$table}comment where userid='$_userid' ORDER BY id DESC LIMIT $pager[start],$pager[size]";
		$res = $db->query($sql);
		$comments = array();
		while($row=$db->fetchRow($res)) {
			$row['postdate'] = date('Y-m-d-H-i', $row['postdate']);
			$row['title']    = cut_str($row['content'], 35);
		if($row['type']=='com') 
		$row['url'] = url_rewrite('com', array('act'=>'view', 'comid'=>$row['infoid']));
		else if($row['type']=='article') {
            $row['url']      = url_rewrite('article', array('aid'=>$row['infoid'],'act'=>'view'));
		} else {
			$row['url']      = url_rewrite('view',array('vid'=>$row['infoid']));
		}
			$comments[] = $row;
		}
		$seo['title'] = $L['my_comments'] . ' - '. $CFG['webname']. '';
	    include template('member_info_comment');
	break;

	case 'delete':
		$id = is_array($_REQUEST['id']) ? join(',', $_REQUEST['id']) : intval($_REQUEST['id']);
		if(empty($id))showmsg($L['invalid_request']);
		$db->query("DELETE FROM {$table}comment WHERE id IN ($id)");
		showmsg($L['done'], 'member.php?act=info_comment');
	break;


	case 'top':
		$id = intval($_REQUEST['id']);
		$infouser = $db->getOne("select userid from {$table}info where id='$id' ");
		if($infouser != $_userid)showmsg($L['this_not_your_ad']);

		if(!empty($_POST['submit'])) {
		if(intval($_POST['number']) < 1)showmsg($L['least_one_night']);
			money_diff($_username, $CFG['info_top_gold']*$_POST['number'], $L['adding_top']);
			//money_diff($_username, $CFG['info_top_gold'], $L['adding_top']);
			$is_top = intval($_POST['number'])*3600*24+time();
			$db->query("update {$table}info set is_top='$is_top',top_type='$_POST[top_type]' where id='$id' ");

			$url = 'member.php?act=info';
			showmsg($L['ad_has_raised_top'], $url);
		} else {
		    $seo['title'] = $L['adding_top'] . ' - '. $CFG['webname']. '';
			$user_info = member_info($_userid);
			$info = $db->getRow("select * from {$table}info where id='$id'");
			$is_top = $info['is_top'];
			if($is_top>time())showmsg($L['ad_has_been_taken_top']);
			include template('member_info_top');
		}
	break;
	
	case 'recom':
		$id = intval($_REQUEST['id']);
		$infouser = $db->getOne("select userid from {$table}info where id='$id' ");
		if($infouser != $_userid)showmsg($L['this_not_your_ad']);

		if(!empty($_POST['submit'])) {
		if(intval($_POST['number']) < 1)showmsg($L['least_one_night']);
			money_diff($_username, $CFG['info_recomend']*$_POST['number'], $L['adding_recomend']);
			//money_diff($_username, $CFG['info_recomend'], $L['adding_recomend']);
			$is_pro = intval($_POST['number'])*3600*24+time();
			$db->query("update {$table}info set is_pro='$is_pro' where id='$id' ");
			$url = 'member.php?act=info';
			showmsg($L['ad_has_go_recommended'], $url);
		} else {
		    $seo['title'] = $L['adding_recomend'] . ' - '. $CFG['webname']. '';
			$user_info = member_info($_userid);
			$info = $db->getRow("select * from {$table}info where id='$id'");
			$is_pro = $info['is_pro'];
			if($is_pro>time())showmsg($L['ad_has_been_taken_recommended']);
			include template('member_info_recom');
		}
	break;
	
	case 'send_info_mail':
		include AWEBCOM_ROOT.'include/cont.phpmailer.php';
		extract($_REQUEST);
		$email = decrypt($email, $CFG['crypt']);
		$member = member_info($_userid);
		$membermail = $member['email'];
		if(empty($surname))showmsg($L['enter_your_name']);
		if(empty($title))showmsg($L['enter_theme']);
		if(empty($content))showmsg($L['enter_content_message']);
		if(empty($answer))showmsg($L['f_enter_answer_question']);
	    check_ver(intval($_REQUEST['vid']), trim($_REQUEST['answer']));
        $content = "$content<br/>".$L['message_sent_from_site'].": <a href=\"$CFG[weburl]\" target=\"_blank\">".$CFG['webname']."</a>";
		$mail             = new PHPMailer();
		$body             = "$content";
		$body = stripslashes($body);
		$mail->IsMail(); 
		$mail->From       = "$membermail";
		$mail->FromName   = "$surname";
		$mail->Subject    = "$title";
		$mail->MsgHTML($body);
		$mail->AddAddress("$email", "".$L['you']."");
		if ($mail->Send() ) {
			showmsg($L['message_sent_successfully'], $_SERVER['HTTP_REFERER']);
		} else {
			showmsg($L['failed_send_message'], $_SERVER['HTTP_REFERER']);
		}
	break;
	case 'com':
        $page = empty($_REQUEST['page']) ? '1' : intval($_REQUEST['page']);
	    $size = $CFG['pagesize'];
		$sql = "SELECT COUNT(*) FROM {$table}com WHERE userid='$_userid'";
		$count = $db->getOne($sql);
		$max_page = ($count> 0) ? ceil($count / $size) : 1;
		if($page>$max_page)$page = $max_page;
		$pager['search'] = array('act' => 'com');
		$pager = get_pager('member.php', $pager['search'], $count, $page, $size);
		$sql = "SELECT i.*,a.areaname FROM {$table}com as i left join {$table}area as a on a.areaid=i.areaid WHERE userid='$_userid' ORDER BY comid desc,postdate desc LIMIT $pager[start],$pager[size]";
		$res = $db->query($sql);
		$coms = array();
		while($row = $db->fetchRow($res)) {
			$row['comname']  = cut_str($row['comname'],'35');
			$row['postdate'] = date('Y-m-d-H-i', $row['postdate']);
			$row['url']      = url_rewrite('com',array('act'=>'view','comid'=>$row['comid']));
			$coms[] = $row;
		}
		 $seo['title'] = $L['my_company'] . ' - '. $CFG['webname']. '';
		include template('member_com','com');
	break;

	case 'editcom':
		$comid = intval($_GET['id']);
		$sql = "SELECT c.*,cc.catname FROM {$table}com as c left join {$table}com_cat as cc on c.catid=cc.catid WHERE comid = '$comid'";
		$com = $db->getRow($sql);
		$com['comuid'] = $com['userid'];
		unset($com['userid']);
		if(empty($com))showmsg($L['company_does_not_exist'],'index.php');
		if($com['comuid']!=$_userid)showmsg($L['not_your_company']);
		extract($com);
		$postdate = date('Y-m-d-H-i', $postdate);
		$thumb    = AWEBCOM_PATH.$thumb;
		$com_area = area_options($areaid);
		$seo['title'] = $L['my_company_edit'] . ' - '. $CFG['webname']. '';
		include template('member_editcom','com');
	break;

	case 'updatecom':
		$comid    = intval($_POST['id']);
		$comname  = $_POST['comname'] ? htmlspecialchars_deep(trim($_POST['comname'])) : '';
		$areaid   = $_POST['areaid'] ? intval($_POST['areaid']) : '';
		$introduce  = $_POST['introduce'] ? htmlspecialchars_deep(trim($_POST['introduce'])) : '';
	    $keywords  = $_POST['keywords'] ? htmlspecialchars(trim($_POST['keywords'])) : '';
        $description = addslashes(get_intro($introduce, 200));
		$linkman  = $_POST['linkman'] ? htmlspecialchars_deep(trim($_POST['linkman'])) : '';
		$phone    = $_POST['phone'] ? trim($_POST['phone']) : '';
		$icq       = $_POST['icq'] ? intval($_POST['icq']) : '';
		$email    = $_POST['email'] ? htmlspecialchars_deep(trim($_POST['email'])) : '';
		$address  = $_POST['address'] ? trim($_POST['address']) : '';
		$mappoint = $_POST['mappoint'] ? trim($_POST['mappoint']) : '';
		$hours     = $_POST['hours'] ? htmlspecialchars_deep(trim($_POST['hours'])) : '';
		$fax       = trim($_POST['fax']);

		if(empty($comname))showmsg($L['company_name_empty']);
		if(empty($introduce))showmsg($L['company_introduce_empty']);
		if(empty($phone) && empty($icq) && empty($email))showmsg($L['enter_your_contact_details']);
		
		check_words($who=array('comname','content'));

		if(!empty($_FILES['thumb']['name']))
		{
			$sql = "SELECT thumb FROM {$table}com WHERE comid IN ($comid)";
			$image = $db->getAll($sql);
			foreach((array)$image AS $val) {
				if($val['thumb'] != '' && is_file(AWEBCOM_ROOT.$val['thumb'])) {
					@unlink(AWEBCOM_ROOT . $val['thumb']);
				}
			}
			$alled = array('png','jpg','gif','jpeg');
            $maxsize = $INF['maxupload'];//макс. размер загружаемых файлов
			$exname = strtolower(trim(substr(strrchr($_FILES['thumb']['name'], '.'), 1)));
			if(checkupfile($_FILES['thumb']['tmp_name']) && $_FILES['thumb']['tmp_name'] != 'none' && $_FILES['thumb']['tmp_name'] && $_FILES['thumb']['name'] && $_FILES['thumb']['size']<$maxsize && in_array($exname,$alled))
			{
				$thumb_name = $comid.'_thumb'. '.' . end(explode('.', $_FILES['thumb']['name']));
				$dir = AWEBCOM_ROOT . 'data/com/thumb/';
				if(!is_dir($dir)) {
					if(@mkdir(rtrim($dir,'/'), 0777))@chmod($dir, 0777);
				}
				$to = $dir.'/'. $thumb_name;
				CreateSmallImage( $_FILES['thumb']['tmp_name'], $to, 154, 134);
				$image = 'data/com/thumb/'. $thumb_name;
				$sql = "update {$table}com set thumb='$image' where comid='$comid' ";
				$db->query($sql);
			}
		}
		// Новый прайслист
		if(!empty($_FILES['pricelist']['name']))
		{
			$sql = "SELECT pricelist FROM {$table}com WHERE comid IN ($comid)";
			$image = $db->getAll($sql);
			foreach((array)$image AS $val) {
				if($val['pricelist'] != '' && is_file(AWEBCOM_ROOT.$val['pricelist'])) {
					@unlink(AWEBCOM_ROOT . $val['pricelist']);
				}
			}
			$alled2 = array('zip','rar','7z','xls');
            $maxsize = $INF['maxupload']*40;//макс. размер загружаемых файлов
			$exname = strtolower(trim(substr(strrchr($_FILES['pricelist']['name'], '.'), 1)));
			if(checkupfile($_FILES['pricelist']['tmp_name']) && $_FILES['pricelist']['tmp_name'] != 'none' && $_FILES['pricelist']['tmp_name'] && $_FILES['pricelist']['name'] && $_FILES['pricelist']['size']<$maxsize && in_array($exname,$alled2))
			{
				$thumb_name = $comid.'_prlist'. '.' . end(explode('.', $_FILES['pricelist']['name']));
				$dir = AWEBCOM_ROOT . 'data/pricelist/';
				if(!is_dir($dir)) {
					if(@mkdir(rtrim($dir,'/'), 0777))@chmod($dir, 0777);
				}
				$to = $dir.'/'. $thumb_name;
				// CreateSmallImage( $_FILES['pricelist']['tmp_name'], $to, 154, 134);
				if(move_uploaded_file($_FILES['pricelist']['tmp_name'], $to)) {
					$pricelist = 'data/pricelist/'. $thumb_name;
					$sql = "update {$table}com set pricelist='$pricelist' where comid='$comid' ";
					$db->query($sql);
				}
			}
		}



		$sql = "UPDATE {$table}com SET
				areaid='$areaid',
				comname='$comname',
				introduce='$introduce',
				description='$description',
				keywords='$keywords',
				linkman='$linkman',
				email='$email',
				icq='$icq',
				phone='$phone',
				mappoint='$mappoint',
				address='$address',
				fax='$fax',
				hours='$hours'
				where comid = '$comid' ";
		$res = $db->query($sql);
		
		$msg=$L['companies_successfully_changed'];
		$link = url_rewrite('com',array('act'=>'view', 'comid'=>$comid));
		showmsg($msg, $link);
	break;

	case 'delcom':
		$comid = trim($_REQUEST['id']);
		$sql = "select userid from {$table}com where comid='$comid' ";
		$comuserid = $db->getOne($sql);
		if($comuserid!=$_userid)showmsg($L['not_your_company']);
		
		$sql = "SELECT thumb FROM {$table}com WHERE comid IN ($comid)";
		$image = $db->getOne($sql);
		if($image != '' && is_file(AWEBCOM_ROOT.$image)) {
			@unlink(AWEBCOM_ROOT.$image);
		}

		$sql = "SELECT path FROM {$table}com_image WHERE comid IN ($comid)";
		$image = $db->getAll($sql);
		foreach((array)$image AS $val) {
			if($val[path] != '' && is_file(AWEBCOM_ROOT.$val[path])) {
				@unlink(AWEBCOM_ROOT.$val[path]);
			}
		}

		$db->query("DELETE FROM {$table}com_image WHERE comid IN ($comid)");
		$db->query("DELETE FROM {$table}com WHERE comid IN ($comid)");

		showmsg($L['company_successfully_removed'],$_SERVER['HTTP_REFERER']);
	break;

//отправка письма идентификации E-mail	
	case 'send_check_email':
		if($_POST) 
		{
			$email = trim($_POST['email']);
			$user_info = member_info($_userid);
			$code = md5($user_info['userid'] . $CFG['crypt'] . $user_info['registertime']);
			$reset_email = $CFG['weburl'].'/member.php?act=check_email&userid='.$_userid.'&code=' . $code;
			$send_date = date('Y-m-d-H-i', time());
            $content = "".$L['respected']." $_username<br>".$L['sys_mess_email_identification'].": <strong>".$CFG['webname']."</strong><br>".$L['for_email_identification']." <a href=\"$reset_email\" target=\"_blank\">".$L['go_to_link']."</a> ".$L['copy_to_link'].":<br>".$reset_email."<br>".$L['dispatch_date'].": ".$send_date."";
			$code = md5($user_info['userid'] . $CFG['crypt'] . $user_info['registertime']);
			
		include AWEBCOM_ROOT.'include/cont.phpmailer.php';
		$mail             = new PHPMailer();
		$body             = "$content";
		$body = stripslashes($body);
		$mail->IsMail(); 
		$mail->From       = "$CFG[noreplymail]";
		$mail->FromName   = "".$L['administrator']."";
		$mail->Subject    = "".$L['identification_email']." $CFG[webname]";
		$mail->MsgHTML($body);
		$mail->AddAddress("$email", "$_username");
		if ($mail->Send() ) {
			showmsg($L['message_your_email_sent_successfully'] , 'member.php');
		} else {
		    showmsg($L['failed_send_message'] , 'member.php?act=send_check_email');
		}

		} else {
			$userinfo = member_info($_userid);
		    $seo['title'] = $L['identification_email'] . ' - '. $CFG['webname']. '';
			include template('member_check_email');
		}
	break;

	case 'check_email':
		$code = isset($_GET['code']) ? trim($_GET['code'])  : '';
		$user_info = member_info(intval($_REQUEST['userid']));

		if ($user_info && (!empty($code) && md5($user_info['userid'] . $CFG['crypt'] . $user_info['registertime']) == $code)) {
			$sql = "update {$table}member set status='1' where userid='$_userid' ";
			$query = $db->query($sql);
			showmsg($L['email_successfully_identified'], 'member.php');
		} else {
			showmsg($L['failed_send_message'], '?send_check_email');
		}
	break;
	default:
	showmsg($L['invalid_request'], 'index.php');
	break;
}
?>