<?php if(!defined('IN_AWEBCOM'))die('Access Denied'); ?><!DOCTYPE html>
<!--[if IE 8 ]>    <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
    <head>
        <meta charset="<?php echo $charset;?>">
        <title><?php echo $seo['title'];?></title>
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1">
        <meta name="description" content="<?php echo $seo['description'];?>">
        <meta name="keywords" content="<?php echo $seo['keywords'];?>">
        <!-- Styles -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:400,700" type="text/css">
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/style/unsemantic.css" type="text/css">
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/style/responsive.css" type="text/css">
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/style/font-awesome/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/js/juicy/css/juicy.css" type="text/css">
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/js/juicy/css/themes/shoppie/style.css" type="text/css">
        <!--[if IE 7]>
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/style/font-awesome/css/font-awesome-ie7.min.css">
        <![endif]-->
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/style/colors/red.css" type="text/css">
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/style/base.css" type="text/css">
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/style/layout.css" type="text/css">
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/style/pages/post.css" type="text/css">
        <!-- Fav and touch icons -->
        <link rel="shortcut icon" href="favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="120x120" href="images/ico/apple-touch-icon-precomposed.png">
        <!-- HTML5 Shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="templates/<?php echo $CFG['tplname'];?>/js/html5shim.js"></script>
        <![endif]-->
    </head>
    <body class="body-background2 content-font dark-color">
    
<?php include template(top); ?>

        <section class="page-content">

            <!--  Page block  -->
            <div class="page-block page-block-top light-bg grid-container">
                <div class="breadcrumbs grid-100 middle-color">
                    <a href="index.php" class="dark-color active-hover"><?php echo $L['f_home'];?></a>
                    <strong class="active-color"><?php echo $L['f_login_control_panel'];?></strong>
                </div>
            </div> <!-- END Page block  --> 
            <!-- Page block content  -->
            <div class="page-block page-block-bottom cream-bg grid-container">
                <div class="content-page checkout-page grid-100">
                <!-- Content  -->
<div class="content-holder grid-100"> 
<form class="content-form" name="form1" method="post" action="member.php?act=act_login" autocomplete="off">
<input type="hidden" name="refer" value="<?php echo $refer;?>" />
                                <div class="form-input">
                                    <label for="username" class="middle-color"><span class="f_b f_red px18">*</span> <?php echo $L['f_login'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" placeholder="<?php echo $L['f_login'];?>" name="username" id="username" style="width:300px;"/>
                                </div>

                                <div class="form-input">
                                    <label for="password" class="middle-color"><span class="f_b f_red px18">*</span> <?php echo $L['f_password'];?></label>
                                    <input type="password" class="text-input dark-color light-bg" placeholder="<?php echo $L['f_password'];?>" name="password" id="password" style="width:300px;"/>
                                </div>

                                <div class="form-input">
                                    <label for="answer" class="middle-color"><span class="f_b f_red px18">*</span> <?php echo $L['f_answer_question'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" style="width:200px;" name="answer" id="answer" placeholder="<?php echo $L['f_enter_answer_question'];?>"/>
<input type="hidden" id="vid" name="vid" value="<?php echo $verf['vid'];?>" />
<p class="middle-color"><span class="f_b f_red"><?php echo $verf['question'];?></span></p>
                                </div>

<div class="align-center">
<input type="submit" id="submit" name="submit" class="button-normal active-gradient light-color dark-gradient-hover" value="<?php echo $L['f_log_in'];?>" />
                    </div> 
                                <div class="topmargin5"></div>

<div class="grid-100 well well-box cream-bg">
<a class="button-normal middle-gradient light-color dark-gradient-hover" href="member.php?act=register"><?php echo $L['f_registration'];?></a>&nbsp;&nbsp;&nbsp;&nbsp;
<a class="button-normal middle-gradient light-color dark-gradient-hover" href="member.php?act=get_password"><?php echo $L['f_forgot_password'];?></a>
                </div>

                        </div>
                    </form>
                </div><!-- END Content  -->
            </div><!-- END Page block  -->
        </section>

<?php include template(footer); ?>

<script type="text/javascript">jQuery.noConflict();</script>
<script type="text/javascript" src="js/valid/validator.full.js"></script>
<link href="js/valid/validator.css" type="text/css" rel="stylesheet" />
<script type="text/javascript">
$.validator("username")
.setRequired("<?php echo $L['f_login_enter'];?>")
.setServerCharset("UTF-8")
.setStrlenType("byte")

$.validator("password")
.setRequired("<?php echo $L['f_password_enter'];?>")
.setServerCharset("UTF-8")
.setStrlenType("symbol")

$.validator("answer")
.setRequired("<?php echo $L['f_enter_answer_question'];?>")
.setAjax("do.php?act=ver&vid="+$('#vid').val(), "<?php echo $L['f_answer_wrong'];?>");
</script>