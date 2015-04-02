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
chkadmin('ads');
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
$nav = 'options';
$navig = 'ads';
$type = array('1'=>$L['text'],$L['image'],'Flash',$L['code']);
$sql = "SELECT * FROM {$table}ads_place";
$ads_place = $db->getAll($sql);

switch ($_REQUEST['act'])
{
	case 'list':
		$res = $db->query("SELECT a.*,p.placename FROM {$table}ads AS a LEFT JOIN {$table}ads_place AS p ON p.placeid = a.placeid ");
		$ads = array();
		while($row = $db->fetchRow($res)) {
			$row['adstype']  = $type[$row['adstype']];
			$row['addtime']  = date('Y-m-d',$row['addtime']);
			$ads[] = $row;
		}
	    include tpl('list_ads');
	break;

	case 'add':
		include tpl('add_ads');
	break;

	case 'insert':
		if(empty($_POST['placeid']))show($L['select_block_adv']);
		if(empty($_POST['adstype']))show($L['select_type_adv']);
		if(empty($_POST['adsname']))show($L['enter_name']);

		$placeid = intval($_POST['placeid']);
		$adstype = intval($_POST['adstype']);
		$adsname = trim($_POST['adsname']);

		if($adstype != '3' || $adstype!='4')$adsurl = !empty($_POST['adsurl']) ? trim($_POST['adsurl']) : '';

		$sql = "SELECT COUNT(*) FROM {$table}ads WHERE adsname = '$adsname'";
		if( $db->getOne($sql))show($L['same_name_already_exists']);

		if($adstype == '1')
		{
			if (!empty($_POST['adscontent']))
			{
				$adscode = trim($_POST['adscontent']);
			}
			else
			{
				show($L['enter_text_adv']);
			}
		}
		elseif($adstype == '2')
		{
			if((isset($_FILES['image']['error']) && $_FILES['image']['error'] == 0) || (!isset($_FILES['image']['error']) && isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != 'none'))
			{
				$name = date('ymdhis');
				for($i = 0;$i < 6;$i++) 
				{
					$name .= chr(mt_rand(97, 122));
				}
				$name .= '.' . end(explode('.', $_FILES['image']['name']));
				$to = AWEBCOM_ROOT . 'data/ads/' . $name;
				if(move_uploaded_file($_FILES['image']['tmp_name'], $to))
				{
					$adscode = "data/ads/" . $name;
				}
				else
				{
					show($L['could_not_load_image']);
				}
			}
			if(!empty($_POST['imageurl']))
			{
				$adscode = $_POST['imageurl'];
			}
			if((isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] == 'none') && empty($_POST['imageurl']))
			{
				show($L['enter_url_to_image']);
			}
		}
		elseif ($adstype == '3')
		{
			if ((isset($_FILES['flash']['error']) && $_FILES['flash']['error'] == 0) || (!isset($_FILES['flash']['error']) && isset($_FILES['image']['tmp_name']) && $_FILES['flash']['tmp_name'] != 'none'))
			{
				if ($_FILES['flash']['type'] != "application/x-shockwave-flash")
				{
					show($L['this_is_not_flash_movie']);
				}

				$urlstr = date('ymdhis');
				for($i = 0; $i < 6; $i++)
				{
					$urlstr .= chr(mt_rand(97, 122));
				}

				$source_file = $_FILES['flash']['tmp_name'];
				$target = AWEBCOM_ROOT . 'data/ads/';
				$file_name = $urlstr .'.swf';

				if(move_uploaded_file($source_file, $target.$file_name))
				{
					$adscode = "data/ads/" . $file_name;
				}
				else
				{
					show($L['could_not_load_flash_movie']);
				}
			}
			elseif(!empty($_POST['flashurl']))
			{
				if (substr(strtolower($_POST['flashurl']), strlen($_POST['flashurl']) - 4) != '.swf')
				{
					show($L['enter_url_to_flash_movie']);
				}
				$adscode = trim($_POST['flashurl']);
			}

			if (((isset($_FILES['flash']['error']) && $_FILES['flash']['error'] > 0) || (!isset($_FILES['flash']['error']) && isset($_FILES['flash']['tmp_name']) && $_FILES['flash']['tmp_name'] == 'none')) && empty($_POST['flashurl']))
			{
				show($L['could_not_load_flash_movie']);
			}
		}
		elseif ($adstype== '4')
		{
			if (!empty($_POST['adscode']))
			{
				$adscode = $_POST['adscode'];
			}
			else
			{
				show($L['enter_code_adv']);
			}
		}
		
		$addtime = time();
		$sql = "INSERT INTO {$table}ads (placeid,adstype,adsname,adsurl,adscode,addtime,linkman) VALUES ('$placeid','$adstype','$adsname','$adsurl','$adscode','$addtime','$_POST[postman]')";
		$db->query($sql);

		admin_log("".$L['adv_added_log']." $adsname");
		$link = 'ads.php';
		show($L['done'], $link);
	break;
	
	case 'edit':
		$id = intval($_REQUEST['id']);
		$sql = "SELECT * FROM {$table}ads WHERE adsid = '$id'"; 
		$ads = $db->getRow($sql);
		include tpl('edit_ads');
	break;

	case 'update':
		if(empty($_POST['placeid']))show($L['select_block_adv']);
		if(empty($_POST['adsname']))show($L['enter_name']);
		
		$adsid   = intval($_REQUEST['adsid']);
		$placeid = intval($_REQUEST['placeid']);
		$adstype = intval($_REQUEST['adstype']);
		$adsname = trim($_REQUEST['adsname']);

		if($adstype != '4')$adsurl = !empty($_POST['adsurl']) ? trim($_POST['adsurl']) : '';
		
		$sql = "select adscode from {$table}ads where adsid='$adsid' ";
		$adscode = $db->getOne($sql);

		if($adstype == '1')
		{
			if (!empty($_POST['adscontent']))
			{
				$adscode = trim($_POST['adscontent']);
			}
			else
			{
				show($L['enter_text_adv']);
			}
		}
		elseif($adstype == '2')
		{
			if((isset($_FILES['image']['error']) && $_FILES['image']['error'] == 0) || (!isset($_FILES['image']['error']) && isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != 'none'))
			{
				$name = date('ymdhis');
				for($i = 0;$i < 6;$i++) 
				{
					$name .= chr(mt_rand(97, 122));
				}
				$name .= '.' . end(explode('.', $_FILES['image']['name']));
				$to = AWEBCOM_ROOT . 'data/ads/' . $name;
				if(move_uploaded_file($_FILES['image']['tmp_name'], $to))
				{
					if((strpos($adscode, 'http://') === false) && (strpos($adscode, 'https://') === false))
					{
						$img_name = basename($img);
						@unlink(AWEBCOM_ROOT.'data/ads/'.$img_name);
					}
					$adscode = "data/ads/" . $name;
				}
				else
				{
					show($L['could_not_load_image']);
				}
			}
			if(!empty($_POST['imageurl']))
			{
				$adscode = $_POST['imageurl'];
			}
			if((isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] == 'none') && empty($_POST['imageurl']))
			{
				show($L['enter_url_to_image']);
			}
		}
		elseif ($adstype == '3')
		{
			if ((isset($_FILES['flash']['error']) && $_FILES['flash']['error'] == 0) || (!isset($_FILES['flash']['error']) && isset($_FILES['image']['tmp_name']) && $_FILES['flash']['tmp_name'] != 'none'))
			{
				if ($_FILES['flash']['type'] != "application/x-shockwave-flash")
				{
					show($L['could_not_load_flash_movie']);
				}

				$urlstr = date('ymdhis');
				for($i = 0; $i < 6; $i++)
				{
					$urlstr .= chr(mt_rand(97, 122));
				}

				$source_file = $_FILES['flash']['tmp_name'];
				$target = AWEBCOM_ROOT . 'data/ads/';
				$file_name = $urlstr .'.swf';

				if(move_uploaded_file($source_file, $target.$file_name))
				{
					if((strpos($adscode, 'http://') === false) && (strpos($adscode, 'https://') === false))
					{
						$img_name = basename($img);
						@unlink(AWEBCOM_ROOT.'data/ads/'.$img_name);
					}
					$adscode = $file_name;
				}
				else
				{
					show($L['could_not_load_flash_movie']);
				}
			}
			elseif(!empty($_POST['flashurl']))
			{
				if (substr(strtolower($_POST['flashurl']), strlen($_POST['flashurl']) - 4) != '.swf')
				{
					show($L['enter_url_to_flash_movie']);
				}
				$adscode = trim($_POST['flashurl']);
			}

			if (((isset($_FILES['flash']['error']) && $_FILES['flash']['error'] > 0) || (!isset($_FILES['flash']['error']) && isset($_FILES['flash']['tmp_name']) && $_FILES['flash']['tmp_name'] == 'none')) && empty($_POST['flashurl']))
			{
				show($L['could_not_load_flash_movie']);
			}
		}
		elseif ($adstype== '4')
		{
			if (!empty($_POST['adscode']))
			{
				$adscode = $_POST['adscode'];
			}
			else
			{
				show($L['enter_code_adv']);
			}
		}
		$updatetime = time();
		
		$sql = "UPDATE {$table}ads SET placeid = '$placeid', adsname = '$adsname', adsurl = '$adsurl',adscode='$adscode',updatetime='$updatetime',linkman='$_POST[linkman]' WHERE adsid = '$adsid'";
		$db->query($sql);
		
		admin_log("".$L['adv_changed_log']." $adsname");
		$link = 'ads.php?act=list';
		show($L['done'], $link);
	break;

	case 'batch':
		$id = is_array($_REQUEST['id']) ? join(',',$_REQUEST['id']) : intval($_REQUEST['id']);
		if(empty($id))show($L['choice_records']);
		$sql = "SELECT * FROM {$table}ads WHERE adsid in ($id)";
		$ads = $db->getAll($sql);
		
		foreach((array)$ads as $ad) {
			if($ads[adstype]==2 && $ads['adscode']!='' && is_file(AWEBCOM_ROOT.'/data/ads/'.$ads['adscode'])) {
				@unlink('../'.$ads['adscode']);
			}
		}
		$sql = "DELETE FROM {$table}ads WHERE adsid in ($id)";
	    $res = $db->query($sql);

		admin_log("".$L['adv_delete_log']." $id");
		$link = 'ads.php?act=list';
		show($L['done'], $link);
	break;
	default:
	show($L['a_invalid_request'], './');
	break;
}
?>