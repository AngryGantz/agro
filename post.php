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
$act = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'select' ;

$ip = get_ip();

if(empty($CFG['visitor_post']) && empty($_userid)) {
	showmsg($L['disabled_guests_adding'],'member.php?act=login&refer='.$PHP_URL);
}

if((time() - $_COOKIE['lastposttime']) < $CFG['posttimelimit']) {
	showmsg("".$L['antiflood']." ".$CFG['posttimelimit']." ".$L['seconds']."");
}
if($_userid){
	$member = member_info($_userid);
	if($member['status']!=1) showmsg($L['account_moderation_or_blocked']);
	if((time() - $_lastposttime) < $CFG['posttimelimit']) {
		showmsg("".$L['antiflood']." ".$CFG['posttimelimit']." ".$L['seconds']."");
	}
}

if($act == 'select')
{
	$cats = get_cat_list();
	$seo['title'] = $L['select_category'] . ' - '. $CFG['webname']. '';
	$seo['keywords'] = $CFG['keywords'];
	$seo['description'] = $CFG['description'];
	
	include template('select');
}
elseif($act == 'post')
{
	$catid = intval($_REQUEST['id']);
	if(empty($catid)) {
		showmsg($L['f_select_category']);
	}

	$catinfo = get_cat_info($catid);
	if(empty($catinfo)) showmsg($L['category_does_not_exist']);
	$verf = get_one_ver();
	$member = member_info($_userid);
	$custom = cat_post_custom($catid);
	$seo['title'] = $L['adding_topic'] . ' - '. $CFG['webname']. '';
	$seo['keywords'] = $CFG['keywords'];
	$seo['description'] = $CFG['description'];
	$maxupload = $INF['maxupload'] * 1024;
	include template('post');
}
elseif($act == 'postok')
{
	$catid     = $_POST['catid'] ? intval($_POST['catid']) : '';
	$title     = $_POST['title'] ? htmlspecialchars(trim($_POST['title'])) : '';
	$areaid    = $_POST['areaid'] ? intval($_POST['areaid']) : '';
	$postdate  = time();
	$enddate   = $_POST['enddate']>0 ? (intval($_POST['enddate']*3600*24)) + time() : '0';
	$content   = $_POST['content'] ? htmlspecialchars(trim($_POST['content'])) : '';
	$keywords  = $_POST['keyword'] ? htmlspecialchars(trim($_POST['keyword'])) : '';
    $description = addslashes(get_intro($content, 200));
	$linkman   = $_POST['linkman'] ? htmlspecialchars(trim($_POST['linkman'])) : '';
	$phone     = $_POST['phone'] ? htmlspecialchars(trim($_POST['phone'])) : '';
	$icq        = $_POST['icq'] ? intval($_POST['icq']) : '';
	$email     = $_POST['email'] ? htmlspecialchars(trim($_POST['email'])) : '';
	$password  = $_POST['password'] ? trim($_POST['password']) : '';
	$address   = $_POST['address'] ? htmlspecialchars(trim($_POST['address'])) : '';
	$youtube   = $_POST['youtube'] ? htmlspecialchars(trim($_POST['youtube'])) : '';
	$price   = $_POST['price'] ? htmlspecialchars(trim($_POST['price'])) : '';
	$unit   = $_POST['unit'] ? htmlspecialchars(trim($_POST['unit'])) : '';
	$mappoint  = $_POST['mappoint'] ? trim($_POST['mappoint']) : '';
	$checkcode = $_POST['checkcode'] ? trim($_POST['checkcode']) : '';
	$number    = $_POST['number'] ? intval($_POST['number']) : '';
	$top_type  = $_POST['is_top'] ? intval($_POST['is_top']) : '';
	$is_top   = $_POST['is_top'] ? intval($_POST['is_top']) : '';
	$is_check  = $CFG['post_check'] == '1' ?  '0' : '1';
	$title = censor($title);
	$content = censor($content);

    if(empty($title)) showmsg($L['title_empty']);
	if($areaid<=0) showmsg($L['areaid_empty']);
	if(empty($_userid)) {
		if(empty($password)) showmsg($L['f_password_enter']);
	}
	if(empty($content))showmsg($L['content_empty']);
    if(empty($phone) && empty($icq) && empty($email))showmsg($L['enter_your_contact_details']);
	check_ver(intval($_REQUEST['vid']), htmlspecialchars($_REQUEST['answer']));
	
	$so = " ip = '$ip' ";
	if(!empty($phone))  $so .= " or phone = '$phone' ";
	if(!empty($icq))     $so .= " or icq = '$icq' ";
	if(!empty($email))  $so .= " or email = '$email' ";
	if(!empty($linkman))$so .= " or linkman = '$linkman' ";

	//ограничение кол-ва
	if(!empty($CFG['maxpost'])) {
		if($_userid) {
			$sql = "select count(*) from {$table}info where userid='$_userid' and postdate > " .mktime(0,0,0);
		} else {
			$sql = "select count(*) from {$table}info where postdate > " .mktime(0,0,0)." and ($so)";
		}
		if($db->getOne($sql) > $CFG['maxpost'])showmsg("".$L['max_number_per_day'].": $CFG[maxpost]");
	}
	
	//запрещаем повторную отправку с одинаковым названием
	if($_userid) {
		$sql = "select count(*) from {$table}info where title='$title' and userid='$_userid' and postdate > " .mktime(0,0,0);
	} else {
		$sql = "select count(*) from {$table}info where title='$title' and ($so) and postdate > " .mktime(0,0,0);
	}
	if($db->getOne($sql) > 0) showmsg($L['resending_same_data_prohibited']);
	
	$items = array(
		'userid' => $_userid,
		'catid'  => $catid,
		'areaid' => $areaid,
		'title'  => $title,
		'keywords' => $keywords,
		'description' => $description,
		'content' => $content,
		'linkman' => $linkman,
		'email' => $email,
		'icq' => $icq,
		'phone' => $phone,
		'password' => $password,
		'postarea' => $postarea,
		'postdate' => $postdate,
		'mappoint' => $mappoint,
		'address' => $address,
		'youtube' => $youtube,
		'price' => $price,
		'unit' => $unit,
		'enddate' => $enddate,
		'ip' => $ip,
		'is_check' => $is_check,
		'is_top' => $is_top,
		'top_type' => $top_type,
	);
	$id = addInfo($items, $_POST['cus_value']);
	foreach($_FILES as $key=>$val) {
		$alled = array('png','jpg','gif','jpeg');//типы
        $maxsize = $INF['maxupload'] * 1024;//макс. размер загружаемых файлов в kb
		//предварительно проверяем
		$exname = strtolower(trim(substr(strrchr($val['name'], '.'), 1)));
		if(!checkupfile($val['tmp_name']) || !($val['tmp_name'] != 'none' && $val['tmp_name'] && $val['name']) || $val['size']>$maxsize || !in_array($exname,$alled)){
			continue;
		}
		$name = date('ymdhis');
		for($a = 0;$a < 6;$a++){ $name .= chr(mt_rand(97, 122));}
		$thumb_name = $name.'_thumb'. '.' . end(explode('.', $val['name']));
		$name .= '.' . end(explode('.', $val['name']));
		
		$dir = AWEBCOM_ROOT . 'data/infoimage/' . date('ymd');
		if(!is_dir($dir)) {
			if(@mkdir(rtrim($dir,'/'), 0777))@chmod($dir, 0777);
		}
		$to = $dir.'/'. $name;

		if(move_uploaded_file($val['tmp_name'], $to)) {
			$image = 'data/infoimage/' . date('ymd').'/'. $name;
			@chmod(AWEBCOM_ROOT.$image, 0777);
			$db->query("INSERT INTO {$table}info_image (infoid,path) VALUES ('$id','$image')");
		}
		if(!$do) {
			$thumbimg = 'data/infoimage/' . date('ymd').'/'.$thumb_name;
			$thumb = CreateSmallImage( $image, $thumbimg, 154, 134);
			@chmod(AWEBCOM_ROOT.$thumbimg, 0777);
			$db->query("UPDATE {$table}info SET thumb='$thumbimg' WHERE id='$id' ");
			$do = true;
		}
	}

	// добавление баллов
	if($_username) {
	    $memo = $L['for_adding_topic'];
		$credit_count = $db->getOne("select count(*) from {$table}pay_exchange where username='$_username' and addtime>".mktime(0,0,0)." and note='$memo' ");
		if($credit_count < $CFG['max_info_credit']) {
			if(!empty($CFG['post_info_credit'])) credit_add($_username, $CFG['post_info_credit'], $L['for_adding_topic']);
		}
		$query = $db->query("UPDATE {$table}member SET lastposttime=".time()." WHERE userid='$_userid' ");
	}

	//cookie
	setcookie('lastposttime', time(), time()+86400*24);
	$url = url_rewrite('view', array('vid'=>$id));
	$seo['title'] = $L['f_my_added_listing'] . ' - '. $CFG['webname']. '';
	$seo['keywords'] = $CFG['keywords'];
	$seo['description'] = $CFG['description'];
	
	
//начало отправки письма добавления объявления
include_once AWEBCOM_ROOT . 'include/cont.phpmailer.php';
$mail             = new PHPMailer();
$body             = "".$L['added_listing_id']." $id<br>".$L['added_listing_id_body'].": <a href=\"$CFG[weburl]/admin/info.php\" target=\"_blank\">".$L['verify']."</a>";
$body = stripslashes($body);
$mail->IsMail(); 
$mail->From       = "$CFG[noreplymail]";
$mail->FromName   = "".$L['system_message']."";
$mail->Subject    = "".$L['added_listing_id_title']." $CFG[webname]";
$mail->MsgHTML($body);
$mail->AddAddress("$CFG[sysmail]", "".$L['administration']."");
$mail->Send(); 
//конец отправки письма добавления объявления
	
	include template('post_ok');
}
?>