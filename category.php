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
$catid = $_REQUEST['id'] ? intval($_REQUEST['id']) : '';
$areaid = $_REQUEST['area'] ? intval($_REQUEST['area']) : '';
$sview = isset($sview) ? 1 : 0;
if(empty($catid) && empty($areaid)) {
	header("Location: ./");
	exit;
}

if($catid) {
	$cat_info = get_cat_info($catid);
	if(empty($cat_info)) showmsg($L['category_does_not_exist'], 'index.php');
	$here_arr[] = array('name'=>$cat_info['catname']);
	$cat_parent = $cat_info['parentid'];

	if(empty($cat_parent)) {
		//Смотрим. есть ли подкатегории
		$cat_row = get_cat_children($catid, 'array');
		//Если есть подкатегории
		if(!empty($cat_row)) {
			//Создаем поиск
			$s_cat .= '<select name="id" id="id"><option value="0">'.$L['f_select_category'].'</option>';
			foreach($cat_row as $cat) {
				$s_cat .= "<option value=$cat[id]>$cat[name]</option>";
			}
			$s_cat .= '</select>';
			//получаем все категории. разделитель запятая
			$cats = get_cat_children($catid);
			if($cats) $cats .= ','.$catid;

			/* навигация */
			$cat_arr = array();
			foreach($cat_row as $val) {
				$val['catname'] = $val['name'];
				$val['url'] = url_rewrite('category', array('cid'=>$val['id'],'eid'=>$areaid));
				$cat_arr[] = $val;
			}
		} else {
			//не даем выбирать, если нет подкатегорий
			$s_cat .= '<select name="id" id="id" disabled>';
			$s_cat .= "<option value=$catid selected>".$cat_info['catname']."</option>";
			$s_cat .= '</select>';
			$cats = $catid;
		}
		$top_type = '1';//тип в ТОП-е. 1 - для зарегистрированных. Выводить выше
		
	} else {
		//Смотрим, есть ли подкатегории
		$cat_row = get_cat_children($cat_parent, 'array');
		/* навигация */
		if(!empty($cat_row))
		{
			foreach($cat_row as $val) {
				$val['catnid'] = $val['id'];
				$val['catname'] = $val['name'];
				$val['url'] = url_rewrite('category',array('cid'=>$val['id'],'eid'=>$areaid));
				$cat_arr[] = $val;
			}
			/* содаем поиск */
			$s_cat .= '<select name="id" id="id" disabled>';
			foreach($cat_row as $cat) {
				$select = $cat['id'] == $catid ? 'selected' : '';
				$s_cat .= "<option value='$cat[id]' $select>$cat[name]</option>";
			}
			$s_cat .= '</select>';
		}
		$top_type = '2'; //тип в ТОП-е. 2 - для незарегистрированных. Выводить ниже
		$cats = $catid;
	}
	$cat_sql = " and catid in ($cats) ";
	$cat_custom = cat_search_custom($catid);
	$top_info = get_top_info($cats, $top_type);
	if(!empty($top_info)) {
		foreach((array)$top_info as $val) {
			$ids[] = $val['id'];
		}
		$top_info_ids = join(',', $ids);
		$top_info_sql = " and id not in ($top_info_ids)";
	}
} else {
	//получаем подкатегории
	$cat_row = get_parent_cat();
	//навигация
	if(!empty($cat_row)) {
		foreach($cat_row as $val) {
			$val['url'] = url_rewrite('category', array('cid'=>$val['catid'],'eid'=>$areaid));
			$cat_arr[] = $val;
		}
	}
	//создаем поиск
	$s_cat = '<select name="id" id="id"><option value="0">'.$L['f_select_category'].'</option>';
	foreach($cat_row as $cat) {
		$s_cat .= "<option value=$cat[catid]>$cat[catname]</option>";
	}
	$s_cat .= '</select>';
}

