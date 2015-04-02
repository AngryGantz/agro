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
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/style/pages/homepage.css" type="text/css">
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
                    <a href="cat.php" class="active-color"><strong><?php echo $L['f_categories'];?></strong></a>
               </div>
           </div> <!-- END Page block  -->
           
           <!-- Page block content  -->
           <div class="page-block page-block-bottom cream-bg grid-container">

               <!-- Content  --> 
               <div class="content-holder grid-100"> 
<?php if(is_array($cats_list)) foreach($cats_list AS $cat) { ?>
<h3><a href="<?php echo $cat['caturl'];?>" class="active-color dark-hover"><?php echo $cat['catname'];?></a></h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px dotted #ccc;margin-bottom:15px;">

<?php if(is_array($cat[children])) foreach($cat[children] AS $i => $child) { ?>
<?php if($i%4==0) { ?><tr><?php } ?>
<td valign="top" width="150">
    <div class="map"><a href="<?php echo $child['url'];?>" class="dark-color active-hover">
                                            <?php echo $child['name'];?><span class="middle-color"><?php if($info_count[$child[id]]==0) { ?> (0)<?php } else { ?> (<?php echo $info_count[$child['id']];?>)<?php } ?></span>
                                        </a></div>
                                        </td>
                                    <?php if($i%4==4-1) { ?></tr><?php } ?>

<?php } ?>

</table>

<?php } ?>
			   
               </div><!-- END Content  -->
           </div><!-- END Page block  -->   
       </section>

<?php include template(footer); ?>
