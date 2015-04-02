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
require dirname(__FILE__) . '/include/pay.fun.php';
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : '' ;
switch($_REQUEST['act'])
{
	case 'small_map':
		if(isset($_GET['p']) && preg_match("/^[a-z0-9\-\.]+[,][a-z0-9\-\.]+$/", $_GET['p'])) {
			list($_GET['p1'], $_GET['p2']) = explode(',', $_GET['p']);
		}
		$mark = $_GET['mark'] ? 1 : 0;
		$title = $_GET['title'];
		include template('map');
	break;
	
	case 'big_map':
		$mappoint = $_GET['mappoint'];
		$address = $_GET['address'];
		$title = $_GET['title'];
		include template('big_map');
	break;

	case 'show':
		$out   = decrypt($_REQUEST['num'], $CFG['crypt']);
		$hight = strlen($out)*10;
		$image = imagecreate($hight, 20);
		$bg    = imagecolorallocate($image, 255, 255, 255);
		$textcolor = imagecolorallocate($image, 55, 55, 55);
		imagestring($image, 5, 0, 3, $out, $textcolor);
		header("Content-type: image/png");
		imagepng($image);
	break;

	case 'chkcode':
		$_SESSION["chkcode"] = "";
		$chkcode = chkcode();
		$_SESSION["chkcode"] = $chkcode;
	break;

	case 'checkcode':
		$json = new Services_JSON;
		$chkcode = $_SESSION["chkcode"];
		$checkcode = trim($_REQUEST['checkcode']);
		if(empty($chkcode) || $chkcode != $checkcode) {
			echo $json->encode('0');
			exit;
		} else {
			echo $json->encode('1');
			exit;
		}
	break;

	case 'ver':
		require AWEBCOM_ROOT . 'include/json.class.php';
		//$answer = iconv('windows-1251', 'utf8', trim($_REQUEST['answer']));
		$answer = trim($_REQUEST['answer']);
		$vid = intval($_REQUEST['vid']);
		$ver = get_ver();
		$verf = $ver[$vid];
		$a = $answer == $verf['answer'] ? true : false;
		$json = new Services_JSON;
		echo $json->encode($a);
		exit;
	break;
	default:
	showmsg($L['invalid_request'], 'index.php');
	break;
}
?>