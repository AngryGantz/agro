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

<?php if($INF['homeflash_check']) { ?>
       <!--    Home page slider    -->
       <div class="homepage-slider grid-container juicy-wrapper hide-on-mobile">
            <ul id="juicy-slider" class="juicy-slider">
                <!--    Home page slider layer   -->
<?php if(is_array($slider)) foreach($slider AS $slider) { ?>
                <li data-change="slices:10 speed:1500">
                    <a href="<?php echo $slider['url'];?>" target="_blank"><img class="juicy-bg" src="<?php echo $slider['image'];?>" alt="<?php echo $slider['texts'];?>" /></a>

                    <div
                        style="top: 200px; left: 50px"
                        data-show="at:1000 effect:shift-fade direction:left speed:2000 easing:easeOutQuint"
                        data-hide="effect:slide-fade direction:left speed:800"
                        class="juicy-layer subheader-font dark-color slider-subheader">
                        <?php echo $slider['texts'];?>
                    </div>
                </li> <!--   END Home page slider layer   -->

<?php } ?>

            </ul>
            <div class="juicy-slider-nav juicy-bullets cream-border active-bg hide-on-tablet" data-type="bullets"></div>
       </div><!--   END Home page slider   -->
   <?php } ?>	
       <section class="page-content">
   <div class="topmargin10"></div>	
              <?php if($CFG['annouce']) { ?>
<!--                   <div class="grid-home margin-bottom">
                    <div class="tip dark-color light-bg">
                        <span class="tip-ribbon"></span>
                        <p><?php echo $CFG['annouce'];?></p>
                    </div>
                  </div>
 -->                <?php } ?>	    


<!-- Таб-Панель категорий -->
<div class="page-block page-tabs-block cream-bg grid-container">
  <!--  Заголовки табов   -->
  <div class="page-tabs page-main grid-100 shoppie-tabs">
    
<?php $i='0';?>

    <?php if(is_array($cats_list)) foreach($cats_list AS $cat) { ?>
      <?php if($i<7) { ?>
         <h6 class="header-font">
             <a class="light-color active-hover dark-gradient cream-gradient-hover transition-color" href="#tab-main<?php echo $i;?>">
                 <span class="hide-on-mobile"><?php echo $cat['catname'];?></span>
                 <i class="icon-thumbs-up hide-on-desktop hide-on-tablet"></i>
             </a>
         </h6>
      <?php } ?>
      
<?php $i++;?>

    
<?php } ?>
 
  </div> 
  <!--  END Заголовки табов   -->
  <!-- Содержание табов -->
  <div class="page-tabs-holder">
    
<?php $i='0'; $j=2;?>

    <?php if(is_array($cats_list)) foreach($cats_list AS $cat) { ?>
      <?php if($i<7) { ?>
        <div class="page-tab" id="tab-main<?php echo $i;?>">
          <!-- begin tab-main-listcat  -->
          <div class="tab-main-listcat">
           <ul class="mega-menu-list">
              <?php if(is_array($cat[children])) foreach($cat[children] AS $child) { ?>
                <li>
                    <a href="<?php echo $child['url'];?>" class="dark-color active-hover">
                        <?php echo $child['name'];?><span class="middle-color"><?php if($info_count[$child[id]]==0) { ?> (0)<?php } else { ?> (<?php echo $info_count[$child['id']];?>)<?php } ?></span>
                    </a>
                </li>
              
<?php } ?>

            </ul>
          </div>
          <!-- end tab-main-listcat -->
          <!-- begin tab-main-adscont (Контейнер для рекламы) -->
          <div class="tab-main-adscont">
            <?php echo ads_list($j, ads);?>
            
<?php $j++;?>

            <?php echo ads_list($j, ads);?>
            
<?php $j++;?>

            <?php echo ads_list($j, ads);?>
            
<?php $j++;?>

          </div>
          <!-- end tab-main-adscont -->
        </div>
      <?php } ?>
      
<?php $i++;?>

    
<?php } ?>
 
  </div>
  <!-- END Содержание табов -->
