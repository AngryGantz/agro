<?php if(!defined('IN_AWEBCOM'))die('Access Denied'); ?><!DOCTYPE html>
<!--[if IE 8 ]>    <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
    <head>
<meta charset="<?php echo $charset;?>"> 
<meta http-equiv="cache-control" content="no-cache">  
<title><?php echo $L['f_message'];?></title>
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/style/colors/red.css" type="text/css">
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/style/base.css" type="text/css">
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/style/layout.css" type="text/css">
</head>
    <body class="body-background2 content-font dark-color">
                    <div class="align-center">
                        <div class="alert alert-info margin-bottom">
                            <?php echo $msg;?>
<div class="content-holder align-center">
<?php if($url=='goback' || $url=='') { ?>
<a class="button-normal button-block dark-gradient light-color active-gradient-hover" href="javascript:history.back();"><?php echo $L['f_history_back'];?></a>
<?php } else { ?>
<br/><a class="button-normal button-block dark-gradient light-color active-gradient-hover" href="<?php echo $url;?>"><?php echo $L['f_click_here'];?></a>
<script language="javascript">setTimeout("window.location.replace('<?php echo $url;?>')",'1000');</script>
<?php } ?>
 </div>
                        </div>
                    </div>
</body>
</html>