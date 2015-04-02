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
$keyword = !empty($_REQUEST['keywords']) ? trim($_REQUEST['keywords']) : '';
$areaid = !empty($_REQUEST['area']) ? intval($_REQUEST['area']) : 0;
$catid = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
$page = !empty($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;

if(!empty($keyword)) {
	$arr = array();
	$keywords = 'AND (';
	$keywords .= "(title LIKE '%$keyword%' OR keywords LIKE '%$keyword%' OR content LIKE '%$keyword%')";
	$keywords .= ')';
}
$cats = get_cat_children($catid);
$category = $catid ? " AND catid IN ($cats)": '';
$areas = get_area_children($areaid);
$area = $areaid ? " AND areaid IN ($areas)" : '';

$cus_in  = '';
$cus_num = 0;
$cus_arg = array();
if(!empty($_REQUEST['custom'])) {

	$sql = "SELECT infoid, COUNT(*) AS num FROM {$table}cus_value WHERE 0 ";
	foreach($_REQUEST['custom'] AS $key => $val) {
	if( (!is_array($val) && !empty($val)) || (is_array($val) && (!empty($val['from']) || !empty($val['to']) || !empty($val[0])))) {
			$cus_num++;
			$sql .= " or (1 ";

			if(is_array($val)) {
				$cus_tom = get_custom_info($key);
				$sql .= " AND cusid = '$key'";
				if($cus_tom[search]=='2') {
					if(!empty($val['from'])) {
						$sql .= is_numeric($val['from']) ? " AND cusvalue >= " . floatval($val['from'])  : " AND cusvalue >= '$val[from]'";
						$cus_arg["custom[$key][from]"] = $val['from'];
					}
					if(!empty($val['to'])) {
						$sql .= is_numeric($val['to']) ? " AND cusvalue <= " . floatval($val['to']) : " AND cusvalue <= '$val[to]'";
						$cus_arg["custom[$key][to]"] = $val['to'];
					}
				} elseif ($cus_tom[search]=='4') {
					$val = join(',', $val);
					$sql .= " AND cusid = '$key' AND cusvalue like '%$val%' ";
					$cus_arg["custom[$key]"] = $val;
				}
			} else {
				$sql .= " AND cusid = '$key' AND cusvalue like '%$val%' ";
				$cus_arg["custom[$key]"] = $val;
			}
			$sql .= ')';
		}
	}
	if($cus_num>0) {
		$sql .= " GROUP BY infoid HAVING num = '$cus_num' ";
		$row = $db->getCol($sql);
		if(count($row)) {
			$row = join(',',$row);
			$cus_in = " AND id in ($row)";
		} else {
			$cus_in = " AND 0 ";
		}
	}
}

$area_array = get_area_array();
$cat_array = get_cat_array();
$size = $INF['searchw'];
$sql = "SELECT COUNT(*) FROM {$table}info AS i WHERE is_check = 1 $cus_in AND (( 1 " . $category . $keywords . $area ." ))";
$count = $db->getOne($sql);
$max_page = ($count> 0) ? ceil($count / $size) : 1;
if($page>$max_page)$page = $max_page;
$pager['search'] = array('keywords' => stripslashes(urlencode($_REQUEST['keywords'])),'id' => $cat,'area' => $_REQUEST['area']);
$pager['search'] = array_merge($pager['search'], $cus_arg);
$pager = get_pager('search.php', $pager['search'], $count, $page, $size);

$sql = "SELECT * FROM {$table}info WHERE is_check=1 $cus_in AND (( 1 " . $category . $keywords . $area . " )) ORDER BY id DESC,postdate desc LIMIT $pager[start],$pager[size]";
$res = $db->query($sql);
$articles = array();
while($row = $db->fetchRow($res)) {
	$row['title']    = cut_str($row['title'],'80');
	$row['postdate'] = date('Y-m-d-H-i', $row['postdate']);
	$row['lastdate'] = enddate($row['enddate']);
	$row['areaname'] = $area_array[$row['areaid']];
	$row['catname'] = $cat_array[$row['catid']];
	$row['url']      = url_rewrite('view',array('vid'=>$row['id']));
	$row['is_pro']   = $row['is_pro']>=time();
    $row['is_top']   = $row['is_top']>=time();
	
	if($keyword) {
		$row['title'] = preg_replace('/'.$keyword.'/i','<font color=red>'.$keyword.'</font>', $row['title']);
		$row['introduce'] = preg_replace('/'.$keyword.'/i','<font color=red>'.$keyword.'</font>', $row['introduce']);
	}
	$articles[] = $row;
}
$cat_hot = get_info($cats, $areas, $INF['searchhot'], '','click',$INF['searchsimhot']);
$seo['title'] = $L['f_search'] . ' - '. $CFG['webname']. '';
$seo['keywords'] = $CFG['keywords'];
$seo['description'] = $CFG['description'];
include template('search');
?>