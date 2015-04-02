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
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
if($_REQUEST['act']=='list')
{
	$sql = "select * from {$table}type where module='help'";
	$res = $db->query($sql);
	$type = array();
	while($row = $db->fetchRow($res)) {
		$row['url'] = url_rewrite('help', array('act'=>'list','tid'=>$row['typeid']));
		$type[] = $row;
	}

	$typeid  = !empty($_REQUEST['typeid']) ? intval($_REQUEST['typeid']) : 0;
	$types = $typeid ? " AND typeid = '$typeid' " : '';
	$page = !empty($_REQUEST['page'])  && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;
	$size = !empty($_CFG['pagesize']) && intval($_CFG['pagesize']) > 0 ? intval($_CFG['page_size']) : 10;

	$sql = "SELECT COUNT(*) FROM {$table}help WHERE 1 ". $types;
	$count = $db->getOne($sql);
	$max_page = ($count> 0) ? ceil($count / $size) : 1;
	if($page>$max_page)$page = $max_page;
	$pager['search'] = array('act'=>'list','typeid' => $_REQUEST['typeid']);
	$pager = page('help', $typeid, '', $count, $size, $page);

	$sql = "SELECT * FROM {$table}help WHERE 1 " . $types . " ORDER BY listorder DESC,addtime DESC LIMIT $pager[start],$pager[size]";
	$res = $db->query($sql);
	$helps = array();
	while($row = $db->fetchRow($res)) {
		$row['stitle']   = cut_str($row['title'],'80');
		$row['addtime'] = date('Y-m-d-H-i', $row['addtime']);
		$row['url']      = url_rewrite('help',array('hid'=>$row['id'],'act'=>'view'));
		$helps[] = $row;
	}
	
	/* категории */
	$cat_info = $db->getRow("SELECT * FROM {$table}type WHERE typeid = '$typeid'");
	if(empty($cat_info)) {
		$here_arr[] = array('name'=>$L['all']);
	} else {
		$here_arr[] = array('name'=>$cat_info['typename']);
	}
	$here = get_here($here_arr);
	$seo['title'] = $cat_info['typename'] . '  '. $L['f_help'] .' - '. $CFG['webname']. '';
	if($cat_info['keywords'] || $cat_info['description']) {
	$seo['keywords'] = $cat_info['keywords'];
	$seo['description'] = $cat_info['description'];
} else {
	$seo['keywords'] = $CFG['keywords'];
	$seo['description'] = $CFG['description'];
}
	
	include template('help_list');
}
elseif($_REQUEST['act']=='view')
{
	if(isset($_REQUEST['id']))$id = intval($_REQUEST['id']);
	if(empty($id))  showmsg($L['invalid_request']);
	$help = $db->getRow("SELECT * FROM {$table}help WHERE id='$id'");
	if(empty($help))showmsg($L['info_does_not_exist'], 'index.php');
	extract($help);
	$addtime = date('Y-m-d-H-i', $addtime);
	
	$row = $db->getRow("SELECT * FROM {$table}type WHERE typeid = '$typeid'");
	$here_arr[] = array('name'=>$row['typename'],'url'=>url_rewrite('help',array('iid'=>$row['typeid'],'act'=>'list')));
	$here_arr[] = array('name'=>$title);
	$here = get_here($here_arr);
	
	$seo['title'] = $title. ' - '. $CFG['webname']. '';
	$seo['keywords']  = !empty($keywords) ? $keywords : cut_str($title,'200');
	$seo['description'] = $description;
	include template('help');
}
?>