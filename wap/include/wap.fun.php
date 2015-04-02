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
function tpl($file)
{
	$file = AWEBCOM_ROOT.'wap/templates/'.$file.'.htm';
    return $file;
}

function encode_output($str)
{
	global $charset;

    if ($charset != 'utf-8')
    {
        $str = iconv($charset, 'utf-8', $str);
    }
    return strip_tags($str);
}

?>