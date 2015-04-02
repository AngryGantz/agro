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
chkadmin('category');
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
$nav = 'board';
$navig = 'category';
switch ($_REQUEST['act'])
{
	case 'list':
		$cat = get_cat_list();
	    include tpl('list_category');
	break;

	case 'add':
        $cat = get_cat_list();
		$cats = $db->getAll("SELECT * from {$table}category WHERE parentid=0");
		$maxorder = $db->getOne("SELECT MAX(catorder) FROM {$table}category");
		$maxorder = $maxorder + 1;
		$cattplname = showtpl('category','cattplname');
		$viewtplname = showtpl('view','viewtplname');
	    include tpl('add_category');
	break;

	case 'insert':
		if(empty($_REQUEST[catname]))show($L['enter_name']);
		$len = strlen($_REQUEST[catname]);
		if($len < 2 || $len > 70)show($L['title_2_50_characters']);

		$catname     = trim($_REQUEST['catname']);
	    $parentid    = intval($_REQUEST['parentid']);
		$catorder    = intval($_REQUEST['catorder']);
		$keywords    = trim($_REQUEST['keywords']);
		$description = trim($_REQUEST['desc']);
		$cattplname  = $_REQUEST['cattplname'];
		$viewtplname = $_REQUEST['viewtplname'];

		if(empty($catorder)) {
			$sql = "SELECT MAX(catorder) FROM {$table}category";
			$maxorder = $db->getOne($sql);
			$catorder = $maxorder + 1;
		}
		$sql = "INSERT INTO {$table}category (catname,keywords,description,parentid,catorder,cattplname,viewtplname) VALUES ('$catname','$keywords','$description','$parentid','$catorder','$cattplname','$viewtplname')";
		$res = $db->query($sql);

		clear_caches('phpcache');
		admin_log("".$L['category_added_log']." $cataname");
		show($L['done'],'category.php?act=add');
	break;

	case 'edit':
	    $catid = intval($_REQUEST['catid']);
		$sql = "SELECT * FROM {$table}category WHERE catid = '$catid'";
		$cat = $db->getRow($sql);
		$cattplname = showtpl('category','cattplname', $cat['cattplname']);
		$viewtplname = showtpl('view','viewtplname', $cat['viewtplname']);
		$sql  = "SELECT * FROM {$table}category WHERE parentid = '0'";
	    $cats = $db->getAll($sql);

		include tpl('edit_category');
	break;

	case 'update':
		if(empty($_REQUEST[catname]))show($L['enter_name']);
		$len = strlen($_REQUEST[catname]);
		if($len < 2 || $len > 50)show($L['title_2_50_characters']);
        
		$catid       = intval($_REQUEST['catid']);
		$catname     = trim($_REQUEST['catname']);
	    $parentid    = intval($_REQUEST['parentid']);
		$catorder    = intval($_REQUEST['catorder']);
		$keywords    = trim($_REQUEST['keywords']);
		$description = trim($_REQUEST['desc']);
		$cattplname  = $_REQUEST['cattplname'];
		$viewtplname = $_REQUEST['viewtplname'];

		$sql = "UPDATE {$table}category SET catname='$catname',keywords='$keywords',description='$description',parentid='$parentid',catorder='$catorder',cattplname='$cattplname',viewtplname='$viewtplname' WHERE catid = '$catid'";
		$res = $db->query($sql);
		
		clear_caches('phpcache');
		admin_log("".$L['category_changed_log']." $catname");
		$link = "category.php?act=list";
		show($L['done'], $link);
	break;

	case 'delete':
		$catid = intval($_REQUEST['catid']);
		if(empty($catid))show($L['a_parameter_error']);
		
		$sql = "SELECT COUNT(*) FROM {$table}category WHERE parentid = '$catid' ";
		if($db->getOne($sql)>0)show($L['this_category_there_are_subcategories']);
		
		$sql = "SELECT COUNT(*) FROM {$table}info WHERE catid = '$catid' ";
		if($db->getOne($sql)>0)show($L['this_category_there_are_listing']);

		$sql = "DELETE FROM {$table}category WHERE catid='$catid'";
	    $db->query($sql);

		$sql = "select cusid from {$table}custom where catid='$catid' ";
		$cusids = $db->getRow($sql);
		$cusids = is_array($cusids) ? join(',',$cusids) : '';
		if($cusids) {
			$db->query("delete from {$table}cus_value where cusid in ($cusids)");
			$db->query("delete from {$table}custom where catid=$catid");
		}
		clear_caches('phpcache');
		admin_log("".$L['category_delete_log']." $catid");
		$link = 'category.php?act=list';
		show($L['done'], $link);
	break;
	default:
	show($L['a_invalid_request'], './');
	break;
}


function showtpl($type = 'category', $name = 'tplname', $templateid = 0)
{
	global $CFG,$L;

    $templatedir = AWEBCOM_ROOT."/templates/".$CFG['tplname']."/";
    $content = "";
	$files = glob($templatedir."/*.htm");

	foreach($files as $tplfile) {
		$tplfile = basename($tplfile);
		$tpl = str_replace(".htm","",$tplfile);
		if($type==$tpl || preg_match("/^".$type."-(.*)/i",$tpl)) {
			$selected = ($templateid && $tpl==$templateid) ? 'selected' : '';
            $templatename = $tpl;
			$content .= "<option value='".$tpl."' ".$selected.">".$templatename."</option>\n";
		}
	}
	$content = "<select name='".$name."' ".$property."><option value='0'>".$L['by_default']."</option>\n".$content."</select>";
	return $content;
}
?>