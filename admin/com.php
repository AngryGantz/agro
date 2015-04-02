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
require 'include/common.php';
require '../include/com.fun.php';
chkadmin('com');
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
$nav = 'company';
$navig = 'com';
switch ($_REQUEST['act'])
{
	case 'list':
		$cats = com_cat_options();
        $area = area_options();
		$page = empty($_REQUEST[page])? 1 : intval($_REQUEST['page']);
		$catid    = empty($_REQUEST['cat']) ? 0 : intval($_REQUEST['cat']);
		$areaid   = empty($_REQUEST['area']) ? 0 : intval($_REQUEST['area']);
		$typeid   = empty($_REQUEST['type']) ? 0 : intval($_REQUEST['type']);
		$keywords = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
		$username = empty($_REQUEST['username']) ? '' : trim($_REQUEST['username']);
		if($username)$userid = $db->getOne("SELECT userid FROM {$table}member WHERE username='$username'");
		
		$where = '';
		$where = $catid > 0 ? " and catid IN (" . get_com_cat_children($catid) . ")": '';
		$where .= $areaid > 0 ? " and areaid IN (" . get_area_children($areaid) . ")": '';
		
		switch($typeid)
		{
			case '1':
				$where .= " and is_check=1 ";
			break;

			case '2':
				$where .= " and is_check=0 ";
			break;

		}
		
		if (!empty($keywords)) {
			$where .= " AND (comname LIKE '%$keywords%' OR introduce LIKE '%$keywords%')";
		}
		if (!empty($username)) {
			$where .= " AND userid='$userid' ";
		}
		
		$sql = "SELECT COUNT(*) FROM {$table}com WHERE 1 $where";
		$count = $db->getOne($sql);

		$pager['search'] = array('act'=>'list','keywords' => stripslashes(urlencode($_REQUEST['keywords'])),'cat' => $catid,'area' => $areaid, 'type'=>$typeid);
		$pager = get_pager('com.php',$pager['search'],$count,$page,'15'); 

		$sql = "SELECT * FROM {$table}com WHERE 1 $where ORDER BY comid DESC,postdate DESC LIMIT $pager[start],$pager[size]";
		
		$res = $db->query($sql);
		$articles = array();
		while($row=$db->fetchRow($res)) {
			$row['comname']  = cut_str($row['comname'],'50');
			$row['postdate'] = date('Y-m-d-H-i', $row['postdate']);
			$row['is_check'] = $row['is_check']==1;
			$articles[]      = $row;
		}
	    include tpl('list_com');
	break;


	case 'edit':
		$id = intval($_REQUEST['id']);
		$sql = "SELECT * FROM {$table}com WHERE comid = '$id'";
		$info = $db->getRow($sql);
		if(empty($info)){show($L['company_does_not_exist'],'index.php');}
		extract($info);
		$postdate = date('Y-m-d-H-i', $postdate);
		$info_area = area_options($areaid);
		$info_cat = com_cat_options($catid);
		$refer = $_SERVER['HTTP_REFERER'];
		include tpl('edit_com', 'com');
	break;

	case 'update':
		$comid    = intval($_POST['id']);
		$comname  = $_POST['comname'] ? htmlspecialchars(trim($_POST['comname'])) : '';
		$catid   = intval($_REQUEST['catid']);
		$areaid   = $_POST['areaid'] ? intval($_POST['areaid']) : '';
		$introduce  = $_POST['introduce'] ? htmlspecialchars(trim($_POST['introduce'])) : '';
		$description = addslashes(get_intro($introduce, 200));
	    $keywords  = $_POST['keyword'] ? htmlspecialchars(trim($_POST['keyword'])) : '';
		$linkman  = $_POST['linkman'] ? htmlspecialchars(trim($_POST['linkman'])) : '';
		$phone    = $_POST['phone'] ? trim($_POST['phone']) : '';
		$icq       = $_POST['icq'] ? intval($_POST['icq']) : '';
		$email    = $_POST['email'] ? htmlspecialchars(trim($_POST['email'])) : '';
		$address  = $_POST['address'] ? trim($_POST['address']) : '';
		$mappoint = $_POST['mappoint'] ? trim($_POST['mappoint']) : '';
		$hours     = $_POST['hours'] ? htmlspecialchars(trim($_POST['hours'])) : '';
		$fax       = trim($_POST['fax']);
		$is_check  = trim($_POST['is_check']);
		if(empty($comname))showmsg($L['enter_name']);
		if(empty($introduce))showmsg($L['enter_contents']);
		if(empty($linkman))showmsg($L['enter_name_surname']);
		if(empty($phone) && empty($icq) && empty($email))showmsg($L['enter_one_three_contacts']);

		$sql = "UPDATE {$table}com SET
				areaid='$areaid',
				catid='$catid',
				comname='$comname',
				introduce='$introduce',
				description='$description',
				keywords='$keywords',
				linkman='$linkman',
				email='$email',
				icq='$icq',
				phone='$phone',
				mappoint='$mappoint',
				address='$address',
				fax='$fax',
				hours='$hours',
				is_check='$is_check'
				where comid = '$comid' ";
		$res = $db->query($sql);

		admin_log("".$L['company_changed_log']." $comname");
		$refer = trim($_POST['refer']);
		show($L['done'], $refer);
	break;

	case 'batch':
		$id = is_array($_REQUEST['id']) ? join(',', $_REQUEST['id']) : intval($_REQUEST['id']);
		if(empty($id))show($L['choice_records']);
		if(empty($_REQUEST['type']))show($L['a_parameter_error']);
		switch ($_REQUEST['type'])
		{
			case 'delete':
				$sql = "SELECT thumb FROM {$table}com WHERE comid IN ($id)";
				$image = $db->getAll($sql);
				foreach((array)$image AS $val) {
					if($val[thumb] != '' && is_file(AWEBCOM_ROOT.$val[thumb])) {
						@unlink(AWEBCOM_ROOT.$val[thumb]);
					}
				}
				$sql = "DELETE FROM {$table}com WHERE comid in ($id)";
				$res = $db->query($sql);
				
				//$sql = "DELETE FROM {$table}com_comment WHERE comid IN ($id)";
				//$db->query($sql);

				$sql = "SELECT path FROM {$table}com_image WHERE comid IN ($id)";
				$image = $db->getAll($sql);
				foreach((array)$image AS $val){
					if($val[path] != '' && is_file('../'.$val[path])){
						@unlink('../'.$val[path]);
					}
				}

				$sql = "DELETE FROM {$table}com_image WHERE comid IN ($id)";
				$db->query($sql);

				admin_log("".$L['company_delete_log']." $id");
				show($L['done'], $_SERVER['HTTP_REFERER']);
			break;

			case 'is_check':
				$sql = "UPDATE {$table}com SET is_check=1 WHERE comid IN ($id)";
				$re = $db->query($sql);
				admin_log("".$L['company_check_log']." $id");
				show($L['done'], $_SERVER['HTTP_REFERER']);
			break;
			default:
			show($L['a_invalid_request'], './');
			break;
		}
	break;
}
?>