</div>
<!-- END Таб-Панель категорий -->










           <!--  Page block with tabs   -->
           <div class="page-block page-tabs-block cream-bg grid-container">
               <!--  Page tabs   -->
               <div class="page-tabs grid-100 shoppie-tabs">
                   <h2 class="header-font">
                       <a class="light-color active-hover dark-gradient cream-gradient-hover transition-color" href="#tab-recomend">
                           <span class="hide-on-mobile"><?php echo $L['recom'];?></span>
                           <i class="icon-thumbs-up hide-on-desktop hide-on-tablet"></i>
                       </a>
                   </h2>
                   <h2 class="header-font">
                       <a class="light-color active-hover dark-gradient cream-gradient-hover transition-color" href="#tab-top-rated">
                           <span class="hide-on-mobile"><?php echo $L['in_top_home'];?></span>
                           <i class="icon-heart hide-on-desktop hide-on-tablet"></i>
                       </a>
                   </h2>
                   <h2 class="header-font">
                       <a class="light-color active-hover dark-gradient cream-gradient-hover transition-color" href="#tab-top-hot">
                           <span class="hide-on-mobile"><?php echo $L['popular'];?></span>
                           <i class="icon-star hide-on-desktop hide-on-tablet"></i>
                       </a>
                   </h2>
               </div> <!--  END Page tabs   -->

               <div class="page-tabs-holder">
                   <!--  First page tab   -->
                   <div class="page-tab" id="tab-recomend">
                       <!--  Recomend  -->
   <?php if(is_array($pro_info)) foreach($pro_info AS $val) { ?>
                       <div class="grid-25 tablet-grid-50">
                           <div class="product-box light-bg">
                               <div class="ribbon-small ribbon-red">
                                   <div class="ribbon-inner">
                                       <span class="ribbon-text px10"><?php echo $L['recom'];?></span>
                                       <span class="ribbon-aligner"></span>
                                   </div>
                               </div>

                               <a class="product-img" href="<?php echo $val['url'];?>">
                                   <?php if($val[thumb]) { ?>
   <span><img src="<?php echo $val['thumb'];?>" alt="<?php echo $val['title'];?>" /></span>
   <?php } else { ?>
   <span><img src="images/ico/no_img.gif" alt="<?php echo $val['title'];?>" /></span>
   <?php } ?>
                               </a>

                               <div class="product-info light-bg middle-border">
                                   <h3 class="product-title subheader-font">
                                       <a href="<?php echo $val['url'];?>" class="dark-color active-hover">
                                           <strong><?php echo $val['title'];?></strong>
                                       </a>
                                   </h3>
   <i class="icon-th active-color"></i>
                                   <a href="<?php echo $val['caturl'];?>" class="product-category middle-color dark-hover"><?php echo $val['catname'];?></a>
   <i class="icon-globe active-color"></i>
                                   <a href="<?php echo $val['areaurl'];?>" class="product-category middle-color dark-hover"><?php echo $val['areaname'];?></a>
                                   <div class="product-bottom">
                                        <div class="product-stars voting-stars stars-small">
                                            <i class="icon-time active-color"></i><?php echo $val['postdate'];?>
                                        </div>
<?php if($val[price]) { ?>
                                        <div class="product-price active-color">
                                        <strong><?php echo number_format($val[price], 2, '.', ' ');?> <?php echo $val['unit'];?></strong>
                                        </div>
<?php } ?>

                                        <div class="clear"></div>
                                   </div>
                               </div>
                           </div>
                       </div><!--  END Recomend   -->
                       
<?php } ?>


                       <div class="grid-100 clear-before">
                           <a class="button-block middle-color dark-hover light-bg middle-border" href="cat.php">
                               <strong><?php echo $L['f_see_all'];?></strong> &nbsp; <i class="icon-arrow-right"></i>
                           </a>
                       </div>
                   </div><!--  END Recomend page tab   -->




                   <!--  TOP page tab   -->
                   <div class="page-tab" id="tab-top-rated">
                     <?php if(is_array($top_info)) foreach($top_info AS $val) { ?>
                       <!--  TOP  -->
                       <div class="grid-25 tablet-grid-50">
                           <div class="product-box light-bg">
                               <div class="ribbon-small ribbon-green">
                                   <div class="ribbon-inner">
                                       <span class="ribbon-text"><?php echo $L['in_top_home'];?></span>
                                       <span class="ribbon-aligner"></span>
                                   </div>
                               </div>

                               <a class="product-img" href="<?php echo $val['url'];?>">
                                   <?php if($val[thumb]) { ?>
   <span><img src="<?php echo $val['thumb'];?>" alt="<?php echo $val['title'];?>" /></span>
   <?php } else { ?>
   <span><img src="images/ico/no_img.gif" alt="<?php echo $val['title'];?>" /></span>
   <?php } ?>
                               </a>

                               <div class="product-info light-bg middle-border">
                                   <h3 class="product-title subheader-font">
                                       <a href="<?php echo $val['url'];?>" class="dark-color active-hover">
                                           <strong><?php echo $val['title'];?></strong>
                                       </a>
                                   </h3>
   <i class="icon-th active-color"></i>
                                   <a href="<?php echo $val['caturl'];?>" class="product-category middle-color dark-hover"><?php echo $val['catname'];?></a>
   <i class="icon-globe active-color"></i>
                                   <a href="<?php echo $val['areaurl'];?>" class="product-category middle-color dark-hover"><?php echo $val['areaname'];?></a>

                                   <div class="product-bottom">
                                        <div class="product-stars voting-stars stars-small">
                                            <i class="icon-time active-color"></i><?php echo $val['postdate'];?>
                                        </div>
<?php if($val[price]) { ?>
                                        <div class="product-price active-color">
                                        <strong><?php echo number_format($val[price], 2, '.', ' ');?> <?php echo $val['unit'];?></strong>
                                        </div>
<?php } ?>
                                        <div class="clear"></div>
                                   </div>
                               </div>
                           </div>
                       </div><!--  END TOP   -->
                        
<?php } ?>

                       <div class="grid-100 clear-before">
                           <a class="button-block middle-color dark-hover light-bg middle-border" href="cat.php">
                               <strong><?php echo $L['f_see_all'];?></strong> &nbsp; <i class="icon-arrow-right"></i>
                           </a>
                       </div>
                   </div><!--  END Second page tab   -->
   
   
                   <!--  HOT page tab   -->
                   <div class="page-tab" id="tab-top-hot">
                     <?php if(is_array($hot_info)) foreach($hot_info AS $val) { ?>
                       <!--  HOT  -->
                       <div class="grid-25 tablet-grid-50">
                           <div class="product-box light-bg">
                               <div class="ribbon-small ribbon-blue">
                                   <div class="ribbon-inner">
                                       <span class="ribbon-text"><?php echo $L['popular'];?></span>
                                       <span class="ribbon-aligner"></span>
                                   </div>
                               </div>

                               <a class="product-img" href="<?php echo $val['url'];?>">
                                   <?php if($val[thumb]) { ?>
   <span><img src="<?php echo $val['thumb'];?>" alt="<?php echo $val['title'];?>" /></span>
   <?php } else { ?>
   <span><img src="images/ico/no_img.gif" alt="<?php echo $val['title'];?>" /></span>
   <?php } ?>
                               </a>

                               <div class="product-info light-bg middle-border">
                                   <h3 class="product-title subheader-font">
                                       <a href="<?php echo $val['url'];?>" class="dark-color active-hover">
                                           <strong><?php echo $val['title'];?></strong>
                                       </a>
                                   </h3>
   <i class="icon-th active-color"></i>
                                   <a href="<?php echo $val['caturl'];?>" class="product-category middle-color dark-hover"><?php echo $val['catname'];?></a>
   <i class="icon-globe active-color"></i>
                                   <a href="<?php echo $val['areaurl'];?>" class="product-category middle-color dark-hover"><?php echo $val['areaname'];?></a>

                                   <div class="product-bottom">
                                        <div class="product-stars voting-stars stars-small">
                                            <i class="icon-time active-color"></i><?php echo $val['postdate'];?>
                                        </div>
<?php if($val[price]) { ?>
                                        <div class="product-price active-color">
                                        <strong><?php echo number_format($val[price], 2, '.', ' ');?> <?php echo $val['unit'];?></strong>
                                        </div>
<?php } ?>
                                        <div class="clear"></div>

                                   </div>
                               </div>
                           </div>
                       </div><!--  END TOP   -->
                        
<?php } ?>

                       <div class="grid-100 clear-before">
                           <a class="button-block middle-color dark-hover light-bg middle-border" href="cat.php">
                               <strong><?php echo $L['f_see_all'];?></strong> &nbsp; <i class="icon-arrow-right"></i>
                           </a>
                       </div>
                   </div><!--  END Second page tab   -->
  
               </div>
           </div><!--  END Page block with tabs   -->


                   <!--  NEW  -->
                  <div class="page-block cream-bg grid-container">
                <div class="grid-100">
                    <h2 class="active-color header-font"><?php echo $L['new_listing'];?></h2>
                </div>
                       <?php if(is_array($new_info)) foreach($new_info AS $val) { ?>
                       <div class="product-wide light-bg clearfix">
                           <div class="grid-15 tablet-grid-20 mobile-grid-35 product-img-holder">
                                <a class="product-img" href="<?php echo $val['url'];?>">
                                   <?php if($val[thumb]) { ?>
   <span><img src="<?php echo $val['thumb'];?>" alt="<?php echo $val['title'];?>" /></span>
   <?php } else { ?>
   <span><img src="images/ico/no_img.gif" alt="<?php echo $val['title'];?>" /></span>
   <?php } ?>
                                </a>
                           </div>
                           
                           <div class="grid-85 tablet-grid-45 mobile-grid-65 product-description">
                                <h3 class="product-title subheader-font">
                                   <a href="<?php echo $val['url'];?>" class="dark-color active-hover">
                                       <strong><?php echo $val['title'];?></strong>
                                   </a>
                               </h3>
                               <a href="<?php echo $val['caturl'];?>" class="product-category middle-color dark-hover"><?php echo $val['catname'];?></a>
                               <p class="dark-color hide-on-mobile"><?php echo cut_str($val[content], 86, '..');?></p>
                           </div>
                       </div>

<?php } ?>
  
                   </div><!--  END NEW   --> 

                   <!--  ARTICLE  -->
                  <div class="page-block cream-bg grid-container">
                <div class="grid-100">
