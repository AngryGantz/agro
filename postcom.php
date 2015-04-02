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
require dirname(__FILE__) . '/include/com.fun.php';
require AWEBCOM_ROOT . 'include/json.class.php';

$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'select' ;

if(!$_userid) {
	showmsg($L['company_can_add_only_registered'], 'member.php?act=login&refer='.$PHP_URL);
} else {
	$member = member_info($_userid);
	if($member['status']!=1) showmsg($L['account_moderation_or_blocked']);
}
$ip = get_ip();

if($_REQUEST['act'] == 'select')
{
	$seo['title'] = $L['select_category'] . ' - '. $CFG['webname']. '';
	$seo['keywords'] = $CFG['keywords'];
	$seo['description'] = $CFG['description'];
	$cats = get_com_cat_list();
	include template('com_select','com');
}
elseif($_REQUEST['act'] == 'post')
{
	$catid = intval($_REQUEST['id']);
	if(empty($catid)) {
		showmsg($L['f_select_category']);
	}
	$com_catinfo = get_com_cat_info($catid);
	if(empty($com_catinfo))showmsg($L['category_does_not_exist']);

	$seo['title'] = $L['f_add_company_go'] . ' - '. $CFG['webname']. '';
	$seo['keywords'] = $CFG['keywords'];
	$seo['description'] = $CFG['description'];
	$maxupload = $INF['maxupload'] * 1024;
	include template('com_post','com');
}
elseif($_REQUEST['act'] == 'postok')
{
	$catid     = $_POST['catid'] ? intval($_POST['catid']) : '';
	$comname   = $_POST['comname'] ? htmlspecialchars(trim($_POST['comname'])) : '';
	$areaid    = $_POST['areaid'] ? intval($_POST['areaid']) : '';
	$postdate  = time();
	$introduce = $_POST['content'] ? htmlspecialchars(trim($_POST['content'])) : '';;
	$hours     = $_POST['hours'] ? htmlspecialchars(trim($_POST['hours'])) : '';
	$keywords  = $_POST['keywords'] ? htmlspecialchars(trim($_POST['keywords'])) : '';
    $description = addslashes(get_intro($introduce, 200));
	$linkman   = $_POST['linkman'] ? htmlspecialchars(trim($_POST['linkman'])) : '';
	$phone     = $_POST['phone'] ? trim($_POST['phone']) : '';
	$icq        = $_POST['icq'] ? intval($_POST['icq']) : '';
	$email     = $_POST['email'] ? htmlspecialchars(trim($_POST['email'])) : '';
	$fax       = $_POST['address'] ? trim($_POST['fax']) : '';
	$address   = $_POST['address'] ? trim($_POST['address']) : '';
	$mappoint  = $_POST['mappoint'] ? trim($_POST['mappoint']) : '';
	$is_check  = $CFG['post_check'] == '1' ?  '0' : '1';
	
    if(empty($comname))showmsg($L['company_name_empty']);
	if($areaid<=0) showmsg($L['areaid_empty']);
	if(empty($introduce))showmsg($L['company_introduce_empty']);
    if(empty($phone) && empty($icq) && empty($email))showmsg($L['enter_your_contact_details']);
	check_words(array($comname, $introduce));
	
    $sql = "insert into {$table}com (userid,catid,areaid,comname,keywords,description,introduce,linkman,email,fax,icq,phone,postdate,mappoint,address,hours,is_check) 
	values ('$_userid','$catid','$areaid','$comname','$keywords','$description','$introduce','$linkman','$email','$fax','$icq','$phone','$postdate','$mappoint','$address','$hours',$is_check)";
    $res = $db->query($sql);
	$id = $db->insert_id();
	
	$alled = array('png','jpg','gif','jpeg');
	$exname = strtolower(trim(substr(strrchr($_FILES['thumb']['name'], '.'), 1)));
	if(checkupfile($_FILES['thumb']['tmp_name']) && $_FILES['thumb']['tmp_name'] != 'none' && $_FILES['thumb']['tmp_name'] && $_FILES['thumb']['name'] && $_FILES['thumb']['size']<'523298' && in_array($exname,$alled)) {

		$thumb_name = $id.'_thumb'. '.' . end(explode('.', $_FILES['thumb']['name']));
		$dir = AWEBCOM_ROOT . 'data/com/thumb';
		if(!is_dir($dir)) {
			if(@mkdir(rtrim($dir,'/'), 0777))@chmod($dir, 0777);
		}
		$to = $dir.'/'. $thumb_name;
		CreateSmallImage($_FILES['thumb']['tmp_name'], $to, $CFG['com_thumbwidth'], $CFG['com_thumbheight']);
		$image = 'data/com/thumb/'. $thumb_name;
		$db->query("update {$table}com set thumb='$image' where comid='$id' ");
	}

	//Изображения
	$count = count($_FILES)-1;
	for($i=1;$i<=$count;$i++)
	{
		$exname = strtolower(trim(substr(strrchr($_FILES['file'. $i]['name'], '.'), 1)));
		if(!checkupfile($_FILES['file'. $i]['tmp_name']) || !($_FILES['file'. $i]['tmp_name'] != 'none' && $_FILES['file'. $i]['tmp_name'] && $_FILES['file'. $i]['name']) || $_FILES['file'. $i]['size']>'523298' || !in_array($exname,$alled)) {
			continue;
		}
		$name = date('ymdhis');
		for($a = 0;$a < 6;$a++){ $name .= chr(mt_rand(97, 122));}
		$name .= '.' . end(explode('.', $_FILES['file'. $i]['name']));
		$dir = AWEBCOM_ROOT . 'data/com/' . date('ymd');
		if(!is_dir($dir)) {
			if(@mkdir(rtrim($dir,'/'), 0777))@chmod($dir, 0777);
		}
		$to = $dir.'/'. $name;
		if(move_uploaded_file($_FILES['file'. $i]['tmp_name'], $to)) {
			$image = 'data/com/' . date('ymd').'/'. $name;
			$db->query("INSERT INTO {$table}com_image (comid,path) VALUES ('$id','$image')");
		}
	}
		
	// Прайслист
	$alled2 = array('zip','7z','rar','xls');
	$count = count($_FILES)-1;
	for($i=1;$i<=$count;$i++)
	{
		$exname = strtolower(trim(substr(strrchr($_FILES['file'. $i]['name'], '.'), 1)));
		if(!checkupfile($_FILES['file'. $i]['tmp_name']) || !($_FILES['file'. $i]['tmp_name'] != 'none' && $_FILES['file'. $i]['tmp_name'] && $_FILES['file'. $i]['name']) || !in_array($exname,$alled2)) {
			continue;
		}
		$name = date('ymdhis');
		for($a = 0;$a < 7;$a++){ $name .= chr(mt_rand(97, 122));}
		$name .= '.' . end(explode('.', $_FILES['file'. $i]['name']));
		$dir = AWEBCOM_ROOT . 'data/pricelist/' . date('ymd');
		if(!is_dir($dir)) {
			if(@mkdir(rtrim($dir,'/'), 0777))@chmod($dir, 0777);
		}
		$to = $dir.'/'. $name;
		if(move_uploaded_file($_FILES['file'. $i]['tmp_name'], $to)) {
			$pricelist = 'data/pricelist/' . date('ymd').'/'. $name;
			$db->query("update {$table}com set pricelist='$pricelist' where comid='$id' ");
		}
	}


//начало отправки письма добавления компании
include_once AWEBCOM_ROOT . 'include/cont.phpmailer.php';
$mail             = new PHPMailer();
$body             = "".$L['added_company_id']." $id<br>".$L['added_company_id_body'].": <a href=\"$CFG[weburl]/admin/com.php\" target=\"_blank\">".$L['verify']."</a>";
$body = stripslashes($body);
$mail->IsMail(); 
$mail->From       = "$CFG[noreplymail]";
$mail->FromName   = "".$L['system_message']."";
$mail->Subject    = "".$L['added_company_id_title']." $CFG[webname]";
$mail->MsgHTML($body);
$mail->AddAddress("$CFG[sysmail]", "".$L['administration']."");
$mail->Send(); 
//конец отправки письма добавления компании
	
	$url = url_rewrite('com',array('act'=>'view', 'comid'=>$id));
	showmsg($L['f_my_added_successfully_company'],'member.php?act=com');
}
?>