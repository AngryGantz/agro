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
            <!--  Page block  -->
            <div class="page-block page-block-top light-bg grid-container">
                <div class="breadcrumbs grid-100 middle-color">
                    <a href="index.php" class="dark-color active-hover"><?php echo $L['f_home'];?></a>
                    <strong class="active-color"><?php echo $L['f_search'];?></strong>
                </div>
            </div> <!-- END Page block  --> 
           <!-- Page block content  -->
           <div class="page-block page-block-bottom cream-bg grid-container">
               <div class="sidebar-shadow push-25"></div>  
               <!-- Sidebar  --> 
               <div class="sidebar grid-25 cream-gradient transition-all" id="sidebar-mobile">
                    <!-- Sidebar recom box -->
                    <div class="sidebar-box cream-gradient">
                        <h2 class="header-font active-color"><?php echo $L['popular'];?></h2>

                        <ul class="sidebar-list">
                            <li class="sidebar-divider"></li>
<?php if(is_array($cat_hot)) foreach($cat_hot AS $hot) { ?>
                            <li class="popup-outside-trigger">
                                <a href="<?php echo $hot['url'];?>" class="sidebar-product dark-color active-hover">
                                    <span>
                                        <?php echo $hot['title'];?>
<?php if($hot[price]) { ?>
                                        <strong class="active-color"><?php echo number_format($hot[price], 2, '.', ' ');?> <?php echo $hot['unit'];?></strong>
<?php } ?>
                                    </span>
<?php if($hot[thumb]) { ?>
                                    <img src="<?php echo $hot['thumb'];?>" width="50px" alt="<?php echo $hot['title'];?>">
<?php } else { ?>
                                    <img src="images/ico/no_img.gif" width="50px" alt="<?php echo $hot['title'];?>">
<?php } ?>
                                </a>

                                <ul class="product-popup popup-right popup-box light-bg">
                                    <li class="arrow"><span class="shadow light-bg"></span></li>
                                    <li class="focusor"></li>
                                    <li class="ribbon-small ribbon-green">
                                        <div class="ribbon-inner">
                                            <span class="ribbon-text"><?php echo $L['popular'];?></span>
                                            <span class="ribbon-aligner"></span>
                                        </div>
                                    </li>
                                    <li class="clearfix">
                                        <div class="product-popup-top">
                                            <a href="<?php echo $hot['url'];?>">
<?php if($hot[thumb]) { ?>
                                                <img src="<?php echo $hot['thumb'];?>" width="100px" alt="<?php echo $hot['title'];?>">
<?php } else { ?>
                                                <img src="images/ico/no_img.gif" width="100px" alt="<?php echo $hot['title'];?>">
<?php } ?>
                                            </a>
                                        </div>
                                        <div class="product-popup-divider"></div>
                                        <div class="product-popup-bottom">
                                            <ul>
                                                <li class="product-popup-subtitle middle-color"><?php echo $hot['catname'];?></li>
                                                <li class="product-popup-subtitle middle-color"><?php echo $hot['areaname'];?></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </li>

<?php } ?>

                            <li class="sidebar-divider"></li>
                        </ul>
                    </div><!-- END Sidebar recom box -->


               </div><!-- END Sidebar  --> 
               
               <!-- Content  --> 
               <div class="content-with-sidebar grid-75 grid-parent">
                   
                   <!--  Products listing header  -->
                   <div class="grid-100 margin-bottom hide-on-mobile">
   	<!--  BANNER  -->
                    <div class="align-center"></div>
                   </div><!--  END Products listing header  -->

                   <!--  Products sorting  -->
                    <?php if(is_array($articles)) foreach($articles AS $article) { ?>
                   <!--  INFO  -->
                   <div class="grid-100">
                       <div class="product-wide light-bg clearfix">
                           <?php if($article[is_pro]) { ?>
   <div class="ribbon-small ribbon-red">
                               <div class="ribbon-inner">
                                   <span class="ribbon-text"><?php echo $L['recom'];?></span>
                                   <span class="ribbon-aligner"></span>               
                               </div>
                           </div>
   <?php } ?> 
                           
                           <div class="grid-15 tablet-grid-20 mobile-grid-35 product-img-holder">
                                <a class="product-img" href="<?php echo $article['url'];?>">
                                    <?php if($article[thumb]) { ?>
<img src="<?php echo $article['thumb'];?>" alt="<?php echo $article['title'];?>" />
<?php } else { ?>
<img src="images/ico/no_img.gif" alt="<?php echo $article['title'];?>" />
<?php } ?>
                                </a>
                           </div>
                           
                           <div class="grid-50 tablet-grid-45 mobile-grid-65 product-description">
                                <h3 class="product-title subheader-font">
                                   <a href="<?php echo $article['url'];?>" class="dark-color active-hover">
                                       <strong><?php echo $article['title'];?></strong>
                                   </a>
                               </h3>
                               <span class="product-category middle-color dark-hover"><?php echo $article['postdate'];?></span>&nbsp;&nbsp;
                               <span class="product-category middle-color dark-hover"><?php echo $article['areaname'];?></span>
                               <p class="dark-color hide-on-mobile"><?php echo $article['intro'];?></p>

                           </div>
                           
                           <div class="grid-35 tablet-grid-35 hide-on-mobile product-actions">
                                <?php if($article[is_top]) { ?><div class="product-stars voting-stars stars-big">
                                    <i title="В ТОП-е" class="icon-circle-arrow-up active-color"></i>
                                </div>
<?php } ?>
<?php if($article[price]) { ?>
                                <div class="product-price active-color">
                                    <strong><?php echo number_format($article[price], 2, '.', ' ');?> <?php echo $article['unit'];?></strong>
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