<h2 class="active-color header-font"><a href="article.php" class="active-color dark-hover"><?php echo $L['f_articles'];?> <i class="icon-hand-right"></i></a></h2>
                </div>
<?php if($articles) { ?>
                       <?php if(is_array($articles)) foreach($articles AS $val) { ?>
                               <div class="well well-box cream-bg">
                                <h3 class="product-title subheader-font">
                                   <a href="<?php echo $val['url'];?>" class="dark-color active-hover">
                                       <strong><?php echo $val['ctitle'];?></strong>
                                   </a><span class="hide-on-mobile f_r f_gray"><i class="icon-time"></i> <?php echo $val['addtime'];?></span>
                               </h3>
                       </div>

<?php } ?>
 
                  <?php } else { ?>
   <div class="well well-box cream-bg">
                         <?php echo $L['articles_yet'];?>
                          </div>
                    <?php } ?>					
                   </div><!--  END ARTICLE   --> 

           <!--  Page block  -->
           <div class="page-block cream-bg grid-container">
                <div class="grid-100 margin-bottom">
                    <div class="tip dark-color light-bg">
                        <span class="tip-ribbon"></span>
                        <p>
                            <strong><?php echo ads_list('150', ads);?></strong>
                            
                        </p>
                    </div>
                </div>

                <!-- Page block company  -->
                <div class="grid-100">
