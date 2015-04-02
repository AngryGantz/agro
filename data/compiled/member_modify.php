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
                    <strong class="active-color"><?php echo $L['modifying_data'];?></strong>
                </div>
            </div> <!-- END Page block  -->

            <!-- Page block content  -->
            <div class="page-block page-block-bottom cream-bg grid-container">
                <div class="sidebar-shadow push-25"></div>

<?php include template(member_left); ?>

 
               <!-- Content  --> 
               <div class="content-with-sidebar grid-75">
                    <form class="content-form margin-bottom" action="member.php?act=act_modify" name="form" method="POST">
                            
                        <div class="with-shadow grid-100 light-bg margin-bottom clearfix">
                            <div class="content-page grid-100">
                                <h2 class="bigger-header with-border subheader-font">
                                    <?php echo $L['modifying_data'];?>: <?php echo $userinfo['username'];?>
                                </h2>
                                
                                <div class="form-input">
                                    <label for="email" class="middle-color">E-mail <span class="active-color">*</span></label>
                                    <input type="text" class="text-input dark-color light-bg" name="email" id="email" value="<?php echo $userinfo['email'];?>" />
                                </div>
                                <div class="form-input">
                                    <label for="surname" class="middle-color"><?php echo $L['name_surname'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" name="surname" id="surname" value="<?php echo $userinfo['surname'];?>" />
                                </div>
                                <div class="form-input">
                                    <label for="phone" class="middle-color"><?php echo $L['phone'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" name="phone" id="phone" value="<?php echo $userinfo['phone'];?>" />
                                </div>
                                <div class="form-input">
                                    <label for="icq" class="middle-color">Skype</label>
                                    <input type="text" class="text-input dark-color light-bg" name="icq" id="icq" onKeyUp="value=value.replace(/\D+/g,'')" value="<?php echo $userinfo['icq'];?>" />
                                </div>
                                <div class="form-input">
                                    <label for="address" class="middle-color"><?php echo $L['address'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" name="address" id="address" value="<?php echo $userinfo['address'];?>" />
                                </div>
            <?php if($CFG[map_check]==1) { ?>	
                                <div class="form-input">
                     <label for="mappoint" class="middle-color"><?php echo $L['coordinates'];?></label>
<script type="text/javascript" src="js/msgbox/msgbox.js"></script>
<link href="js/msgbox/msgbox.css" type="text/css" rel="stylesheet" />
                    <input type="text" class="text-input dark-color light-bg" style="width:400px;" name="mappoint" id="mappoint" placeholder="<?php echo $L['coordinates'];?>" value="<?php echo $userinfo['mappoint'];?>" readonly="readonly" autocomplete="off"/>
<input name="markmap" type="button" value="<?php echo $L['map'];?>" class="button-normal active-gradient light-color dark-gradient-hover" onclick="Yubox.win('do.php?act=small_map&mark=1&width=700&height=450&p=<?php echo $CFG['map'];?>',700,540,'<?php echo $L['map'];?>',null,null,null,true);">
<p class="middle-color"><?php echo $L['map_check_tip'];?></p>
                        </div>
<?php } ?>
                            </div>
                        </div>

                        <div class="form-submit">
                            <button type="submit" class="button-normal uppercase light-color middle-gradient dark-gradient-hover"><?php echo $L['change'];?></button>
                        </div>    
                    </form>
               </div><!-- END Content  --> 
           </div> <!-- END Page block  -->
                    
       </section>

<?php include template(footer); ?>
