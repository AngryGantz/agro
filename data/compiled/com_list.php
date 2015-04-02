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
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/style/pages/products-listing.css" type="text/css">
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
                    
<?php include template(here); ?>

               </div>
           </div> <!-- END Page block  -->		   
           
           <!-- Page block content  -->
           <div class="page-block page-block-bottom cream-bg grid-container">
               <div class="sidebar-shadow push-25"></div> 
               <!-- Sidebar  --> 
               <div class="sidebar grid-25 cream-gradient transition-all" id="sidebar-mobile">
                    <!-- Category AND AREA submenu box -->
                    <div class="sidebar-box sidebar-top cream-gradient">
                        <nav class="submenu">
                            <ul class="expandable-menu">
                                <li class="align-right back">
                                    <a href="#sidebar-mobile" class="dark-color active-hover click-slide"><i class="icon-chevron-right"></i></a>
                                </li>

                                <li class="sidebar-divider"></li>
<?php if(is_array($com_cats)) foreach($com_cats AS $cat) { ?>
                                <li>
                                    <a href="#" class="dark-color active-hover"><?php echo $cat['catname'];?></a>
                                    <ul>
   <?php if(!empty($cat[children])) { ?>		
<?php if(is_array($cat[children])) foreach($cat[children] AS $chi) { ?>
 <li>
                                    <a href="<?php echo $chi['url'];?>" class="dark-color active-hover"><b class="middle-color">&rsaquo;</b> <?php echo $chi['name'];?></a>
</li>

<?php } ?>

   <?php } ?>
                                    </ul>
                                </li>

<?php } ?>

                                <li class="sidebar-divider"></li>
                            </ul>
                        </nav>
                    </div>
<!-- END Category submenu box -->
               </div><!-- END Sidebar  --> 
               
               <!-- Content  --> 
               <div class="content-with-sidebar grid-75 grid-parent">
                   
                   <div class="grid-100 margin-bottom hide-on-mobile">
   <!--  BANNER  -->
                    <div class="align-center"></div>
                   </div>
   
   <div class="grid-100 margin-bottom">	
    <div class="well-shadow well-box last light-bg">
<form name="form" action="com.php" method="get">
<div class="custom-selectbox dark-color light-gradient active-hover">
<select name="area">
<option value="">-- <?php echo $L['areaid_empty'];?> --</option>
<?php echo $area_option;?>
</select>
</div>&nbsp;&nbsp;&nbsp;&nbsp;
<input class="button-small uppercase light-color middle-gradient dark-gradient-hover" type="submit" value="<?php echo $L['filter'];?>">
</form>
  </div> 
  </div>
   
                   <?php if(is_array($articles)) foreach($articles AS $val) { ?>
                   <!--  INFO  -->
                   <div class="grid-100">
                       <div class="product-wide light-bg clearfix">

                           <div class="grid-15 tablet-grid-20 mobile-grid-35 product-img-holder">
                                <a class="product-img" href="<?php echo $val['url'];?>">
                                    <?php if($val[thumb]) { ?>
<img src="<?php echo $val['thumb'];?>" alt="<?php echo $val['comname'];?>" />
<?php } else { ?>
<img src="images/ico/no_img.gif" alt="<?php echo $val['comname'];?>" />
<?php } ?>
                                </a>
                           </div>
                           
                           <div class="grid-50 tablet-grid-45 mobile-grid-65 product-description">
                                <h3 class="product-title subheader-font">
                                   <a href="<?php echo $val['url'];?>" class="dark-color active-hover">
                                       <strong><?php echo $val['comname'];?></strong>
                                   </a>
                               </h3>
                               <span class="product-category middle-color dark-hover"><?php echo $val['postdate'];?></span>&nbsp;&nbsp;
                               <span class="product-category middle-color dark-hover"><?php echo $val['areaname'];?></span>
                               <p class="dark-color hide-on-mobile"><?php echo $val['introduce'];?></p>
                           </div>
                           
                           <div class="grid-35 tablet-grid-35 hide-on-mobile product-actions">
                                <?php if($val[hours]) { ?>
<div class="product-category middle-color dark-hover">
                                   Время работы: <?php echo $val['hours'];?>
                                </div>
<?php } ?>
<?php if($val[address]) { ?>
                                <div class="product-category middle-color dark-hover">
                                 <?php echo $val['address'];?>
                                </div>
<?php } ?>
                                <div class="clear"></div>
                                
                           </div> 
                       </div>
                   </div><!--  END INFO   -->
                   
<?php } ?>

                   <div class="grid-100">
                           
<?php include template(page); ?>

                   </div>
                    
               </div><!-- END Content  --> 
               
           </div> <!-- END Page block  -->
                    
       </section>

<?php include template(footer); ?>