<h2 class="active-color header-font"><a href="com.php" class="active-color dark-hover"><?php echo $L['f_company'];?> <i class="icon-hand-right"></i></a></h2>
                </div>


                <!-- Blog items  -->
                <div class="blog-grid margin-bottom clearfix">
<?php if(is_array($company)) foreach($company AS $val) { ?>
                    <!-- Grid block item  -->
                    <div class="blog-item grid-25 tablet-grid-25">
                        <h3 class="blog-title subheader-font">
                            <a href="<?php echo $val['url'];?>" class="dark-color active-hover">
                                <strong><?php echo $val['sname'];?></strong>
                            </a>
                        </h3>

                        <div class="blog-info middle-color">
                            <i title="<?php echo $L['d_added'];?>" class="icon-time"></i> <?php echo $val['postdate'];?>&nbsp; | &nbsp;
                            <i title="<?php echo $L['viewed'];?>" class="icon-eye-open"></i> <?php echo $val['click'];?>
                        </div>

                        <a href="<?php echo $val['url'];?>" class="thumbnail light-bg">
                            <img src="<?php echo $val['thumb'];?>" alt="<?php echo $val['comname'];?>" />
                            <span class="thumbnail-arrow light-color active-border"><i class="icon-briefcase"></i></span>
                        </a>

                        <p class="blog-description dark-color"><?php echo cut_str($val[content], 86, '..');?></p>
                    </div> <!-- END Grid block item  -->

<?php } ?>

                </div><!-- END Blog items  -->


                <!-- Horizontal ruler  -->
                <div class="grid-100">
                    <hr class="margin-bottom" />
                </div>

<?php if(!empty($links[image]) || !empty($links[txt])) { ?>
                <!-- Brands  -->
                <div class="grid-100">
                    <h2 class="active-color header-font"><?php echo $L['partners'];?></h2>
                </div>
                <div class="block-brands margin-bottom">
                    <!-- Brands row  -->
                    <div class="brands-row margin-bottom clearfix">
<?php if(!empty($links[image])) { ?>
<?php if(is_array($links[image])) foreach($links[image] AS $link) { ?>
                        <div class="grid-25 tablet-grid-50 grid-parent">
                            <div class="brand-item grid-50 tablet-grid-50 mobile-grid-50">
                                <a href="<?php echo $link['url'];?>" target="_blank"><img src="<?php echo $link['logo'];?>" width="100" height="40" alt="<?php echo $link['webname'];?>" /></a>
                            </div>
                        </div>

<?php } ?>

<?php } ?>

<?php if(!empty($links[txt])) { ?>
<?php if(is_array($links[txt])) foreach($links[txt] AS $link) { ?>
                        <div class="grid-25 tablet-grid-50 grid-parent">
                            <div class="brand-item grid-50 tablet-grid-50 mobile-grid-50">
                                <a href="<?php echo $link['url'];?>" target="_blank"><?php echo $link['webname'];?></a>
                            </div>
                        </div>

<?php } ?>

<?php } ?>
                    </div><!-- END Brands row  -->
                </div><!-- END Brands  -->
<?php } ?>

                <!-- Horizontal ruler  -->
                <div class="grid-100">
                    <hr class="margin-bottom" />
                </div>
           </div> <!-- END Page block  -->
       </section>

<?php include template(footer); ?>
