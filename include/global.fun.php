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
if(!defined('IN_AWEBCOM'))
{
	die('Access Denied');
}

function daddslashes($string) {
	if(!is_array($string)) return addslashes($string);
	foreach($string as $key => $val) $string[$key] = daddslashes($val);
	return $string;
}

#Функция замены ссылки с youtube.com
function replaceyoutube($text)
{
	$text = preg_replace('~
		# Match non-linked youtube URL in the wild. (Rev:20111012)
		https?://         # Required scheme. Either http or https.
		(?:[0-9A-Z-]+\.)? # Optional subdomain.
		(?:               # Group host alternatives.
		youtu\.be/      # Either youtu.be,
		| youtube\.com    # or youtube.com followed by
		\S*             # Allow anything up to VIDEO_ID,
		[^\w\-\s]       # but char before ID is non-ID char.
		)                 # End host alternatives.
		([\w\-]{11})      # $1: VIDEO_ID is exactly 11 chars.
		(?=[^\w\-]|$)     # Assert next char is non-ID or EOS.
		(?!               # Assert URL is not pre-linked.
		[?=&+%\w]*      # Allow URL (query) remainder.
		(?:             # Group pre-linked alternatives.
		[\'"][^<>]*>  # Either inside a start tag,
		| </a>          # or inside <a> element text contents.
			)               # End recognized pre-linked alts.
			)                 # End negative lookahead assertion.
			[?=&+%\w-]*        # Consume any URL (query) remainder.
			~ix',
		'http://www.youtube.com/embed/$1',
		$text);
	return $text;
}

function safe_replace($string) {
	if(is_array($string)) {
		return array_map('safe_replace', $string);
	} else {
		if(strlen($string) < 20) return $string;
		$match = array("/&#([a-z0-9]+)([;]*)/i","/\<\!\-\-([\s\S]*?)\-\-\>/","/\/\*([\s\S]*?)\*\//","/on(mouse|exit|error|click|dblclick|key|load|unload|change|move|submit|reset|cut|copy|select|start|stop|drag|touch)/i","/s[[:space:]]*c[[:space:]]*r[[:space:]]*i[[:space:]]*p[[:space:]]*t/i","/about/i","/frame/i","/link/i","/import/i","/expression/i","/meta/i","/textarea/i","/eval/i");
		$replace = array("","","","o&#110;\\1","scrip&#116;","abou&#116;","fram&#101;","lin&#107;","impor&#116;","expressio&#110;","met&#97;","textare&#97;","eva&#108;");
		return preg_replace($match, $replace, $string);
	}
}

function sql_replace($string) {
	$match = array("/union/i","/where/i","/outfile/i","/dumpfile/i","/0x([a-z0-9]{2,})/i","/select([\s\S]*?)from/i","/select([\s\*\/\-\(\+@])/i","/update([\s\*\/\-\(\+@])/i","/replace([\s\*\/\-\(\+@])/i","/delete([\s\*\/\-\(\+@])/i","/drop([\s\*\/\-\(\+@])/i","/load_file[\s]*\(/i","/substring[\s]*\(/i","/substr[\s]*\(/i","/left[\s]*\(/i","/concat[\s]*\(/i","/concat_ws[\s]*\(/i","/make_set[\s]*\(/i","/ascii[\s]*\(/i","/hex[\s]*\(/i","/ord[\s]*\(/i","/char[\s]*\(/i");
	$replace = array('unio&#110;','wher&#101;','outfil&#101;','dumpfil&#101;','0&#120;\\1','selec&#116;\\1from','selec&#116;\\1','updat&#101;\\1','replac&#101;\\1','delet&#101;\\1','dro&#112;\\1','load_fil&#101;(','substrin&#103;(','subst&#114;(','lef&#116;(','conca&#116;(','concat_w&#115;(','make_se&#116;(','asci&#105;(','he&#120;(','or&#100;(','cha&#114;(');
	return is_array($string) ? array_map('sql_replace', $string) : preg_replace($match, $replace, $string);
}


function strip_uri($uri) {
	global $CFG;
	if(strpos($uri, '%') !== false) {
		while($uri != urldecode($uri)) {
			$uri = urldecode($uri);
		}
	}
	if(strpos($uri, '<') !== false || strpos($uri, "'") !== false || strpos($uri, '"') !== false || strpos($uri, '0x') !== false) {
		dhttp(403, 0);
		showmsg('HTTP 403 Forbidden', $CFG['weburl']);
	}
}


function strip_key($array, $deep = 0) {
	global $CFG;
	foreach($array as $k=>$v) {
		if($deep && !preg_match("/^[a-z0-9_\-]{1,}$/i", $k)) {
			dhttp(403, 0);
			showmsg('HTTP 403 Forbidden', $CFG['weburl']);
		}
		if(is_array($v)) strip_key($v, 1);
	}
}

function dhttp($status, $exit = 1) {
	switch($status) {
		case '301': @header("HTTP/1.1 301 Moved Permanently"); break;
		case '403': @header("HTTP/1.1 403 Forbidden"); break;
		case '404': @header("HTTP/1.1 404 Not Found"); break;
		case '503': @header("HTTP/1.1 503 Service Unavailable"); break;
	}
	if($exit) exit;
}

function get_intro($content, $length = 0) {
	if($length) {
		$intro = trim(strip_tags($content));
		$intro = preg_replace("/&([a-z]{1,});/", '', $intro);
		$intro = str_replace(array("\r", "\n", "\t", '  '), array('', '', '', ''), $intro);
		return cut_str($intro, $length);
	} else {
		return '';
	}
}

function cut_str($string, $length, $suffix = '', $start = 0) {
	global $charset;
	if($start) {
		$tmp = cut_str($string, $start);
		$string = mb_substr($string, mb_strlen($tmp, 'UTF-8'), 'UTF-8');
	}
      $mb_strlen = mb_strlen($string, 'UTF-8');
	if($mb_strlen <= $length) return $string;
	$string = str_replace(array('&quot;', '&lt;', '&gt;'), array('"', '<', '>'), $string);
	$str = '';
	if(strtolower($charset) == 'utf-8') {
		$n = $tn = $noc = 0;
		while($n < $mb_strlen)	{
			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t < 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}
			if($noc >= $length) break;
		}
		if($noc > $length) $n -= $tn;
		$str = mb_substr($string, 0, $n, 'UTF-8');
	} else {
		$suffixlen = mb_strlen($suffix, 'UTF-8');
		$maxi = $length - $suffixlen - 1;
		for($i = 0; $i < $maxi; $i++) {
			$str .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}
	$str = str_replace(array('"', '<', '>'), array('&quot;', '&lt;', '&gt;'), $str);
	return $str.$suffix;
}



function str_len($str)
{
    $length = strlen(preg_replace('/[\x00-\x7F]/', '', $str));
    if($length) {
        return strlen($str) - $length + intval($length / 3) * 2;
    } else {
        return strlen($str);
    }
}

function addslashes_deep($value)
{
	if (empty($value))
	{
		return $value;
	}
	else
	{
		if(is_array($value))
		{
			foreach($value as $key => $v)
			{
				unset($value[$key]);

				if($htmlspecialchars==true)
				{
					$key=get_magic_quotes_gpc()? addslashes(stripslashes(htmlspecialchars($key,ENT_NOQUOTES))) : addslashes(htmlspecialchars($key,ENT_NOQUOTES));
				}
				else{
					$key=get_magic_quotes_gpc()? addslashes(stripslashes($key)) : addslashes($key);
				}

				if(is_array($v))
				{
					$value[$key]=addslashes_deep($v);
				}
				else
				{
					if($htmlspecialchars==true)
					{
						$value[$key]=get_magic_quotes_gpc()? addslashes(stripslashes(htmlspecialchars($v,ENT_NOQUOTES))) : addslashes(htmlspecialchars($v,ENT_NOQUOTES));
					}
					else{
						$value[$key]=get_magic_quotes_gpc()? addslashes(stripslashes($v)) : addslashes($v);
					}
				}
			}
		}
		else
		{
			if($htmlspecialchars==true)
			{
				$value=get_magic_quotes_gpc()? addslashes(stripslashes(htmlspecialchars($value,ENT_NOQUOTES))) : addslashes(htmlspecialchars($value,ENT_NOQUOTES));
			}
			else{
				$value=get_magic_quotes_gpc()? addslashes(stripslashes($value)) : addslashes($value);
			}
		}
		return $value;
	}
}

function stripslashes_deep($value)
{
	return is_array($value) ? array_map('stripslashes_deep', $value) : (isset($value) ? stripslashes($value) : null);
}

function htmlspecialchars_deep($value)
{
	return is_array($value) ? array_map('htmlspecialchars_deep', $value) : str_replace('&amp;', '&', htmlspecialchars($value, ENT_QUOTES));
}

function key_replace($array, $deep = 0) {
	foreach($array as $k=>$v) {
		if($deep && !preg_match("/^[a-z0-9_\-]{1,}$/i", $k)) {
			die('error');
		}
		if(is_array($v)) key_replace($v, 1);
	}
}


function random($length)
{
	$chars = '0123456789ABCDEFGHIJ0123456789KLMNOPQRSTJ0123456789UVWXYZ0123456789abcdefghijJ0123456789klmnopqrstJ0123456789uvwxyz0123456789';
	$max = strlen($chars);
	mt_srand((double)microtime() * 1000000);
	for($i = 0; $i < $length; $i ++) {
		$hash .= $chars[mt_rand(0, $max)];
	}
	return $hash;
}

function is_email($email) {
	return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}


function checkupfile($file)
{
	return function_exists('is_uploaded_file') && (is_uploaded_file($file) || is_uploaded_file(str_replace('\\\\', '\\', $file)));
}

function fileext($filename) 
{
	return trim(substr(strrchr($filename, '.'), 1));
}

function get_ip()
{
    static $ip = NULL;
    if($ip !== NULL){return $ip;}
    if(isset($_SERVER)) {
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($arr as $ip) {
                $ip = trim($ip);
                if($ip != 'unknown') {
                    $ip = $ip;
                    break;
                }
            }
        } elseif(isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            if(isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            } else {
                $ip = '0.0.0.0';
            }
        }
    } else {
        if(getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif(getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } else {
            $ip = getenv('REMOTE_ADDR');
        }
    }
    preg_match("/[\d\.]{7,15}/", $ip, $onlineip);
    $ip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

    return $ip;
}

function encrypt($string, $password)
{
	$password = base64_encode($password);
    $count_pwd = strlen("a".$password);
    for($i = 1;$i<$count_pwd;$i++) {
		$pwd+=ord($password{$i});
    }
	$string = base64_encode($string);
    $count = strlen("a".$string);
    for($i = 0;$i<$count;$i++) {
    	$asciis.=(ord($string{$i})+$pwd)."|";
    }
    $asciis = base64_encode($asciis);
	return $asciis;
}

function decrypt($string, $password)
{
	$password = base64_encode($password);
    $count_pwd = strlen("a".$password);
    for($i = 1;$i<$count_pwd;$i++) {
    	$pwd+=ord($password{$i});
    }
    $string = base64_decode($string);
    $contents = explode("|",$string);
    $count = count($contents);
    for($i=0;$i<$count;$i++) {
    	$infos.=chr($contents[$i]-$pwd);
    }
    $asciis = base64_decode($infos);
	return $asciis;
}

function chkcode($width = 60, $height = 22, $count = 4)
{
	$randnum = "";
	if(function_exists("imagecreatetruecolor") && function_exists("imagecolorallocate") && function_exists("imagestring") && function_exists("imagepng") && function_exists("imagesetpixel") && function_exists("imagefilledrectangle") && function_exists("imagerectangle")) {
		$image  = imagecreatetruecolor($width, $height);
		$swhite = imagecolorallocate($image, 255, 255, 255);
		$sblack = imagecolorallocate($image, 0, 0, 0);
		
		imagefilledrectangle($image, 0, 0, ($width -2), ($height -2), $swhite);
		imagerectangle($image, 0, 0, $width, $height, $sblack);
		
		for ($i = 0; $i < 20; $i++) {
			$sjamcolor = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
			imagesetpixel($image, rand(0, $width), rand(0, $height), $sjamcolor);
		}
		
		for ($i = 0; $i < $count; $i++) {
			$randnum .= rand(1, 9);
		}

		$widthx = floor($width / $count);
		for ($i = 0; $i < strlen($randnum); $i++) {
			$irandomcolor = imagecolorallocate($image, rand(50, 255), rand(50, 120), rand(50, 255));
			imagestring($image, 6, ($widthx * $i +rand(1, 3)), rand(1, 5), $randnum {$i }, $irandomcolor);
		}
		header("Pragma:no-cache");
		header("Cache-control:no-cache");
		header("Content-type: image/png");
		imagepng($image);
		imagedestroy($image);
	} else {
		header("Pragma:no-cache");
		header("Cache-control:no-cache");
		header("Content-type: image/png");
		if (!readfile("images/chkcode.png")) {return false;}
		$randnum = "2293";
	}
	return $randnum;
}

function check_code($checkcode)
{
	global $L;
	$chkcode = $_SESSION['chkcode'];
	if(empty($chkcode) || $chkcode != $checkcode)showmsg($L['code_not_correctly']);
}

function page($file,$cat,$area,$count,$size=20,$page=1)
{
	global $tpl;
    $page = intval($page);
    if($page<1)$page = 1;

    $page_count = $count > 0 ? intval(ceil($count / $size)) : 1;
    $page_prev  = ($page > 1) ? $page - 1 : 1;
    $page_next  = ($page < $page_count) ? $page + 1 : $page_count;

	$pager['start']      = ($page-1)*$size;
    $pager['page']       = $page;
    $pager['size']       = $size;
    $pager['count']		 = $count;
    $pager['page_count'] = $page_count;
	
	switch ($file)
    {
        case 'category':
			$params = array('cid' => $cat, 'eid' => $area);
        break;
		
		case 'com';
			$params = array('catid' => $cat, 'eid' => $area, 'act'=>'list');
		break;

		case 'article';
			$params = array('iid' => $cat, 'act'=>'list');
		break;
		
		case 'help';
			$params = array('tid' => $cat, 'act'=>'list');
		break;
    }
	if($page_count <= '1') {
	    $pager['first'] = $pager['prev']  = $pager['next']  = $pager['last']  = '';
	} elseif($page_count > '1') {
		if($page == $page_count) {
			$pager['first'] = url_rewrite($file, $params, 1);
			$pager['prev']  = url_rewrite($file, $params, $page_prev);
			$pager['next']  = '';
			$pager['last']  = '';
		} elseif($page_prev == '1' && $page == '1') {
			$pager['first'] = '';
			$pager['prev']  = '';
			$pager['next']  = url_rewrite($file, $params, $page_next);
			$pager['last']  = url_rewrite($file, $params, $page_count);
		} else {
			$pager['first'] = url_rewrite($file, $params, 1);
			$pager['prev']  = url_rewrite($file, $params, $page_prev);
			$pager['next']  = url_rewrite($file, $params, $page_next);
			$pager['last']  = url_rewrite($file, $params, $page_count);
		}
	}
    return $pager;
}

function get_pager($url, $param, $count, $page = 1, $size = 10)
{
    $size = intval($size);
    if($size < 1)$size = 10;
    $page = intval($page);
    if($page < 1)$page = 1;
    $count = intval($count);

    $page_count = $count > 0 ? intval(ceil($count / $size)) : 1;
    if ($page > $page_count)$page = $page_count;

    $page_prev  = ($page > 1) ? $page - 1 : 1;
    $page_next  = ($page < $page_count) ? $page + 1 : $page_count;

    $param_url = '?';
    foreach ($param as $key => $value)$param_url .= $key . '=' . $value . '&';

    $pager['url']        = $url;
    $pager['start']      = ($page-1) * $size;
    $pager['page']       = $page;
    $pager['size']       = $size;
    $pager['count']		 = $count;
    $pager['page_count'] = $page_count;

	if($page_count <= '1') {
	    $pager['first'] = $pager['prev']  = $pager['next']  = $pager['last']  = '';
	} else {
		if($page == $page_count) {
			$pager['first'] = $url . $param_url . 'page=1';
			$pager['prev']  = $url . $param_url . 'page=' . $page_prev;
			$pager['next']  = '';
			$pager['last']  = '';
		} elseif($page_prev == '1' && $page == '1') {
			$pager['first'] = '';
			$pager['prev']  = '';
			$pager['next']  = $url . $param_url . 'page=' . $page_next;
			$pager['last']  = $url . $param_url . 'page=' . $page_count;
		} else {
			$pager['first'] = $url . $param_url . 'page=1';
			$pager['prev']  = $url . $param_url . 'page=' . $page_prev;
			$pager['next']  = $url . $param_url . 'page=' . $page_next;
			$pager['last']  = $url . $param_url . 'page=' . $page_count;
		}
	}
    return $pager;
}

function url_rewrite($app, $params, $page = 0, $size = 0)
{
	global $CFG;
    static $rewrite = NULL;

    if($rewrite === NULL)$rewrite = intval($CFG['rewrite']);
    $args = array('aid'=> 0,'bid'=>'0','cid'=> 0,'vid'=> 0,'eid'=> '0','tid'=>'0','hid'=>'0' );
    @extract(array_merge($args, $params));
    $uri = '';
    switch($app)
    {
        case 'category':
            if (empty($cid) && empty($eid)) {
                return false;
            } else {
                if($rewrite) {
                    $uri = 'cat-' . intval($cid);
					if(!empty($eid))$uri .= '-area-' . $eid;
                    if(!empty($page))$uri .= '-page-' . $page;
                }else{
					$uri = 'category.php?';
                    if($cid && $eid) {
						$uri .= 'id=' . $cid . '&area=' . $eid;
					} elseif ($cid && !$eid) {
						$uri .= 'id=' . $cid ;
					} elseif (!$cid && $eid) {
						$uri .= 'area=' . $eid ;
					}
                    if(!empty($page)) $uri .= '&page=' . $page;
                }
            }
        break;

        case 'view':
            if(empty($vid)) {
                return false;
            }else{
                $uri = $rewrite ? 'view-' . $vid : 'view.php?id=' . $vid;
            }
        break;

		case 'static':
            if(empty($aid)) {
                return false;
            }else{
                $uri = $rewrite ? 'static-' . $aid : 'static.php?id=' . $aid;
            }
        break;

		case 'help':
            if($act=='list') {
                if($rewrite) {
					$uri = 'help';
                    if($tid)$uri .= '-list-' . $tid;
					if($page)$uri .= '-page-' . $page;
                }else{
					$uri = 'help.php?act=list';
					if($tid)$uri .= '&typeid=' . $tid;
                    if($page)$uri .= '&page=' . $page;
                }
            } elseif($act=='view' && $hid) {
                if($rewrite) {
                    $uri = 'help-view-' . $hid;
                }else{
                    $uri = 'help.php?act=view&id=' . $hid;
                }
            }
        break;

		case 'article':
            if($act=='list') {
                if($rewrite) {
					$uri = 'article';
                    if($iid)$uri .= '-list-' . $iid;
					if($page)$uri .= '-page-' . $page;
                }else{
					$uri = 'article.php?act=list';
					if($iid)$uri .= '&typeid=' . $iid;
                    if($page)$uri .= '&page=' . $page;
                }
            } elseif($act=='view' && $aid) {
                if($rewrite) {
                    $uri = 'article-view-' . $aid.'';
                }else{
                    $uri = 'article.php?act=view&id=' . $aid;
                }
            }
        break;

		case 'com':
            if($act=='list') {
                if($rewrite) {
					$uri = 'com';
					if(!empty($catid))$uri .= '-list-' . $catid;
					if(!empty($eid))$uri .= '-area-' . $eid;
					if(!empty($page))$uri .= '-page-' . $page;
				}else{
					$uri = 'com.php?act=list';
					if(!empty($catid))$uri .= '&catid=' . $catid;
					if(!empty($eid))$uri .= '&area=' . $eid;
					if(!empty($page))$uri .= '&page=' . $page;
				}
            } elseif($act=='view' && $comid) {
                if($rewrite) {
                    $uri = 'com-view-' . $comid.'';
                }else{
                    $uri = 'com.php?act=view&id=' . $comid;
                }
            }
        break;
   
        default:
            return false;
        break;
    }
    if($rewrite)$uri .= '.html';
    return $uri;
}

function enddate($date)
{
	global $L;
	if($date > 0) {
		if($date > time()) {
			$a = round(($date-time())/86400);
			if($a<1) $a = 1;
			$day = "<font color=red>$a</font> ".$L['days_min']."";
		} else {
			$day = $L['time_is_up'];
		}
	} else {
		$day = $L['not_limited'];
	}
	
	return $day;
}

function template($file)
{
	global $CFG;
	
	$compiledfile = AWEBCOM_ROOT.'data/compiled/'.$file.'.php';
	$tplfile = AWEBCOM_ROOT.'/templates/'.$CFG['tplname'].'/'.$file.'.htm';
	if(!file_exists($compiledfile) || @filemtime($tplfile) > @filemtime($compiledfile)) {
		template_compile($tplfile, $compiledfile);
	}
	return $compiledfile;
}

function showmsg($msg,$url='goback')
{
	global $CFG,$charset,$L;
    include template('mess');
	exit();
}

function siteclose($msg,$url='goback')
{
	global $CFG,$charset,$L;
    include template('close');
	exit();
}

function clear_caches($type = 'phpcache', $ext = '')
{
    $dirs = array();
    $tmp_dir = 'data';
    
    if ($type=='phpcache') {
        $dirs = array(AWEBCOM_ROOT . $tmp_dir . '/phpcache/');
    }  elseif ($type=='sqlcache') {
        $dirs = array(AWEBCOM_ROOT . $tmp_dir . '/sqlcache/');
    } elseif ($type=='compiled') {
        $dirs = array(AWEBCOM_ROOT . $tmp_dir . '/compiled/');
    }
    $str_len = strlen($ext);
    $count   = 0;

    foreach ($dirs AS $dir) {
        $folder = @opendir($dir);

        if ($folder === false) {
            continue;
        }
        while ($file = readdir($folder)) {
            if ($file == '.' || $file == '..' || $file == 'index.htm' || $file == 'index.html') {
                continue;
            }
            if (is_file($dir . $file)) {
                /* If it is determined whether there is a file name matching */
                $pos = strrpos($file, '.');

                if ($str_len > 0 && $pos !== false) {
                    $ext_str = substr($file, 0, $pos);

                    if ($ext_str == $ext) {
                        if (@unlink($dir . $file)) {
                            $count++;
                        }
                    }
                } else {
                    if (@unlink($dir . $file)) {
                        $count++;
                    }
                }
            }
        }
        closedir($folder);
    }
    return $count;
}

function get_cat_array()
{
	global $db, $table;
	$data = read_cache('cat_array');
	if ($data === false) {
		$sql = "select catid,catname from {$table}category order by catid ";
		$res = $db->query($sql);
		while($row=$db->fetchrow($res)) {
			$cat_array[$row['catid']] = $row['catname'];
		}
		write_cache('cat_array', $cat_array);
	} else {
		$cat_array = $data;
	}
	return $cat_array;
}

function get_parent_cat()
{
	global $db,$table;
	
	$data = read_cache('parent_cat');
	if ($data === false) {
		$sql = "select catid,catname from {$table}category where parentid = '0' ";
		$res = $db->query($sql);
		while($row=$db->fetchrow($res)) {
			$parent_cat[] = $row;
		}
		write_cache('parent_cat', $parent_cat);
	} else {
		$parent_cat = $data;
	}
	return $parent_cat;
}

function get_cat_list()
{
	global $db,$table;
	
	static $cats = NULL;
	if ($cats === NULL) {
		$data = read_cache('cat_list');
		if ($data === false) {
			$sql = "select a.catid, a.catname, a.catorder as catorder ,b.catid as childid, b.catname as childname, b.catorder as chiorder from {$table}category as a left join {$table}category as b on b.parentid = a.catid where a.parentid = '0' order by catorder,a.catid,chiorder asc";
			$res = $db->getAll($sql);

			$cats = array();
			foreach ($res as $row) {
				$cats[$row['catid']]['catid']   = $row['catid'];
				$cats[$row['catid']]['catname'] = $row['catname'];
				$cats[$row['catid']]['caturl']  = url_rewrite('category',array('cid'=>$row[catid]));

				if(!empty($row['childid'])) {
					$cats[$row['catid']]['children'][$row['childid']]['id']   = $row['childid'];
					$cats[$row['catid']]['children'][$row['childid']]['name'] = $row['childname'];
					$cats[$row['catid']]['children'][$row['childid']]['url']  = url_rewrite('category',array('cid'=>$row[childid]));
				}
			}
			write_cache('cat_list', $cats);
		} else {
			$cats = $data;
		}
	}
	return $cats;
}

function cat_options($selectid='',$catid='')
{
	$cats = get_cat_list();
	if($catd){$cats = $cats[$catid];}
	foreach((array)$cats as $cat) {
		$option .= "<option value=$cat[catid] style='color:red;'";
		$option .= ($selectid == $cat['catid']) ? " selected='selected'" : '';
		$option .= ">$cat[catname]</option>";

		if(!empty($cat['children'])) {
			foreach($cat['children'] as $chi) {
				$option .= "<option value=$chi[id]";
				$option .= ($selectid == $chi['id']) ? " selected='selected'" : '';
				$option .= ">&nbsp;&nbsp;|--$chi[name]</option>";
			}
		}
	}
	return $option;
}

function get_cat_children($catid,$type='int')
{
	$cats = get_cat_list();
	$cat_children = $cats[$catid]['children'];
	if(is_array($cat_children)) {
		if($type=='int') {
			foreach($cat_children as $child) {
				$id .= $child['id'].',';
			}
			$result = substr($id,0,-1);
		} elseif($type=='array') {
			$result = $cat_children;
		}
	} else {
		if($type=='int') {
			$result = $catid;
		} elseif($type=='array') {
			$result = '';
		}
	}
	return $result;
}

function get_cat_info($catid)
{
	global $db,$table;
	
	$data = read_cache('cat_'.$catid);
	if ($data === false) {
		$sql = "select * from {$table}category where catid='$catid' ";
		$cat_info = $db->getRow($sql);
		write_cache('cat_'.$catid, $cat_info);
	} else {
		$cat_info = $data;
	}
	return $cat_info;
}

function get_area_array()
{
	global $db, $table;
	$data = read_cache('area_array');
	if ($data === false) {
		$sql = "select areaid,areaname from {$table}area order by areaid ";
		$res = $db->query($sql);
		while($row=$db->fetchrow($res)) {
			$area_array[$row['areaid']] = $row['areaname'];
		}
		write_cache('area_array', $area_array);
	} else {
		$area_array = $data;
	}
	return $area_array;
}

function get_parent_area()
{
	global $db,$table;
	
	$data = read_cache('parent_area');
	if ($data === false) {
		$sql = "select areaid,areaname from {$table}area where parentid = '0' ";
		$res = $db->query($sql);
		while($row=$db->fetchrow($res)) {
			$parent_area[] = $row;
		}
		write_cache('parent_area', $parent_area);
	} else {
		$parent_area = $data;
	}
	return $parent_area;
}

function get_area_list()
{
	global $db,$table;
	
	static $areas = NULL;
	if ($areas === NULL) {
		$data = read_cache('area_list');
		if ($data === false) {
			$sql = "select a.areaid, a.areaname, a.areaorder as catorder,b.areaid as childid, b.areaname as childname, b.areaorder as chiorder from {$table}area as a left join {$table}area as b on b.parentid = a.areaid where a.parentid = '$area' order by catorder,a.areaid,chiorder asC"; 
			$res = $db->getAll($sql);

			$areas = array();
			foreach ($res as $row) {
				$areas[$row['areaid']]['areaid']   = $row['areaid'];
				$areas[$row['areaid']]['areaname'] = $row['areaname'];
				$areas[$row['areaid']]['url']  = url_rewrite('category',array('eid'=>$row[areaid]));

				if($row['childid'] != NULL) {
					$areas[$row['areaid']]['children'][$row['childid']]['id']   = $row['childid'];
					$areas[$row['areaid']]['children'][$row['childid']]['name'] = $row['childname'];
					$areas[$row['areaid']]['children'][$row['childid']]['url']  = url_rewrite('category',array('eid'=>$row[childid]));
				}
			}
			write_cache('area_list', $areas);
		} else {
			$areas = $data;
		}
	}
	return $areas;
}

function area_options($selectid='')
{
	$area = get_area_list();
	foreach($area as $area) {
		$option .= "<option value=$area[areaid] style='color:red;'";
		$option .= ($selectid == $area['areaid']) ? " selected='selected'" : '';
		$option .= ">$area[areaname]</option>";

		if(!empty($area['children'])) {
			foreach($area['children'] as $chi) {
				$option .= "<option value=$chi[id]";
				$option .= ($selectid == $chi['id']) ? " selected='selected'" : '';
				$option .= ">&nbsp;&nbsp;|--$chi[name]</option>";
			}
		}
	}
	return $option;
}

function get_area_children($areaid,$type='int')
{
	$areas = get_area_list();
	$area_children = $areas[$areaid]['children'];
	if(is_array($area_children)) {
		if($type=='int') {
			if(is_array($area_children)) {
				foreach($area_children as $child) {
					$id .= $child['id'].',';
				}
			}
			$result = substr($id,0,-1);
		} elseif($type=='array') {
			$result = $area_children;
		}
	} else {
		if($type=='int') {
			$result = $areaid;
		} elseif($type=='array') {
			$result = '';
		}
	}
	return $result;
	
}

function get_area_info($areaid)
{
	global $db,$table;
	
	$data = read_cache('area_'.$areaid);
	if ($data === false) {
		$sql = "select * from {$table}area where areaid='$areaid' ";
		$area_info = $db->getRow($sql);
		write_cache('area_'.$areaid, $area_info);
	} else {
		$area_info = $data;
	}
	return $area_info;
}

function get_config()
{
	global $db,$table;

	$data = read_cache('webconfig');
    if ($data === false) {
		$sql = "select setname,value from {$table}config";
		$res = $db->query($sql);

		while($row=$db->fetchRow($res)) {
			$config[$row['setname']] = $row['value'];
			if($row['setname']=='icq' && $row['value']) {
				//$config[$row['setname']] = explode('|', $row['value']);
			}
		}
		write_cache('webconfig', $config);
	} else {
		$config = $data;
	}
	return $config;
}

function get_infout()
{
	global $db,$table;
	$sql = "SELECT setname,value FROM {$table}infout";
	$res = $db->query($sql);
	while($row=$db->fetchRow($res))
	{
		$arr[$row['setname']] = $row['value'];

	}

	return $arr;
}

function get_link_list()
{
	global $db,$table;
	
	$result['image'] = array();
	$result['txt']  = array();
	
	$data = read_cache('link');
    if ($data === false) {
		$sql = "select * from {$table}link $where order by linkorder,id";
		$row = $db->getAll($sql);
		foreach($row as $link) {
			if($link['logo']) {
				$links['image'][] = $link;
			} else {
				$links['txt'][]  = $link;
			}
		}
		write_cache('link', $links);
	} else {
		$links = $data;
	}
	return $links;
}

function get_info($cat='',$area='',$num='10',$protype='',$listtype='',$len='50',$thumb='', $dateformat='Y-m-d')
{
	global $db,$table;
	
	$where = "where is_check=1 and (enddate='0' or enddate >= ".time().")";

	if(!empty($cat)) {
		$where .= " and i.catid in ($cat)";
	}
	if(!empty($area)) {
		$where .= " and i.areaid in ($area)";
	}
	if($thumb=='1') {
		$where .= " and thumb != '' ";
	}

	if(!empty($protype)) {
		switch($protype) {
			case 'pro':
				$where .= " and is_pro >=".time();
			break;
			
			case 'top':
				$where .= " and is_top >=".time();
			break;
		}
	}

	if(!empty($listtype)) {
		switch($listtype) {
			case 'date':
				$order = " order by postdate desc";
			break;
			
			case 'click':
				$order = " order by click desc, id desc ";
			break;
		}
	}
	if(empty($order)) $order = "order by postdate desc";
	$limit = " LIMIT 0,$num ";
	$sql = "select i.id,i.title,i.postdate,i.thumb,i.price,i.unit,i.description,i.content,i.catid,i.areaid,c.catname,a.areaname from {$table}info as i left join {$table}category as c on i.catid = c.catid left join {$table}area as a on a.areaid = i.areaid $where $order $limit";
	$res = $db->query($sql);
	$info = array();
	while($row=$db->fetchRow($res)) {
		$row['title']    = cut_str($row['title'], $len);
		$row['postdate'] = date($dateformat, $row['postdate']);
		$row['url']      = url_rewrite('view',array('vid'=>$row['id']));
		$row['caturl']   = url_rewrite('category',array('cid'=>$row['catid']));
		$row['areaurl']  = url_rewrite('category',array('eid'=>$row['areaid']));
		$info[]          = $row;
	}
	return $info;
}

function get_slider()
{
	global $db,$table;

	$data = read_cache('slider');
    if ($data === false) {
		$sql = "select * from {$table}slider order by flaorder,id";
		$slider = $db->getAll($sql);
		write_cache('slider', $slider);
	} else {
		$slider = $data;
	}
	return $slider;
}


function get_flashtt()
{
	global $db,$table;

	$data = read_cache('flash');
    if ($data === false) {
		$sql = "select * from {$table}flash order by flaorder,id";
		$res = $db->query($sql);
		$result = array();
		while($row = $db->fetchRow($res)) {
			$image .= $row['image'] . '|';
			$url   .= $row['url'] . '|';
		}
		if(!empty($image) && !empty($url)) {
			$flash['image'] = substr($image,0,-1);
			$flash['url']   = substr($url,0,-1);
		}
		write_cache('flash', $flash);
	} else {
		$flash = $data;
	}
	return $flash;
}

function get_nav()
{
	global $db,$table;
	
	$data = read_cache('nav');
    if ($data === false) {
		$sql = "select * from {$table}nav order by navorder";
		$nav = $db->getAll($sql);
		write_cache('nav', $nav);
	} else {
		$nav = $data;
	}
	return $nav;
}

function get_info_custom($infoid)
{
	global $db,$table;

	$sql = "select a.cusid, a.cusname, a.unit, g.cusvalue from {$table}cus_value as g left join {$table}custom as a on a.cusid = g.cusid where g.infoid = '$infoid' order by a.listorder, a.cusid";
    $res = $db->query($sql);
	$cus = array();
    while($row = $db->fetchRow($res)) {
		$arr['name']  = $row['cusname'];
		$arr['value'] = $row['cusvalue'];
		$arr['unit']  = $row['unit'];
		$cus[] = $arr;
    }
    return $cus;
}

function get_custom_info($cusid='')
{
	global $db,$table;
	
	$data = read_cache('custom');
	if($data===false) {
		$sql = "select * from {$table}custom where cusid='$cusid' ";
		$res = $db->query($sql);
		while($row = $db->fetchrow($res)) {
			$custom_info[$row['cusid']] = $row;
		}
		write_cache('custom', $custom_info);
	} else {
		$custom_info = $data;
	}
	return $custom_info[$cusid];
}

function get_cat_custom($catid)
{
	global $db,$table;
	
	$data = read_cache('cat_custom_'.$catid);
    if ($data === false) {
		$cat_info = $db->getOne("select parentid from {$table}category where catid='$catid'");
		if($cat_info['parentid']) {
			$parentid = $cat_info['parentid'];
			$sql = "select cusid, cusname, custype, value, search, listorder, unit from {$table}custom  where  catid = '$parentid' order by catid, listorder asc";
			$parent_cat_custom = $db->getAll($sql);
		}
		$sql = "select cusid, cusname, custype, value, search, listorder, unit from {$table}custom  where  catid = '$catid' order by catid, listorder asc";
		$cat_custom = $db->getAll($sql);
		if($parent_cat_custom)$cat_custom = array_merge($parent_cat_custom, $cat_custom);
		write_cache('cat_custom_'.$catid, $cat_custom);
	} else {
		$cat_custom = $data;
	}
	
	return $cat_custom;
}
//функция доп. полей добавления информации
function cat_post_custom($catid,$id='')
{
	global $db,$table, $L;

	if(empty($catid))return array();
	if(!empty($id)) {
		$sql = "select c.*,v.* from {$table}custom as c left join {$table}cus_value as v on c.cusid=v.cusid left join {$table}info as i on i.id=v.infoid where i.id='$id' ";
		$res = $db->query($sql);
		while($row=$db->fetchrow($res)) {
			$info_cus[$row[cusid]] = $row;
		}
	}
    $customs = get_cat_custom($catid);
    if(empty($customs))return false;
	
    foreach ($customs as $key => $val)  {
		$info_cus_value = $info_cus[$val['cusid']];
		//подключем класс для инпута и задаем размер
        if ($val['custype'] == 0) {
            $val['html'] .= "<input name='cus_value[$val[cusid]]' type='text' class='text-input dark-color light-bg' value='" .htmlspecialchars($info_cus_value['cusvalue']). "' style='width:300px;' /> ";
            $val['html'] .= "<p class=\"middle-color\">$val[unit]</p>";
			//конец подключения класа
        } elseif ($val['custype'] == 1) {
		//подключем класс для селекта и задаем размер
            $val['html'] .= '<div class="custom-selectbox dark-color light-gradient active-hover" style="width:200px;">';
            $val['html'] .= '<select name="cus_value['.$val['cusid'].']">';
            $val['html'] .= '<option value="">'.$L['select'].'</option>';
            $cusvalues = explode("\n", $val['value']);
            foreach($cusvalues as $opt) {
                $opt = trim(htmlspecialchars($opt));
                $val['html'] .= ($info_cus_value['cusvalue'] != $opt) ?
                    '<option value="' . $opt . '">' . $opt . '</option>' :
                    '<option value="' . $opt . '" selected="selected">' . $opt . '</option>';
            }
            $val['html'] .= "</select>";
            $val['html'] .= "</div>";
            $val['html'] .= "<p class=\"middle-color\">$val[unit]</p>";
			//конец подключения класа
        } elseif ($val['custype'] == 2) {
            $cusvalues = explode("\n", $val['value']);
			$info_cusvalue = explode(",", $info_cus_value['cusvalue']);
			
            foreach($cusvalues as $opt) {
                $opt = trim(htmlspecialchars($opt));
				$a = in_array($opt,$info_cusvalue) ?  "checked=checked" : '';
		      //подключем класс для чекбокса
                //$val['html'] .= '<li class="custom-checkbox middle-color active-hover">';
                $val['html'] .= '<input type="checkbox" value="' . $opt . '" name="cus_value['.$val['cusid'].'][]" '.$a.' >'. $opt;
                //$val['html'] .= "</li>";
            }
                $val['html'] .= "<p class=\"middle-color\">$val[unit]</p>";
        }
		$result[$val['cusid']]['cusname'] = $val['cusname'];
		$result[$val['cusid']]['html'] = $val['html'];
		$result[$val['cusid']]['unit'] = $val['unit'];

    }
    return $result;
}
//доп. поля в поиске
function cat_search_custom($catid='')
{
	global $db,$table,$L;

	if(empty($catid))return array();
	$customs = get_cat_custom($catid);
	foreach($customs as $row) {
		if($row['search']=='0')continue;
		
		if($row['custype'] == '1' || $row['custype'] == '2') {
			$row['value'] = str_replace("\r", '', $row['value']);
			$options = explode("\n", $row['value']);
			$cusvalue = array();
			foreach($options as $opt) {
				$cusvalue[$opt] = $opt;
			}
			$custom[] = array(
				'id' => $row['cusid'],
				'cusname' => $row['cusname'],
				'options' => $cusvalue,
				'search' => $row['search'],
				'unit' => $row['unit'],
				'type' => $row['custype']
				);
		} else {
			$custom[] = array(
				'id' => $row['cusid'],
				'cusname' => $row['cusname'],
				'search' => $row['search'],
				'unit' => $row['unit'],
				'type' => $row['custype']
				);
		}
	}
	if($custom) {
		foreach($custom as $cus) {
			if($cus['type']=='0') {
				if($cus['search']=='2') {
					$cus['html'] = '<br/><input name=custom['.$cus['id'].'][from] value="" type=text maxlength=5 class="text-input dark-color light-bg" style="width:70px;"> - <input name=custom['.$cus['id'].'][to] type=text value="" maxlength=5 class="text-input dark-color light-bg" style="width:70px;">';
				} else {
					$cus['html'] = '<br/><input name="custom['.$cus['id'].']"  type="text" maxlength="120" class="text-input dark-color light-bg" style="width:150px;"/>';
				}
			} elseif($cus['type']=='1') {
		       //подключем класс для селекта и задаем размер
				$cus['html'] = "<div class='custom-selectbox dark-color light-gradient active-hover' style='width:220px;'><select name=custom[$cus[id]]>
				<option value=0>Выберите</option>";
				foreach($cus['options'] as $opt) {
				    $cus['html'] .= "<option value=\"$opt\">$opt</option>";
				}
				$cus['html'] .= '</select></div>';
			} elseif($cus['type']=='2') {
				foreach($cus['options'] as $opt) {
					$opt = trim(htmlspecialchars($opt));
					$cus['html'] .= '<br/><input type="checkbox" value="' . $opt . '" name="custom['.$cus[id].'][]" >'. $opt;
				}
			}
			$result[] = $cus;
		}
	}
    return $result;
}

function ads_list($placeid='')
{
	global $db,$table,$CFG;

	if(empty($placeid))return'';
	$weburl = $CFG['weburl'];

	$sql = "select a.*,p.width,p.height from {$table}ads as a left join {$table}ads_place as p on a.placeid=p.placeid where a.placeid = '$placeid' ";
	$res = $db->query($sql);
	$ads = array();
	while($row=$db->fetchrow($res)) {
		$adscode = '';
		switch ($row['adstype'])
		{
			case '1':
				$adscode = "<a href=$row[adsurl] target=\"_blank\">" . nl2br(htmlspecialchars(addslashes($row['adscode']))). "</a>";
			break;

			case '2':
				$src = (strpos($row['adcode'], 'http://') === false && strpos($row['adcode'], 'https://') === false) ? $weburl . "/$row[adscode]" : $row['adscode'];
				$adscode = "<a href=".$row['adsurl']." target=\"_blank\">" . "<img src=".$src." border=\"0\" width=".$row['width']." height=".$row['height']." alt=\"".$row['adsname']."\" /></a>";
			break;

			case '3':
				$src = (strpos($row['adscode'], 'http://') === false && strpos($row['adscode'], 'https://') === false) ? $weburl . '/' . $row['adscode'] : $row['adscode'];
				$adscode = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="'.$row['width'].'" height="'.$row['height'].'"> <param name="movie" value="'.$src.'"><param name="quality" value="high"><embed src="'.$src.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="'.$row['width'].'" height="'.$row['height'].'"></embed></object>';
			break;

			case '4':
				$adscode = $row['adscode'];
			break;
		}
		$ads[] = $adscode;
	}
	include template('ads');
}

function template_compile($tplfile,$tplcachefile)
{
	$str = file_get_contents($tplfile);
	$str = template_parse($str);
	$strlen = file_put_contents($tplcachefile, $str);
	@chmod($tplcachefile, 0777);
	return $strlen;
}

function template_parse($tpl)
{
	$tpl = preg_replace("/([\n\r]+)\t+/s","\\1",$tpl);
	$tpl = preg_replace("/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}",$tpl);
	$tpl = preg_replace("/\{template\s+(.+)\}/","\n<?php include template(\\1); ?>\n",$tpl);
	$tpl = preg_replace("/\{include\s+(.+)\}/","\n<?php include \\1; ?>\n",$tpl);
	$tpl = preg_replace("/\{php\s+(.+)\}/","\n<?php \\1?>\n",$tpl);
	$tpl = preg_replace("/\{if\s+(.+?)\}/","<?php if(\\1) { ?>",$tpl);
	$tpl = preg_replace("/\{else\}/","<?php } else { ?>",$tpl);
	$tpl = preg_replace("/\{elseif\s+(.+?)\}/","<?php } elseif (\\1) { ?>",$tpl);
	$tpl = preg_replace("/\{\/if\}/","<?php } ?>",$tpl);
	$tpl = preg_replace("/\{loop\s+(\S+)\s+(\S+)\}/","<?php if(is_array(\\1)) foreach(\\1 AS \\2) { ?>",$tpl);
	$tpl = preg_replace("/\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}/","\n<?php if(is_array(\\1)) foreach(\\1 AS \\2 => \\3) { ?>",$tpl);
	$tpl = preg_replace("/\{\/loop\}/","\n<?php } ?>\n",$tpl);
	$tpl = preg_replace("/\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*\(([^{}]*)\))\}/","<?php echo \\1;?>",$tpl);
	$tpl = preg_replace("/\{\\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*\(([^{}]*)\))\}/","<?php echo \\1;?>",$tpl);
	$tpl = preg_replace("/\{(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}/","<?php echo \\1;?>",$tpl);
	$tpl = preg_replace("/\{(\\$[a-zA-Z0-9_\[\]\'\"\$\x7f-\xff]+)\}/es", "addquote('<?php echo \\1;?>')",$tpl);
	$tpl = preg_replace("/\{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)\}/s", "<?php echo \\1;?>",$tpl);
	$tpl = "<?php if(!defined('IN_AWEBCOM'))die('Access Denied'); ?>".$tpl;
	return $tpl;
}

function addquote($var)
{
	return str_replace("\\\"", "\"", preg_replace("/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var));
}

if (!function_exists('file_get_contents'))
{
    function file_get_contents($file)  {
        if (($fp = @fopen($file, 'rb')) === false) {
            return false;
        } else {
            $fsize = @filesize($file);
            if ($fsize) {
                $contents = fread($fp, $fsize);
            } else {
                $contents = '';
            }
            fclose($fp);

            return $contents;
        }
    }
}

if (!function_exists('file_put_contents'))
{
    define('FILE_APPEND', 'FILE_APPEND');

    function file_put_contents($file, $data, $flags = '') {
        $contents = (is_array($data)) ? implode('', $data) : $data;

        if ($flags == 'FILE_APPEND') {
            $mode = 'ab+';
        } else {
            $mode = 'wb';
        }

        if (($fp = @fopen($file, $mode)) === false) {
            return false;
        } else {
            $bytes = fwrite($fp, $contents);
            fclose($fp);

            return $bytes;
        }
    }
}

function read_cache($filename)
{
    $result = array();
    if (!empty($result[$filename])) {
        return $result[$filename];
    }
    $filepath = AWEBCOM_ROOT . 'data/phpcache/' . $filename . '.php';
    if (file_exists($filepath)) {
        include_once($filepath);
        $result[$filename] = $data;
        return $result[$filename];
    } else {
        return false;
    }
}


function write_cache($filename, $val)
{
    $filepath = AWEBCOM_ROOT . 'data/phpcache/' . $filename . '.php';
    $content  = "<?php\r\n";
    $content .= "\$data = " . var_export($val, true) . ";\r\n";
    $content .= "?>";
    file_put_contents($filepath, $content, LOCK_EX);
}

function get_url()
{
	$php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
	$php_domain = $_SERVER['SERVER_NAME'];
	$php_agent = $_SERVER['HTTP_USER_AGENT'];
	$php_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
	$php_scheme = $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
	$php_reuri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
	$php_port = $_SERVER['SERVER_PORT'] == '80' ? '' : ':'.$_SERVER['SERVER_PORT'];
	$host_url = $php_scheme . $php_domain . $php_port;
	$site_url = $host_url . substr($php_self, 0, strrpos($php_self, '/'));
	$site_url = str_replace('/install', '', $site_url);
	$site_url = str_replace('/admin', '', $site_url);
	return $site_url;
}

function check_words($who=array())
{
	global $CFG,$L;

	if(!empty($CFG['banwords'])) {
		$ban = explode('|',$CFG['banwords']);
		$count = count($ban);
		for($i=0;$i<$count;$i++){
			foreach($who as $val) {
				if(strstr($val,$ban[$i])){
					showmsg($L['check_words']);
				}
			}
		}
	}
}

function CreateSmallImage( $OldImagePath, $NewImagePath, $NewWidth=154, $NewHeight=134) 
{
	$OldImageInfo = getimagesize($OldImagePath); 
	if ( $OldImageInfo[2] == 1 ) $OldImg = @imagecreatefromgif($OldImagePath); 
	elseif ( $OldImageInfo[2] == 2 ) $OldImg = @imagecreatefromjpeg($OldImagePath); 
	else $OldImg = @imagecreatefrompng($OldImagePath);
	$NewImg = imagecreatetruecolor( $NewWidth, $NewHeight ); 

	//red(0-255),green(0-255),blue(0-255) 
	$black = ImageColorAllocate( $NewImg, 0, 0, 0 ); 
	$white = ImageColorAllocate( $NewImg, 255, 255, 255 ); 
	$red   = ImageColorAllocate( $NewImg, 255, 0, 0 ); 
	$blue  = ImageColorAllocate( $NewImg, 0, 0, 255 );  
	$other = ImageColorAllocate( $NewImg, 0, 255, 0 );

	$WriteNewWidth = $NewHeight*($OldImageInfo[0] / $OldImageInfo[1]); 
	$WriteNewHeight = $NewWidth*($OldImageInfo[1] / $OldImageInfo[0]); 
	
	if ($OldImageInfo[0] / $NewWidth > $org_info[1] / $NewHeight) {
		$WriteNewWidth  = $NewWidth;
		$WriteNewHeight  = $NewWidth / ($OldImageInfo[0] / $OldImageInfo[1]);
	} else {
		$WriteNewWidth  = $NewHeight * ($OldImageInfo[0] / $OldImageInfo[1]);
		$WriteNewHeight = $NewHeight;
	}
	if ( $WriteNewWidth <= $NewWidth ) {
		$WriteNewWidth = $WriteNewWidth; 
		$WriteNewHeight = $NewHeight; 
		$WriteX = floor( ($NewWidth-$WriteNewWidth) / 2 ); 
		$WriteY = 0; 
	} else { 
		$WriteNewWidth = $NewWidth; 
		$WriteNewHeight = $WriteNewHeight; 
		$WriteX = 0; 
		$WriteY = floor( ($NewHeight-$WriteNewHeight) / 2 ); 
	} 
	@imagecopyresampled( $NewImg, $OldImg, $WriteX, $WriteY, 0, 0, $WriteNewWidth, $WriteNewHeight, $OldImageInfo[0], $OldImageInfo[1] ); 
	@imagegif( $NewImg, $NewImagePath ); 
	@imagedestroy($NewImg); 
}


function login($username, $password)
{
	global $db,$table,$CFG;

	if (check_user($username, $password) > 0) {
		set_session($username);
		set_cookie($username);
		return true;
	} else {
		set_session();
		set_cookie();
		return false;
	}
}

function check_user($username, $password = '')
{
	global $db,$table,$CFG;
	if($password == '') {
		$sql = "select userid FROM {$table}member WHERE username = '$username'";
	} else {
		$sql = "select userid FROM {$table}member WHERE username = '$username' AND password ='$password'";
	}
	return $db->getOne($sql);
}

function logout()
{
	set_session();
	set_cookie();
}

function set_session ($username='')
{
	global $db,$table,$CFG;

	if (empty($username)) {
		$_SESSION['userid']   = '';
		$_SESSION['username']  = '';
		$_SESSION['password']  = '';
	} else {
		$sql = "SELECT userid, password, email , lastlogintime , sendmailtime FROM {$table}member WHERE username='$username' LIMIT 1";
		$row = $db->getRow($sql);

		if($row) {
			$_SESSION['userid']   = $row['userid'];
			$_SESSION['username']  = $username;
			$_SESSION['password']  = $row['password'];
		}
		$time = time();
		$ip = get_ip();
		$db->query("UPDATE {$table}member SET lastlogintime='$time',lastloginip='$ip' where username = '$username' ");
	}
}

function set_cookie($username='', $remember= null )
{
	if (empty($username)) {
		$time = time() - 3600;
		setcookie("userid",  '', $time);            
		setcookie("password", '', $time);

	} elseif ($remember) {
		$time = time() + 3600 * 24 * 15;

		setcookie("username", $username, $time);
		$sql = "SELECT userid, password FROM {$table}member WHERE username='$username' LIMIT 1";
		$row = $db->getRow($sql);
		if ($row) {
			setcookie("userid", $row['userid'], $time);
			setcookie("password", $row['password'], $time);
		}
	}
}

function register($username, $password, $email)
{
	global $db,$table,$CFG,$L;

	if (check_user($username) > 0) {
		showmsg("".$L['f_login']." $username ".$L['already_exists_database']."");
	}
	$sql = "select userid FROM {$table}member  WHERE email = '$email'";
	if ($db->getOne($sql) > 0) {
		showmsg("E-mail $email ".$L['already_exists_database']."");
	}

	$time = time();
	$ip = get_ip();
	$status = $CFG['reg_check'] == 1 ? 0 : 1;
	$sql = "INSERT INTO {$table}member (username,password,email,registertime,registerip,lastlogintime,status) VALUES ('$username','$password','$email','$time','$ip','$time', '$status')";
	$res = $db->query($sql);

	if($res) {
		set_session($username);
		set_cookie($username);
		return true;
	} else {
		set_session();
		set_cookie();
		return false;
	}
}


function get_ver()
{
	global $db,$table;

	$data = read_cache("ver");
	if($data === false) {
		$sql = "select * from {$table}ver order by vid";
		$res = $db->query($sql);
		while($r = $db->fetchrow($res)) {
			$ver[$r['vid']] = $r;
		}
		write_cache('ver', $ver);
	} else {
		$ver = $data;
	}
	return $ver;
}

function get_one_ver()
{
	$ver = get_ver();
	$verf = array_rand($ver);
	$verf = $ver[$verf];
	return $verf;
}

function check_ver($vid,$answer='')
{
	global $L;
	if($answer=='') showmsg($L['f_enter_answer_question']);
	$ver = get_ver();
	$verf = $ver[$vid];
	if($answer != $verf['answer'])showmsg($L['f_answer_wrong']);
}
//Здесь навигация по умолчнаию. разделитель: ->
function yget_here($here_arr=array())
{
	global $L;
	$here = '<a href="'.AWEBCOM_PATH.'">'.$L['f_home'].'</a>';
	foreach($here_arr as $val) {
		if(!empty($val['url']) && !empty($val['name'])) {
			$here .= ' -> <a href="'.$val['url'].'">' . $val['name'] . '</a>';
		} elseif (empty($val['url']) && !empty($val['name'])) {
			$here .= ' -> '. $val['name'];
		}
	}
	return $here;
}
//Здесь добавлены стили навигации в шаблоне по дефолту
function get_here($here_arr=array())
{
	global $L;
	$here = '<a href="'.AWEBCOM_PATH.'" class="dark-color active-hover">'.$L['f_home'].'</a>';
	foreach($here_arr as $val) {
		if(!empty($val['url']) && !empty($val['name'])) {
			$here .= '<a href="'.$val['url'].'" class="dark-color active-hover">'.$val['name'].'</a>';
		} elseif (empty($val['url']) && !empty($val['name'])) {
			$here .= '<strong class="active-color">'. $val['name'].'</strong>';
		}
	}
	return $here;
}

function inserttable($tablename, $insertsqlarr, $returnid=0, $replace = false, $silent=0) 
{
	global $db,$table;

	$insertkeysql = $insertvaluesql = $comma = '';
	foreach ($insertsqlarr as $insert_key => $insert_value) {
		$insertkeysql .= $comma.'`'.$insert_key.'`';
		$insertvaluesql .= $comma.'\''.$insert_value.'\'';
		$comma = ', ';
	}
	$method = $replace?'REPLACE':'INSERT';
	$db->query($method.' INTO '.$table.$tablename.' ('.$insertkeysql.') VALUES ('.$insertvaluesql.')', $silent?'SILENT':'');
	if($returnid && !$replace) {
		return $db->insert_id();
	}
}

function updatetable($tablename, $setsqlarr, $wheresqlarr, $silent=0) 
{
	global $db,$table;

	$setsql = $comma = '';
	foreach ($setsqlarr as $set_key => $set_value) {
		if(is_array($set_value)) {
			$setsql .= $comma.'`'.$set_key.'`'.'='.$set_value[0];
		} else {
			$setsql .= $comma.'`'.$set_key.'`'.'=\''.$set_value.'\'';
		}
		$comma = ', ';
	}
	$where = $comma = '';
	if(empty($wheresqlarr)) {
		$where = '1';
	} elseif(is_array($wheresqlarr)) {
		foreach ($wheresqlarr as $key => $value) {
			$where .= $comma.'`'.$key.'`'.'=\''.$value.'\'';
			$comma = ' AND ';
		}
	} else {
		$where = $wheresqlarr;
	}
	$db->query('UPDATE '.$table.$tablename.' SET '.$setsql.' WHERE '.$where, $silent?'SILENT':'');
}

function html_select($name, $arr, $selectid='')
{
	$option = "<select name=\"$name\" id=\"$name\">";
	foreach($arr as $key=>$val) {
		$option .= "<option value=$key";
		$option .= ($selectid == $key) ? " selected='selected'" : '';
		$option .= ">$val</option>";
	}
	$option .= "</select>";
	return $option;
}

function member_info($data,$type='1')
{
	global $db,$table;
	
	if($type=='1') {
		$userid = intval($data);
		$info = $db->getRow("select * from {$table}member where userid='$userid' ");
	} elseif($type=='2') {
		$username = trim($data);
		$info = $db->getRow("select * from {$table}member where username='$username' ");
	}
	return $info;
}
//письмо с инструкциями восстановдения пароля
function send_pwd_email($userid, $username, $email, $code)
{
	global $CFG, $L;
    if (empty($userid) || empty($username) || empty($email) || empty($code)) {
        header("Location: member.php?act=get_password\n");
        exit;
    }
    $reset_email = AWEBCOM_PATH . 'member.php?act=get_password&userid=' . $userid . '&code=' . $code;
	$send_date = date('Y-m-d-H-i', time());
	require_once AWEBCOM_ROOT.'include/cont.phpmailer.php';
    $content = "".$L['respected']." $username<br>".$L['send_pwd_email_content']." <strong>".$CFG['webname']."</strong><br>".$L['to_recover_your_password']." <a href=\"$reset_email\" target=\"_blank\">".$L['go_to_link']."</a> ".$L['copy_to_link'].":<br>".$reset_email."<br>".$L['ignore_this_message']."<br>".$L['dispatch_date'].": ".$send_date."";
		$mail             = new PHPMailer();
		$body             = "$content";
		$body = stripslashes($body);
		$mail->IsMail(); 
		$mail->From       = "$CFG[noreplymail]";
		$mail->FromName   = "".$L['administrator']."";
		$mail->Subject    = "".$L['password_reset']." $CFG[webname]";
		$mail->MsgHTML($body);
		$mail->AddAddress("$email", "$username");
		if ($mail->Send() ) {
        return true;
    } else {
        return false;
    }
}

function get_pay_setting($condition = 'enable=1') {
	global $db,$table;
	$data = read_cache('pay_setting');
	if($data === false) {
		$sql = "select * from {$table}payment WHERE $condition order by payorder,id";
		$res = $db->query($sql);
		while($row = $db->fetchrow($res)) {
			$pay[$row['paycenter']] = $row;
		}
		write_cache('pay_setting', $pay);
	} else {
		$pay = $data;
	}
	return $pay;
}

function get_static()
{
	global $db,$table;
	$sql = "SELECT id,title,type FROM {$table}static WHERE is_show=1 ORDER BY id ASC";
	$res = $db->query($sql);
	while($row = $db->fetchrow($res)) {
		$row['url'] = url_rewrite('static', array('aid'=>$row['id']));
		$statics[] = $row;
	}
	return $statics;
}

function getInfo($infoid)
{
	global $db, $table;
	$infoid = intval($infoid);
	if(empty($infoid)) return '';
	$data = $db->getRow("SELECT * FROM {$table}info WHERE id='$infoid'");
	return $data;
}

function addInfo($items, $cusvalue)
{
	global $db, $table;
	if(empty($items)) return '';
	$id = inserttable('info', $items, 1);

	if(isset($cusvalue)) {
		$infoid = $id;
        $cus_value_list = array();

        foreach((array)$cusvalue as $key => $val) {
			if(is_array($val)) {
				$cus_value = implode(",", $val);
			} else {
				$cus_value = $val;
			}
            if(!empty($cus_value)) {
                $cus_value_list[$key] = $cus_value;
            }
        }
        foreach($cus_value_list as $cusid => $cus_value) {
			$db->query("INSERT INTO {$table}cus_value (cusid, infoid, cusvalue) VALUES ('$cusid', '$infoid', '$cus_value')");
        }
    }
	return $id;
}

function editInfo($items, $cusvalue, $id)
{
	global $db, $table;
	if(empty($items)) return '';
	$id = updatetable('info', $items, " id='$id'");
	if (!empty($cusvalue)) {

		$cus_value_list = array();
		$res = $db->query("SELECT * FROM {$table}cus_value WHERE infoid = '$id'");
		while($row = $db->fetchRow($res)) {
			$cus_value_list[$row['cusid']][$row['cusvalue']] = array('query' => 'delete', 'id' => $row['id']);
		}

		foreach((array)$cusvalue AS $key => $val) {
			
			if(is_array($val)) $val=implode(",", $val);
			$cusvalue = $val;

			if(!empty($cusvalue)) {
				if (isset($cus_value_list[$key][$cusvalue])) {
					$cus_value_list[$key][$cusvalue]['query'] = 'update';
				} else {
					$cus_value_list[$key][$cusvalue]['query'] = 'insert';
				}
			}
		}

		foreach ((array)$cus_value_list as $cusid => $value_list) {
			foreach ((array)$value_list as $cusvalue => $infos) {
				if ($infos['query'] == 'insert') {
				   $sql = "INSERT INTO {$table}cus_value (cusid, infoid, cusvalue) VALUES ('$cusid', '$infoid', '$cusvalue')";
				} elseif ($infos['query'] == 'delete') {
					$sql = "DELETE FROM {$table}cus_value WHERE id = '$infos[id]' LIMIT 1";
				} elseif ($infos['query'] == 'update') {
					$sql = "UPDATE {$table}cus_value SET cusvalue='$cusvalue' WHERE id='$infos[id]' ";
				}
				$db->query($sql);
			}
		}
	}
	return true;
}

function delInfo($id)
{
	global $db, $table, $L;

	if(empty($id)) showmsg($L['parameter_error']);
	$db->query("DELETE FROM {$table}comment WHERE infoid IN ($id)");
	
	$thumb = $db->getAll("SELECT thumb FROM {$table}info WHERE id IN ($id)");
	foreach((array)$thumb AS $val){
		if($val != '' && is_file(AWEBCOM_ROOT.$val['thumb'])){
			@unlink(AWEBCOM_ROOT.$val['thumb']);
		}
	}
	$image = $db->getAll("SELECT path FROM {$table}info_image WHERE infoid IN ($id)");
	foreach((array)$image AS $val){
		if($val != '' && is_file(AWEBCOM_ROOT.$val['path'])){
			@unlink(AWEBCOM_ROOT.$val['path']);
		}
	}
	$db->query("DELETE FROM {$table}info_image WHERE infoid IN ($id)");
	$db->query("DELETE FROM {$table}cus_value WHERE infoid IN ($id)");
	$db->query("DELETE FROM {$table}report WHERE info IN ($id)");
	$db->query("DELETE FROM {$table}info WHERE id IN ($id)");

	return true;
}

function getUserGlod($userid)
{
	global $db, $table;
	$sql = "SELECT gold FROM {$table}member WHERE userid='$userid'";
	$gold = $db->getOne($sql);
	return $gold;
}


function getUserMoney($userid)
{
	global $db, $table;
	$sql = "SELECT money FROM {$table}member WHERE userid='$userid'";
	$money = $db->getOne($sql);
	return $money;
}

function getCreditTimes($username, $type)
{
	global $db, $table, $L;
	$credit_times = $db->getOne("SELECT COUNT(*) FROM {$table}pay_exchange WHERE username='$_username' AND addtime>".mktime(0,0,0)." AND note='$type' ");
	return $credit_times;
}

function get_new_comment($num='5')
{
	global $db,$table,$L;
	
	$sql = "select c.*,i.title from {$table}comment as c left join {$table}info as i on i.id=c.infoid where c.is_check=1 group by infoid order by c.id desc,c.postdate desc limit $num";
	$res = $db->query($sql);
	while($row=$db->fetchrow($res)) {
		$row[linkurl] = "comment.php?id=$row[id]";
		$row[title] = cut_str($row[title],'27');
		$row[content] = cut_str($row[content],'80').'...';
		$row['postdate'] = date('Y-m-d', $row['postdate']);
		$row[username] = $row[username]?$row[username]:''.$L['guest'].'';
		if($row[type]=='com') 
		$row['url'] = url_rewrite('com', array('act'=>'view', 'comid'=>$row['infoid']));
		else if($row[type]=='article') {
		$row['url'] = url_rewrite('article', array('aid'=>$row['infoid'],'act'=>'view'));
		} else {
		$row[url] = url_rewrite('view',array('vid'=>$row['infoid']));
		}
		$comments[] = $row;
	}
	return $comments;
}

function get_index_help($num='5')
{
	global $db,$table;

	$sql = "select id,title from {$table}help where is_index=1 order by addtime asc limit $num ";
	$helps = $db->getAll($sql);
	$result = array();
	foreach((array)$helps as $row) {
		$row['url'] = url_rewrite('help',array('act'=>'view','hid'=>$row['id']));
		$result[] = $row;
	}
	return $result;
}

function get_index_com($num='6')
{
	global $db,$table;
	
	$order = array('comid', 'addtime', 'click', '');
	$sql = "select comid,comname,thumb,click,postdate from {$table}com where is_check=1 order by comid desc limit $num";
	$res = $db->query($sql);
	while($row=$db->fetchrow($res)) {
		$row['sname'] = cut_str($row['comname'],25);
		$row['postdate'] = date('Y-m-d', $row['postdate']);
		$row['url'] = url_rewrite('com', array('act'=>'view', 'comid'=>$row['comid']));
		$coms[] = $row;
	}
	return $coms;
}

function get_index_article($num='15')
{
	global $db,$table;
	
	$sql = "select * from {$table}article where is_index=1 order by id desc limit $num";
	$res = $db->query($sql);
	while($row=$db->fetchrow($res)) {
		$row['ctitle'] = cut_str($row['title'], 80);
		$row['sdescription'] = cut_str($row['description'], 150);
		$row['addtime'] = date('Y-m-d', $row['addtime']);
		$row['url'] = url_rewrite('article', array('aid'=>$row['id'],'act'=>'view'));
		$data[] = $row;
	}
	return $data;
}


function get_top_info($catids, $top_type) 
{
	global $db,$table;

	if(empty($catids)) return '';
	$time = time();

	
	return $top_info;
}

function get_infos_custom($infoid)
{
	global $db, $table;

	$sql = "select c.cusname,v.cusid,v.infoid,v.cusvalue from {$table}custom as c left join {$table}cus_value as v on v.cusid=c.cusid where v.infoid in ($infoid)";
	$res = $db->query($sql);
	while($row=$db->fetchrow($res)) {
		$data[$row['infoid']][$row['cusid']]['cusname'] = $row['cusname'];
		$data[$row['infoid']][$row['cusid']]['cusvalue'] = $row['cusvalue'];
	}
	return $data;
}

function submitcheck($var) {
	if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST[$var])) {
		if((empty($_SERVER['HTTP_REFERER']) || preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST']))) {
			return true;
		} else {
			die('Error POST');
		}
	} else {
		return false;
	}
}

function checkInfoUser($id, $password) {
	global $db, $table, $_userid, $L;
	if(empty($_userid)) {
		$password = trim($password);
		$pass = $db->getOne("SELECT password FROM {$table}info WHERE id='$id' LIMIT 1");
		if(empty($pass))showmsg($L['pass_not']);
		if($password != $pass)showmsg($L['pass_not_correctly']);
	} else {
		$sql = "SELECT userid FROM {$table}info WHERE id='$id' ";
		$infouserid = $db->getOne($sql);
		if($infouserid!=$_userid)showmsg($L['this_not_your_ad']);
	}
	
}

/* АНТИМАТ */
function get_censor()
{
	global $CFG;
	$censors = $banned = $banwords = array();
	
	$data = read_cache('censor');
	if ($data === false) {
		//определяем
		$censorarr = explode("|", $CFG['banwords']);
		foreach($censorarr as $censor) {

			$censor = trim($censor);
			if(empty($censor)) continue;
			
			//заменяем
			if(strstr($censor, '=')) {
				list($find, $replace) = explode('=', $censor);
			} else {
				$find = $censor;
				$replace = '*';
			}
			$findword = $find;
			$find = preg_replace("/\\\{(\d+)\\\}/", ".{0,\\1}", preg_quote($find, '/'));
			switch($replace) {
				case '{BANNED}':
					$banwords[] = preg_replace("/\\\{(\d+)\\\}/", "*", preg_quote($findword, '/'));
					$banned[] = $find;
					break;

				default:
					$censors['filter']['find'][] = '/'.$find.'/i';
					$censors['filter']['replace'][] = $replace;
					break;
			}
		}
		if($banned) {
			$censors['banned'] = '/('.implode('|', $banned).')/i';
			$censors['banword'] = implode(', ', $banwords);
		}
	
		write_cache('censor', $censors);
	} else {
		$censors = $data;
	}
	return $censors;
}

function censor($string) {
	$censor = get_censor();
	if($censor) {
		//фильтр антимат
		if($censor['banned'] && preg_match($censor['banned'], $string)) {
			$string = false;
		} else {
			$string = empty($censor['filter']) ? $string : @preg_replace($censor['filter']['find'], $censor['filter']['replace'], $string);
		}
	}
	return $string;
}

function debug() {
	global $db,$L, $debug_starttime;
    $mtime = explode(' ', microtime());
	$s = number_format(($mtime[1] + $mtime[0] - $debug_starttime), 3);
	echo ''.$L['page_load'].' '.$s.' '.$L['db_second'].' '.$L['db_query'].' '.$db->queryCount.'';
    if(function_exists('memory_get_usage')) echo '. '.$L['memory_usage'].' '.round(memory_get_usage()/1024/1024, 2).' Mb';
}


function clear_url($url) {
	$url = preg_replace('/https?:\/\//', '', $url);
	$url = preg_replace('/\//', '', $url);
	return $url;
}

?>