if($areaid) {
	$delimiter = ' - ';
	$area_info = get_area_info($areaid);
	if(empty($area_info)) showmsg($L['area_does_not_exist']);
	$here_arr[] = array('name'=>$delimiter);//разделитель
	$here_arr[] = array('name'=>$area_info['areaname']);//навигация регион
	$area_parent = $area_info['parentid'];
	if(empty($area_parent)) {
		//регионы
		$area_row = get_area_children($areaid,'array');
		if($area_row) {
			//навигация
			$area_arr = array();
			foreach($area_row as $val) {
				$val['areaname'] = $val['name'];
				$val['url'] = url_rewrite('category',array('cid'=>$catid,'eid'=>$val['id']));
				$area_arr[] = $val;
			}
			//создаем поиск
			$s_area .= '<select name="area" id="area"><option value="0">'.$L['areaid_empty'].'</option>';
			foreach($area_row as $cat) {
				$s_area .= "<option value=$cat[id]>$cat[name]</option>";
			}
			$s_area .= '</select>';
		} else {
			$s_area .= '<select name="area" id="area" disabled>';
			$s_area .= "<option value=$areaid selected>".$area_info['areaname']."</option>";
			$s_area .= '</select>';
		}
		$areas = get_area_children($areaid);
		if(!empty($areas)) $areas .= ','.$areaid;
	} else {
		//получаем подкатегории
		$area_row = get_area_children($area_parent, 'array');
		/* навигация */
		foreach($area_row as $val) {
			$val['areaid'] = $val['id'];
			$val['areaname'] = $val['name'];
			$val['url'] = url_rewrite('category',array('eid'=>$val['id'],'cid'=>$catid));
			$area_arr[] = $val;
		}
		/* создаем поиск */
		$s_area .= '<select name="area" id="area">';
		foreach($area_row as $cat) {
			$select = $cat['id'] == $areaid ? 'selected' : '';
			$s_area .= "<option value='$cat[id]' $select>$cat[name]</option>";
		}
		$s_area .= '</select>';
		$areas = $areaid;
	}
	$area_sql = " and areaid in ($areas) ";
} else {
	//Все основные регионы
	$area_row = get_parent_area();
	if($area_row) {
		$area_arr = array();
		foreach($area_row as $val) {
			$val['areaname'] = $val['areaname'];
			$val['url'] = url_rewrite('category', array('cid'=>$catid, 'eid'=>$val['areaid']));
			$area_arr[] = $val;
		}

		// $s_area .= '<select name="area" id="area"><option value="0">'.$L['country_empty'].'</option>';
		// foreach($area_row as $area) {
		// 	$s_area .= "<option value=$area[areaid]>$area[areaname]</option>";
		// }
		// $s_area .= '</select>';
	}
}

$area_array = get_area_array();
$cat_array = get_cat_array();
$page = empty($_REQUEST['page']) ? '1' : intval($_REQUEST['page']);
$sql = "SELECT COUNT(*) FROM {$table}info as i WHERE is_check=1 $cat_sql $area_sql";
$count = $db->getOne($sql);
$size = $INF['catw'];
$pager = page('category', $catid, $areaid, $count, $size, $page);

$time = time();
$sql = "SELECT id,userid,title,postdate,enddate,catid,areaid,thumb,mappoint,price,unit,is_pro,is_top,description FROM {$table}info WHERE is_check=1 $cat_sql $area_sql $top_info_sql ORDER BY CASE WHEN is_top >= $time THEN 1 ELSE 0 END DESC, postdate DESC limit $pager[start], $pager[size]";
$res = $db->query($sql);
$info = array();
while($row=$db->fetchRow($res)) {
	$row['url']      = url_rewrite('view',array('vid'=>$row['id']));
	$row['postdate'] = date('Y-m-d-H-i', $row['postdate']);
	$row['lastdate'] = enddate($row['enddate']);
	$row['intro']    = cut_str($row['description'], 50);//
	$row['areaname'] = $area_array[$row['areaid']];
	$row['catname']  = $cat_array[$row['catid']];
    $row['is_pro']   = $row['is_pro']>=time();
    $row['is_top']   = $row['is_top']>=time();
	$row['mappoints'] = explode(',',$row['mappoint']);
	$info[$row['id']] = $row;
}


if($info) {
	foreach($info as $val) {
		$infoid .= $val['id'].',';
	}
	$infoid = substr($infoid,0,-1);
	$info_custom = get_infos_custom($infoid);
	foreach($info as $key=>$val) {
		$info[$key]['custom'] = is_array($info_custom[$key]) ? $info_custom[$key] : array();
	}
}
$cat_pro = get_info($cats,$areas,$INF['catvip'],'pro','',$INF['catsimvip']);//рекомендуемые
$cat_hot = get_info($cats,$areas,$INF['cathot'],'',' click ',$INF['catsimhot']);//популярные
$here = get_here($here_arr);
$seo['title'] = $area_info['areaname'] . '  ' . $cat_info['catname'] . ' - '. $CFG['webname']. '';
$seo['keywords'] = $area_info['areaname'].$cat_info['keywords'];
$seo['description'] = $cat_info['description'];

$template = $cat_info['cattplname'] ? $cat_info['cattplname'] : 'category';
include template($template);
?>