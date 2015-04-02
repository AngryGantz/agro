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
if (!defined('IN_AWEBCOM'))
{
    die('Access Denied');
}

function chkadmin($purview)
{
	global $db,$table,$L;
	$sql = "SELECT is_admin,purview FROM {$table}admin WHERE userid='$_SESSION[adminid]'";
	$row = $db->getRow($sql);
	if(!$row['is_admin']){
		$purviews = explode(",", $row['purview']);
		if(!in_array("$purview", $purviews)) {
			show($L['not_allowed_access']);
		}
	}
}

/* 
 * @param   string  logtype 
 */
function admin_log($logtype)
{
	global $db,$table;
    $sql = "INSERT INTO {$table}admin_log (adminname,logdate,logtype,logip) VALUES ('$_SESSION[adminname]','".time()."','$logtype','$_SERVER[REMOTE_ADDR]')";
    $db->query($sql);
}

function tpl($file)
{
	global $CFG;
	$file = AWEBCOM_ROOT.'admin/templates/'.$file.'.htm';
    return $file;
}

/**
 * @param   string  msg 
 */
function show($msg,$url='goback')
{
	global $L;
    include tpl('show');
	exit;
}

/**
 * @param string type
 */
function type_select($type='help',$typeid='')
{
	global $db,$table;
	
	$res = $db->query("select * from {$table}type where module='$type'");
	$option = "<select name=\"typeid\" id=\"typeid\">";
	while($row=$db->fetchrow($res)) {
		$option .= "<option value=$row[typeid]";
		$option .= ($typeid == $row[typeid]) ? " selected='selected'" : '';
		$option .= ">$row[typename]</option>";
	}
	$option .= "</select>";
	return $option;
}

/**
 * @param string field 
 * @param string tables
 */
function getFieldMax($field, $tables)
{
	global $db,$table;
	$data = $db->getOne("SELECT MAX(".$field.") FROM {$table}{$tables}");
	return $data;
}

?>