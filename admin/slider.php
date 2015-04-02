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
chkadmin('slider');
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
$nav = 'options';
$navig = 'slider';
switch ($_REQUEST['act'])
{
	case 'list':
		$sql = "SELECT * FROM {$table}slider ORDER BY id DESC";
		$res = $db->query($sql);
		$slider = array();
		while($row = $db->fetchRow($res)) {
			$slider[]      = $row;
		}
		include tpl('list_slider');
	break;

	case 'add':
		$maxorder = $db->getOne("SELECT MAX(flaorder) FROM {$table}slider");
		$maxorder = $maxorder + 1;
		include tpl('add_slider');
	break;

	case 'insert':
		if(empty($_REQUEST['url']))show($L['enter_url']);
		if(empty($_FILES['file']['name']))
        {
			show($L['add_upload_image_not']);
		}

		else
		{	
			$alled = array('png','jpg','gif','jpeg');
            $maxsize = '523298';
			$exname = strtolower(trim(substr(strrchr($_FILES['file']['name'], '.'), 1)));
		    if($_FILES['file']['size']>$maxsize)show("".$L['max_file_size_error']." $maxsize ".$L['byte']."");
		   if(checkupfile($_FILES['file']['name']) && ($_FILES['file']['name'] != 'none' && $_FILES['file']['name'] ) || $_FILES['file']['size']<$maxsize && in_array($exname,$alled)){
				
				$name = date('Ymd');
				for($i = 0;$i < 6;$i++) {
					$name .= chr(mt_rand(97, 122));
				}
				$name .= '.' . end(explode('.', $_FILES['file']['name']));
				$to    = AWEBCOM_ROOT . 'data/sliderimage/' . $name;

				if (move_uploaded_file($_FILES['file']['tmp_name'], $to)){
					$image = "data/sliderimage/" . $name;
				}
			} else {
				show($L['invalid_image_format']);
			}
        }
		$url = trim($_REQUEST['url']);
		$texts = htmlspecialchars(trim($_REQUEST['texts']));
		$flaorder = intval($_REQUEST['flaorder']);
		$sql = "INSERT INTO {$table}slider (image,url,texts,flaorder) VALUES ('$image','$url','$texts','$flaorder');";
		$res = $db->query($sql);
		$res ? $msg = $L['slider_added'] : $msg = $L['slider_not_added'];
		clear_caches('phpcache', 'slider');

		admin_log("".$L['slider_added_log']." $name");
		show($msg, 'slider.php');
	break;
	
	case 'edit':
		$id  = intval($_REQUEST['id']);
		$sql = "SELECT * FROM {$table}slider WHERE id = '$id' ";
		$slider = $db->getRow($sql);
		include tpl('edit_slider');
	break;

	case 'update':
		if(empty($_REQUEST['url']))show($L['enter_url']);
		if(empty($_FILES['file']['name']) && empty($_REQUEST['fileurl'])) {
			show($L['add_upload_image_not']);
		}
		
		if(!empty($_FILES['file']['name'])) {

			$alled = array('png','jpg','gif','jpeg');
            $maxsize = '523298';
			$exname = strtolower(trim(substr(strrchr($_FILES['file']['name'], '.'), 1)));
		    if($_FILES['file']['size']>$maxsize)show("".$L['max_file_size_error']." $maxsize ".$L['byte']."");
			if(checkupfile($_FILES['file']['name']) && ($_FILES['file']['name'] != 'none' && $_FILES['file']['name'] ) || $_FILES['file']['size']<$maxsize && in_array($exname,$alled)){

				$name = date('Ymd');
				for($i = 0;$i < 6;$i++) {
					$name .= chr(mt_rand(97, 122));
				}
				$name .= '.' . end(explode('.', $_FILES['file']['name']));
				$to    = AWEBCOM_ROOT . 'data/sliderimage/' . $name;

				if (move_uploaded_file($_FILES['file']['tmp_name'], $to)){
					$image = "data/sliderimage/" . $name;
				}
				if($_REQUEST['fileurl'] != '' && is_file('../'.$_REQUEST['fileurl'])) {
					@unlink('../'.$_REQUEST['fileurl']);
				}
			} else {
				show($L['invalid_image_format']);
			}
        }else{
			$image = $_REQUEST['fileurl'];
		}

		$url = trim($_REQUEST['url']);
		$texts = htmlspecialchars(trim($_REQUEST['texts']));
		$flaorder = intval($_REQUEST['flaorder']);
		$id  = intval($_REQUEST['id']);
		$sql = "UPDATE {$table}slider SET image='$image',url='$url',texts='$texts',flaorder='$flaorder' WHERE id = '$id' ";
		$res = $db->query($sql);
		$res ? $msg = $L['slider_changed'] : $msg = $L['slider_not_changed'];
		clear_caches('phpcache', 'slider');

		admin_log("".$L['slider_changed_log']." $image");
		show($msg, 'slider.php?act=list');
	break;

	case 'delete':
		$id = intval($_REQUEST['id']);
		if(empty($id))show($L['a_parameter_error']);
		$sql = "SELECT image FROM {$table}slider WHERE id='$id' ";
		$image = $db->getOne($sql);
		if($image != '' && is_file(AWEBCOM_ROOT.$image)) {
			@unlink(AWEBCOM_ROOT.$image);
		}
		$sql = "DELETE FROM {$table}slider WHERE id='$id'";
	    $res = $db->query($sql);
		$res ? $msg = $L['slider_delete'] : $msg = $L['slider_not_delete'];
		clear_caches('phpcache', 'slider');
		admin_log("".$L['slider_delete_log']." $name");
		show($L['slider_delete'], 'slider.php?act=list');
	break;
	default:
	show($L['a_invalid_request'], './');
	break;
}
?>