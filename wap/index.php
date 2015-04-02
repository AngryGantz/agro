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
require dirname(__FILE__) . '/include/common.inc.php';

$seo['title'] = $CFG['webname'];
$seo['keywords'] = $CFG['keywords'];
$seo['description'] = $CFG['description'];

$cats  = get_cat_list();
$new_info  = get_info('','','10','','date','80');
if(!empty($new_info)) {
	foreach ($new_info as $val) {
		$val['title'] = encode_output($val['title']);
		$val['areaname'] = encode_output($val['areaname']);
	}
}

$seo['title'] = $CFG['webname'];
include tpl('index');
?>