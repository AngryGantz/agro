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
                    <strong class="active-color"><?php echo $L['my_company'];?></strong>
                </div>
            </div> <!-- END Page block  -->

            <!-- Page block content  -->
            <div class="page-block page-block-bottom cream-bg grid-container">
                <div class="sidebar-shadow push-25"></div>

<?php include template(member_left); ?>

               <!-- Content  --> 
               <div class="content-with-sidebar grid-75">			   
<div class="well-shadow cream-bg">
   <div class="well-table with-border">
   <div class="well-box grid-5"><strong>ID</strong></div>
   <div class="well-box grid-35"><strong><?php echo $L['name'];?></strong></div>
   <div class="well-box grid-15"><strong><?php echo $L['date'];?></strong></div>
   <div class="well-box grid-15 last active-color t_c"><strong><?php echo $L['management'];?></strong></div>
   </div>
   <?php if(is_array($coms)) foreach($coms AS $row) { ?>
   <div class="well-table">
   <div class="well-box grid-5"><?php echo $row['comid'];?></div>
   <div class="well-box grid-35">
                       <?php if(!$row[is_check]) { ?><i title="<?php echo $L['on_moderation'];?>" class="icon-ban-circle"></i><?php } ?>
   <a class="dark-color active-hover" href="<?php echo $row['url'];?>" target="_blank"><?php echo $row['comname'];?></a>
   </div>
   <div class="well-box grid-15"><?php echo $row['postdate'];?></div>
   <div class="well-box grid-15 last active-color t_c">
<a href="member.php?act=editcom&id=<?php echo $row['comid'];?>"><i title="<?php echo $L['change'];?>" class="icon-edit icon-large dark-color"></i></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="member.php?act=delcom&id=<?php echo $row['comid'];?>" onClick="if(!confirm('<?php echo $L['confirm_delete'];?>'))return false;"><i title="<?php echo $L['delete'];?>" class="icon-minus-sign icon-large dark-color"></i></a>
   </div>
   </div>
   
<?php } ?>

   
                  <div class="topmargin10"></div>
      </div> 

<?php include template(page); ?>

</div> 
                 </div>                    
   <!-- END Content  -->
       </section>

<?php include template(footer); ?>
