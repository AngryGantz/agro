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
$act = $_REQUEST['act'] ? $_REQUEST['act'] : 'list' ;
if($act=='list')
{
	$catid = $_REQUEST['catid'] ? intval($_REQUEST['catid']) : '';
	$areaid = $_REQUEST['area'] ? intval($_REQUEST['area']) : '';
	$page = $_REQUEST['page'] ? intval($_REQUEST['page']) : '1';

	$com_cats = get_com_cat_list();/* список категорий */
	if($catid) {
		$com_cat_info = get_com_cat_info($catid);
		if(empty($com_cat_info['parentid'])) {
			$cats = get_com_cat_children($catid);
			if(empty($cats))$cats=$catid;
		} else {
			$cats = $catid;
		}
		$cat_sql = " and catid in ($cats) ";
	}
	if(!$areaid) {
		$area_row = get_parent_area();
		if(!empty($area_row)) {
			$area_arr = array();
			foreach($area_row as $val) {
				$val['areaname'] = $val['areaname'];
				$val['url'] = url_rewrite('com', array('act'=>'list', 'catid'=>$catid,'eid'=>$val['areaid']));
				$area_arr[] = $val;
			}
		}
	} else {
		$area_info = get_area_info($areaid);
		$area_parent = $area_info['parentid'];

		if(empty($area_parent)) {
			$area_row = get_area_children($areaid,'array');
			if(!empty($area_row)) {
				$area_arr = array();
				foreach($area_row as $val) {
					$val['areaname'] = $val['name'];
					$val['url'] = url_rewrite('com',array('act'=>'list', 'catid'=>$catid,'eid'=>$val['id']));
					$area_arr[] = $val;
				}
				$areas = get_cat_children($areaid);
			}
			if(empty($areas))$areas = $areaid;
		} else {
			$areas = $areaid;
		}
		$area_sql = " and areaid in ($areas) ";
	}
	$area_array = get_area_array();
	$cat_array = get_cat_array();
	$sql = "SELECT COUNT(*) FROM {$table}com as i WHERE is_check=1 $cat_sql $area_sql";
	$count = $db->getOne($sql);
	$size = $CFG['com_pagesize'] ? $CFG['com_pagesize'] : 10;
	$pager = page('com',$catid,$areaid,$count,$size,$page);
	$sql = "SELECT * FROM {$table}com WHERE is_check=1 $cat_sql $area_sql ORDER BY postdate DESC limit $pager[start],$pager[size]";
	$res = $db->query($sql);
	$articles = array();
	while($row=$db->fetchRow($res)) {
		$row['sname']      = cut_str($row['comname'],18);
		$row['postdate']   = date('Y-m-d-H-i', $row['postdate']);
		$row['thumb']      = AWEBCOM_PATH.$row['thumb'];
		$row['introduce']  = cut_str($row['introduce'],200);
		$row['areaname']   = $area_array[$row['areaid']];
		$row['catname']    = $cat_array[$row['catid']];
		$row['url']        = url_rewrite('com',array('act'=>'view','comid'=>$row['comid']));
		$articles[] = $row;
	}

	if(empty($com_cat_info) && empty($area_info)) {
		$here_arr[] = array('name'=> $L['f_company']);
	} elseif(empty($com_cat_info) && !empty($area_info)) {
		$here_arr[] = array('name'=> $L['f_company'],'url'=>url_rewrite('com', array('act'=>'list', 'catid'=>$catid)));
	} else {
		$here_arr[] = array('name'=>$com_cat_info['catname'],'url'=>url_rewrite('com', array('act'=>'list', 'catid'=>$catid)));
	}

	$here_arr[] = array('name'=>$area_info['areaname'],'url'=>url_rewrite('com', array('act'=>'list', 'eid'=>$areaid)));
	$here = get_here($here_arr);
    $seo['title'] = $area_info['areaname'] . '  ' .$com_cat_info['catname']. ' - '.$L['f_company'].' - '.$CFG['webname'].'';
	$seo['keywords'] = $area_info['areaname'].$com_cat_info['keywords'];
	$seo['description'] = $com_cat_info['description'];

	include template('com_list');
}
elseif($act=='view')
{
	$comid = intval($_REQUEST['id']);
	if(empty($comid)) showmsg($L['invalid_request']);
	$com_info = $db->getRow("select * from {$table}com where comid='$comid' ");
	if(empty($com_info)) showmsg($L['company_does_not_exist'],'index.php');
	$com_info['mappoint'] = strip_tags($com_info['mappoint']);
	// unset($com_info['userid']);
	extract($com_info);
	if(!$is_check)showmsg($L['this_company_verification']);
	$area_array = get_area_array();	
	$areaname = $area_array[$areaid];
	$introduce = nl2br(htmlspecialchars($introduce));
	$postdate = date('Y-m-d-H-i', $postdate);
    $mappoint = trim($mappoint);
	$phone = empty($phone) ? '' : '<img src="do.php?act=show&num='.encrypt($phone, $CFG['crypt']).'" align="absmiddle">';
	$email = empty($email)? '' : '<img src="do.php?act=show&num='.encrypt($email,	$CFG['crypt']).'" align="absmiddle">';
	$icq = empty($icq)? '' : '<img src="do.php?act=show&num='.encrypt($icq, $CFG['crypt']).'" align="absmiddle">';
	
	
	$thumb = AWEBCOM_PATH.$thumb;
	$res = $db->query("select * from {$table}com_image where comid='$comid' ");
	$com_images = array();
	while($row=$db->fetchRow($res)) {
		$row['path'] = AWEBCOM_PATH . $row['path'];
		$com_images[] = $row;
	}
	$db->query("UPDATE {$table}com SET click=click+1 WHERE comid='$comid'");
	
	$res = $db->query("select comid,comname,thumb,postdate from {$table}com order by comid desc,click desc limit 8");
	$match_com = array();
	while($row=$db->fetchrow($res)) {
		$row['sname'] = cut_str($row['comname'],18);
		$row['postdate'] = date('Y-m-d-H-i', $row['postdate']);
		$row['url'] = url_rewrite('com', array('act'=>'view', 'comid'=>$row['comid']));
		$row['mappoint'] = strip_tags($row['mappoint']);
		$match_com[] = $row;
	}
	$cat_info = get_com_cat_info($catid);
	$here_arr[] = array('name'=>$cat_info['catname'],'url'=>url_rewrite('com',array('act'=>'list','catid'=>$catid)));
	$here_arr[] = array('name'=>$comname);
	$here = get_here($here_arr);
	$seo['title'] = $comname . ' - '.$cat_info['catname']. ' - '.$CFG['webname'].'';
	$seo['keywords'] = $comname.','.($cat_info['catname'] ? str_replace(' ', ',', trim($keywords)).',' : '').strip_tags(trim($cat_info['catname']), ',');
	if($keywords != $keywords) {
	$keywords = str_replace("//", '', addslashes($keywords));
	}
	$seo['description'] = !empty($description) ? $description : cut_str(strip_tags($content),200);
	include template('com_view');
}
?>