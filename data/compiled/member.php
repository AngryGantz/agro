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
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/style/pages/my-profile.css" type="text/css">
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
                    <a href="member.php" class="dark-color active-hover"><?php echo $L['f_control_panel'];?></a>
                    <strong class="active-color"><?php echo $_username;?></strong>
                </div>
            </div> <!-- END Page block  -->

            <!-- Page block content  -->
            <div class="page-block page-block-bottom cream-bg grid-container">
                <div class="sidebar-shadow push-25"></div>

<?php include template(member_left); ?>

                <!-- Content  -->
                <div class="content-with-sidebar grid-75">

                    <div class="with-shadow grid-100 light-bg">
                        <div class="content-page content-holder grid-100">

                            <div class="my-profile-header margin-bottom middle-color clearfix">
<!--                                 <div class="my-profile-photo hide-on-mobile hide-on-tablet">
                                        <img class="with-shadow" src="templates/<?php echo $CFG['tplname'];?>/images/img-avatar.jpg" alt="<?php echo $_username;?>" />
                                </div> -->
                                <div class="my-profile-info">
                                    <h1 class="active-color header-font"><span class="dark-color"><?php echo $L['f_welcome'];?></span> <?php echo $_username;?></h1>
                                    <?php if($CFG[memberanons]) { ?><p><?php echo nl2br($CFG[memberanons]);?></p><?php } ?>
                                </div>
                            </div>

                            <h2 class="dark-color subheader-font"><?php echo $L['my_data'];?></h2>
                            <ul class="grid-50 tablet-grid-50">
                                <li class="middle-color">
                                    <span class="middle-color dark-hover"><?php echo $L['date_registration'];?>: <?php echo date('Y-m-d-H-i',$userinfo['registertime']);?></span>
                                </li>
                                <li class="middle-color">
                                    <span class="middle-color dark-hover"><?php echo $L['date_last_entry'];?>: <?php echo date('Y-m-d-H-i',$userinfo['lastlogintime']);?></span>
                                </li>

                                <li class="middle-color">
                                    <span class="middle-color dark-hover">Skype: <?php if($userinfo['icq']) { ?><?php echo $userinfo['icq'];?><?php } else { ?><span class="f_red"><?php echo $L['unknown'];?></span><?php } ?></span>
                                </li>

                            </ul>
                            <ul class="grid-50 tablet-grid-50">
                                <li class="middle-color">
                                    <span class="middle-color dark-hover">E-mail: <?php echo $userinfo['email'];?></span>
                                    <?php if(!$status) { ?><a href="member.php?act=send_check_email" class="middle-color dark-hover"><span class="f_b f_red"><?php echo $L['not_confirmed'];?></span></a><?php } ?>
                                </li>
                                <li class="middle-color">
                                    <span class="middle-color dark-hover"><?php echo $L['phone'];?>: <?php if($userinfo['phone']) { ?><?php echo $userinfo['phone'];?><?php } else { ?><span class="f_red"><?php echo $L['unknown'];?></span><?php } ?></span>
                                </li>
                                <li class="middle-color">
                                    <span class="middle-color dark-hover"><?php echo $L['address'];?>: <?php if($userinfo['address']) { ?><?php echo $userinfo['address'];?><?php } else { ?><span class="f_red"><?php echo $L['unknown'];?></span><?php } ?></span>
                                </li>
                            </ul>
                            <div class="clear margin-bottom"></div>

<!--                             <h2 class="dark-color subheader-font"><?php echo $L['finance'];?></h2>
                            <ul class="grid-50 tablet-grid-50">
                                <li class="middle-color">
                                    <a href="member.php?act=table_charges" class="middle-color dark-hover"><?php echo $L['you_points'];?>: <span class="f_b f_hid px16"><?php echo $userinfo['credit'];?></span></a>
                                </li>
                                <li class="middle-color">
                                    <a href="member.php?act=pay" class="middle-color dark-hover"><?php echo $L['you_balance'];?>: <span class="f_b f_red px16"><?php echo $userinfo['money'];?> <?php echo $CFG['currency'];?></span></a>
                                </li>
                            </ul>
                            <ul class="grid-50 tablet-grid-50">
                                <li class="middle-color">
                                    <a href="member.php?act=exchange" class="middle-color dark-hover"><?php echo $L['usage_charges'];?></a>
                                </li>
                                <li class="middle-color">
                                    <a href="member.php?act=pay" class="middle-color dark-hover"><?php echo $L['fill_up_balance'];?></a>
                                </li>
                            </ul> -->
                            <div class="clear margin-bottom"></div>
     <?php if($notice) { ?>
                            <h2 class="dark-color subheader-font"><?php echo $L['personal_information_filled'];?></h2>
                            <ul class="grid-100">
                                <li class="middle-color">
                                    <a href="member.php?act=modify" class="middle-color dark-hover"><span class="f_b f_red"><?php echo $L['personal_information_filled_tip'];?></span></a>
                                </li>
                            </ul>
     <?php } ?>
                        </div>
                    </div>
                </div><!-- END Content  -->
            </div> <!-- END Page block  -->
        </section>

<?php include template(footer); ?>
