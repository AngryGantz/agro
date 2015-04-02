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
                    <strong class="active-color"><?php echo $L['f_add_company_go'];?></strong>
                </div>
            </div> <!-- END Page block  --> 
            <!-- Page block content  -->
            <div class="page-block page-block-bottom cream-bg grid-container">

                <!-- Content  -->
                <div class="content-page checkout-page grid-100">

                    <div class="checkout-progress progress">
                        <div class="progress-step active-color current-step">
                            <a class="step-outer">
                                <span class="step-inner">
                                    <span class="light-color active-bg">1</span>
                                </span>
                              <?php echo $L['f_select_category'];?>
                            </a>
                        </div>
                        <div class="progress-step middle-color">
                            <a class="step-outer">
                                <span class="step-inner">
                                    <span>2</span>
                                </span>
                             <?php echo $L['f_fill_content'];?>
                            </a>
                        </div>
                        <div class="progress-step middle-color">
                            <a class="step-outer">
                                <span class="step-inner">
                                    <span>3</span>
                                </span>
<?php echo $L['f_my_add_company'];?>
                            </a>
                        </div>
                    </div>
                    <hr />
<?php if($INF['postcomtext']) { ?>
<div class="topmargin5"></div>
   <blockquote class="active-border cream-bg">
                         <?php echo $INF['postcomtext'];?>
                          </blockquote>
  <?php } ?>
               <!-- Content  --> 
               <div class="content-holder grid-100"> 
<?php if(is_array($cats)) foreach($cats AS $cat) { ?>
<h3 class="active-color dark-hover"><i class="icon-circle"></i> <?php echo $cat['catname'];?></h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px dotted #ccc;margin-bottom:15px;">
<?php if(!empty($cat[children])) { ?>

<?php if(is_array($cat[children])) foreach($cat[children] AS $i => $chi) { ?>
<?php if($i%4==0) { ?><tr><?php } ?>
<td valign="top" width="150">
    <div class="map"><i class="icon-hand-right"></i> <a href="postcom.php?act=post&id=<?php echo $chi['id'];?>" class="dark-color active-hover"><?php echo $chi['name'];?></a></div>
                                        </td>
                                    <?php if($i%4==3) { ?></tr><?php } ?>

<?php } ?>

<?php } ?>
</table>

<?php } ?>
			   
               </div><!-- END Content  -->
           <!-- END Page block  -->   
                </div><!-- END Content  -->
            </div><!-- END Page block  -->
        </section>

<?php include template(footer); ?>
