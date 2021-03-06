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
chkadmin('info');
$_REQUEST['act'] = $_REQUEST['act'] ? trim($_REQUEST['act']) : 'list' ;
$nav = 'board';
$navig = 'info';
switch ($_REQUEST['act'])
{
	case 'list':
		$cats = cat_options();
        $area = area_options();
		$page = empty($_REQUEST[page])? 1 : intval($_REQUEST['page']);

		$catid    = empty($_REQUEST['cat']) ? 0 : intval($_REQUEST['cat']);
		$areaid   = empty($_REQUEST['area']) ? 0 : intval($_REQUEST['area']);
		$typeid   = empty($_REQUEST['type']) ? 0 : intval($_REQUEST['type']);
		$keywords = empty($_REQUEST['keywords']) ? '' : trim($_REQUEST['keywords']);
		$username = empty($_REQUEST['username']) ? '' : trim($_REQUEST['username']);
		if($username)$userid = $db->getOne("SELECT userid FROM {$table}member WHERE username='$username'");
		
		$where = '';
		$where = $catid > 0 ? " and catid IN (" . get_cat_children($catid) . ")": '';
		$where .= $areaid > 0 ? " and areaid IN (" . get_area_children($areaid) . ")": '';
		
		switch($typeid)
		{
			case '1':
				$where .= " and is_check=1 ";
			break;

			case '2':
				$where .= " and is_check=0 ";
			break;

			case '3':
				$where .= " and is_pro>".time();
			break;

			case '4':
				$where .= " and is_top>".time();
			break;
		}
		
		if (!empty($keywords)) {
			$where .= " AND (title LIKE '%$keywords%' OR content LIKE '%$keywords%')";
		}
		if (!empty($username)) {
			$where .= " AND userid='$userid' ";
		}
		
		$sql = "SELECT COUNT(*) FROM {$table}info WHERE 1 $where";
		$count = $db->getOne($sql);

		$pager['search'] = array('act'=>'list','keywords' => stripslashes(urlencode($_REQUEST['keywords'])),'cat' => $catid,'area' => $areaid, 'type'=>$typeid);
		$pager = get_pager('info.php',$pager['search'],$count,$page,'15'); 

		$sql = "SELECT * FROM {$table}info WHERE 1 $where ORDER BY id DESC,postdate DESC LIMIT $pager[start],$pager[size]";
		$res = $db->query($sql);
		$articles = array();
		while($row=$db->fetchRow($res)) {
			$row['title']    = cut_str($row['title'],'50');
			$row['postdate'] = date('Y-m-d-H-i', $row['postdate']);
			$row['is_pro']   = $row['is_pro']>=time();
			$row['is_top']   = $row['is_top']>=time();
			$row['is_check'] = $row['is_check']==1;
			$articles[]      = $row;
		}
	    include tpl('list_info');
	break;
	
	case 'view':
		$id = intval($_REQUEST['id']);
		$sql = "SELECT i.*,c.catname,a.areaname FROM {$table}info AS i LEFT JOIN {$table}category AS c ON i.catid = c.catid LEFT JOIN {$table}area AS a ON i.areaid = a.areaid WHERE i.id = '$id'";
		$info = $db->getRow($sql);
		if(empty($info)){show($L['a_parameter_error'],'info.php');}
		extract($info);
		$postdate  = date('Y-m-d-H-i', $postdate);
		$enddate   = enddate($enddate);
		$info_area = area_options($areaid);
		$info_cat  = cat_options($catid);

		$refer = $_SERVER['HTTP_REFERER'];
		include tpl('view_info');
	break;

	case 'edit':
		$id = intval($_REQUEST['id']);
		$sql = "SELECT * FROM {$table}info WHERE id = '$id'";
		$info = $db->getRow($sql);
		if(empty($info)){show($L['a_parameter_error'],'info.php');}
		extract($info);
		$sql = "SELECT * FROM {$table}info_image WHERE infoid = '$id' ";
		$images = array();
		$images = $db->getAll($sql);
		$up_img_count = count($images);
		$img_count = 6-$up_img_count;
		$postdate = date('Y-m-d-H-i', $postdate);
		$enddate  = round(($enddate>0 ? ($enddate-time()) : '0')/(3600*24));
		$is_pro = $is_pro > '0' ? date('Y-m-d', $is_pro) : '';
		$is_top = $is_top > '0' ? date('Y-m-d', $is_top) : '';
		$custom = cat_post_custom($catid,$id);
		$info_area = area_options($areaid);
		$info_cat = cat_options($catid);
        $mappoint = trim($mappoint);
		$refer = $_SERVER['HTTP_REFERER'];
		include tpl('edit_info');
	break;

	case 'update':
		if(empty($_POST['title']))show($L['enter_name']);
		if(empty($_POST['content']))show($L['enter_contents']);
		if(empty($_POST['phone']) && empty($_POST[icq]) && empty($_POST[email]))show($L['enter_one_three_contacts']);
		
		$id      = intval($_POST['id']);
		$title   = htmlspecialchars(trim($_POST['title']));
		$catid   = intval($_REQUEST['catid']);
		$def_cat = intval($_REQUEST['default_cat']);
		$content = $_POST['content'] ? htmlspecialchars(trim($_POST['content'])) : '';
	    $keywords  = $_POST['keyword'] ? htmlspecialchars(trim($_POST['keyword'])) : '';
		$description = addslashes(get_intro($content, 200));
		$areaid  = intval($_POST['areaid']);
		$address = trim($_POST['address']);
		$youtube   = $_POST['youtube'] ? htmlspecialchars(trim($_POST['youtube'])) : '';
		$price   = $_POST['price'] ? htmlspecialchars(trim($_POST['price'])) : '';
		$unit   = $_POST['unit'] ? htmlspecialchars(trim($_POST['unit'])) : '';
		$enddate = $_POST['enddate']>0 ? (intval($_POST['enddate']*3600*24)) + time() : '0';
		$linkman = htmlspecialchars(trim($_POST['linkman']));
		$phone   = htmlspecialchars(trim($_POST['phone']));
		$icq      = htmlspecialchars(trim($_POST['icq']));
		$email   = htmlspecialchars(trim($_POST['email']));
		$is_pro  = strtotime($_POST['is_pro']);
		$is_top  = strtotime($_POST['is_top']);
		$is_check = intval($_POST['is_check']);
		$mappoint = trim($_POST['mappoint']);
		$top_type = $_POST['top_type'];
		$thumb = trim($_POST['thumb']);
		if($catid != $def_cat)$db->query("delete from {$table}cus_value where infoid='$id' ");
		$sql = "update {$table}info set areaid='$areaid',catid='$catid',title='$title',description='$description',content='$content',youtube='$youtube',keywords='$keywords',price='$price',unit='$unit',address='$address',linkman='$linkman',email='$email',icq='$icq',phone='$phone',mappoint='$mappoint',enddate='$enddate',is_top='$is_top',is_pro='$is_pro',is_check='$is_check',top_type='$top_type' where id = '$id' ";
		$res = $db->query($sql);
		
		$count = count($_FILES);
		for($i=1;$i<=$count;$i++)
		{
			$alled = array('png','jpg','gif','jpeg');
			$maxsize = '523298';
			$exname = strtolower(trim(substr(strrchr($_FILES['file'. $i]['name'], '.'), 1)));
		    if($_FILES['file'. $i]['size']>$maxsize)show("".$L['max_file_size_error']." $maxsize ".$L['byte']."");
			if(!checkupfile($_FILES['file'. $i]['tmp_name']) || !($_FILES['file'. $i]['tmp_name'] != 'none' && $_FILES['file'. $i]['tmp_name'] && $_FILES['file'. $i]['name']) || $_FILES['file'. $i]['size']>$maxsize || !in_array($exname,$alled)){
				continue;
			}
			$name = date('ymdhis');
			for($a = 0;$a < 6;$a++){ $name .= chr(mt_rand(97, 122));}
			$thumb_name = $name.'_thumb'. '.' . end(explode('.', $_FILES['file'. $i]['name']));;
			$name .= '.' . end(explode('.', $_FILES['file'. $i]['name']));
			
			$dir = AWEBCOM_ROOT . 'data/infoimage/' . date('ymd');
			if(!is_dir($dir))if(@mkdir(rtrim($dir,'/'), 0777))@chmod($dir, 0777);
			$to = $dir.'/'. $name;
			if(move_uploaded_file($_FILES['file'. $i]['tmp_name'], $to)) {
				$image = 'data/infoimage/' . date('ymd').'/'. $name;
				$sql = "INSERT INTO {$table}info_image (infoid,path) VALUES ('$id','$image')";
				$db->query($sql);
			}
			if(empty($thumb)) {
				if(!$do) {
					$newimg ='data/infoimage/' . date('ymd').'/'.$thumb_name;
					$thumb = CreateSmallImage( AWEBCOM_ROOT.$image,  AWEBCOM_ROOT.$newimg, 154, 134);
					$sql = "update {$table}info set thumb='$newimg' where id='$id' ";
					$db->query($sql);
					$do = true;
				}
			}
		}

		if (isset($_POST['cus_value']))
		{
			$infoid = $id;
			$cus_value_list = array();
			
			$res = $db->query("SELECT * FROM {$table}cus_value WHERE infoid = '$infoid'");
			while ($row = $db->fetchRow($res)) {
				$cus_value_list[$row['cusid']][$row['cusvalue']] = array('query' => 'delete', 'id' => $row['id']);
			}
			foreach ($_POST['cus_value'] AS $key => $val)
			{
				if(is_array($val))$val=implode(",", $val);

				$cusvalue = $val;
				if (!empty($cusvalue))
				{
					if (isset($cus_value_list[$key][$cusvalue]))
					{
						$cus_value_list[$key][$cusvalue]['query'] = 'update';
					}
					else
					{
						$cus_value_list[$key][$cusvalue]['query'] = 'insert';
					}
				}
			}
			foreach ($cus_value_list as $cusid => $value_list)
			{
				foreach ($value_list as $cusvalue => $infos)
				{
					
					if ($infos['query'] == 'insert')
					{
					   $sql = "INSERT INTO {$table}cus_value (cusid, infoid, cusvalue) VALUES ('$cusid', '$infoid', '$cusvalue')";
					}
					elseif ($infos['query'] == 'delete')
					{
						$sql = "DELETE FROM {$table}cus_value WHERE id = '$infos[id]' LIMIT 1";
					}
					elseif ($infos['query'] == 'update')
					{
						$sql = "update {$table}cus_value set cusvalue='$cusvalue' where id='$infos[id]' ";
					}
					$db->query($sql);
				}
			}
		}
		admin_log("".$L['listing_changed_log']." $id");
		$refer = trim($_POST['refer']);
		show($L['done'], $refer);
	break;

	case 'batch':
		$id = is_array($_REQUEST['id']) ? join(',', $_REQUEST['id']) : intval($_REQUEST['id']);
		if(empty($id))show($L['choice_records']);
		switch ($_REQUEST['type'])
		{
			case 'delete':
				$sql = "DELETE FROM {$table}comment WHERE infoid IN ($id)";
				$db->query($sql);
				
				$sql = "DELETE FROM {$table}cus_value where infoid IN ($id)";
				$sql = $db->query($sql);
				
				$sql = "SELECT thumb FROM {$table}info WHERE id in ($id)";
				$thumb = $db->getAll($sql);
				foreach((array)$thumb AS $val) {
					if($val != '' && is_file(AWEBCOM_ROOT.$val['thumb'])){
						@unlink(AWEBCOM_ROOT.$val['thumb']);
					}
				}
				$sql = "SELECT path FROM {$table}info_image WHERE infoid IN ($id)";
				$images = $db->getAll($sql);
				foreach((array)$images AS $val){
					if($val != '' && is_file(AWEBCOM_ROOT.$val['path'])){
						@unlink(AWEBCOM_ROOT.$val['path']);
					}
				}
				
				$db->query("DELETE FROM  {$table}report WHERE info IN ($id) ");
				$db->query("DELETE FROM {$table}info_image WHERE infoid IN ($id)");
				$res = $db->query("DELETE FROM {$table}info WHERE id in ($id)");

				admin_log("".$L['listing_delete_log']." $id");
				show($L['done'], $_SERVER['HTTP_REFERER']);
			break;

			case 'is_check':
				$sql = "UPDATE {$table}info SET is_check=1 WHERE id IN ($id)";
				$re = $db->query($sql);
				admin_log("".$L['listing_check_log']." $id");
				show($L['done'], $_SERVER['HTTP_REFERER']);
			break;
		}
	break;

	case 'delimg':
		$imgid = $_REQUEST['imgid'];
		$img = $db->getOne("select path from {$table}info_image where imgid='$imgid' ");

		if($img != '' && is_file(AWEBCOM_ROOT.$img)){
			unlink(AWEBCOM_ROOT.$img);
		}
		$sql = "delete from {$table}info_image where imgid='$imgid' ";
		$db->query($sql);
		
		show($L['done'], $_SERVER['HTTP_REFERER']);
	break;
	default:
	show($L['a_invalid_request'], './');
	break;
}
?>