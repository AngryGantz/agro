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
if(empty($CFG['mailspam']))showmsg($L['option_disabled'], 'index.php');
        $act = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'index' ;
		
		switch($act)
		{

	case 'index':
		$member = member_info($_userid);
		$membermail = $member['email'];
		$membersurname = $member['surname'];
		$verf = get_one_ver();
        $CFG['mailspam'] = empty($CFG['mailspam'])? '' : '<img src="do.php?act=show&num='.encrypt($CFG['mailspam'],	$CFG['crypt']).'" align="absmiddle">';
		$seo['title'] = $L['f_contacts'] . ' - '. $CFG['webname']. '';
		$seo['keywords'] = $CFG['keywords'];
		$seo['description'] = $CFG['description'];
		include template('cont');
	break;
	
	case 'cont':
		if($_POST) 
		{
	    $surname   = $_POST['surname'] ? htmlspecialchars(trim($_POST['surname'])) : '';
	    $membermail   = $_POST['membermail'] ? htmlspecialchars(trim($_POST['membermail'])) : '';
	    $title   = $_POST['title'] ? htmlspecialchars(trim($_POST['title'])) : '';
	    $content   = $_POST['content'] ? htmlspecialchars(trim($_POST['content'])) : '';
	    $answer   = $_POST['answer'] ? htmlspecialchars(trim($_POST['answer'])) : '';
		
		if(empty($surname))showmsg($L['enter_your_name']);
		if(empty($membermail))showmsg($L['email_empty']);
		if(empty($title))showmsg($L['enter_theme']);
		if(empty($content))showmsg($L['enter_content_message']);
		if(empty($answer))showmsg($L['f_enter_answer_question']);
		check_ver(intval($_REQUEST['vid']), trim($_REQUEST['answer']));
		include AWEBCOM_ROOT.'include/cont.phpmailer.php';
		
        $content = "$content<br/>".$L['message_sent_from_site'].": <a href=\"$CFG[weburl]\" target=\"_blank\">".$CFG['webname']."</a>";
		$mail             = new PHPMailer();
		$body             = "$content";
		$body = stripslashes($body);
		$mail->IsMail(); 
		$mail->From       = "$membermail";
		$mail->FromName   = "$surname";
		$mail->Subject    = "$title";
		$mail->MsgHTML($body);
		$mail->AddAddress("$CFG[sysmail]", "".$L['administration']."");
		if ($mail->Send() ) {
			showmsg($L['message_sent_successfully'] , './');
		} else {
			showmsg($L['failed_send_message'], $_SERVER['HTTP_REFERER']);
		}
		
		}
		
	break;

	default:
	showmsg($L['invalid_request'], 'index.php');
	break;
}
?>