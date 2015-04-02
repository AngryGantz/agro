<?php
define('IN_AWEBCOM', true);
$count = $db->getOne("select count(*) from {$table}info where is_check=1");
$sql = "select catid,count(*) as num from {$table}info where is_check=1 group by catid ";
$counts = $db->getAll($sql);
$info_count = array();
foreach($counts as $k=>$v) { $info_count[$v['catid']] = $v['num']; }
//$today_count = $db->getOne("select count(*) from {$table}info where is_check=1 and postdate>".mktime(0,0,0));
$nav = get_nav(); 
$cats_list  = get_cat_list();
$areas_list = get_area_list();

$area_option = area_options(); 
$cat_option  = cat_options(); 
$static = get_static();
?>