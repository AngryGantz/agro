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
                    <?php if($_userid) { ?><a href="member.php" class="dark-color active-hover"><?php echo $L['f_control_panel'];?></a><?php } ?>
                    <strong class="active-color"><?php echo $L['f_table_of_charges'];?></strong>
                </div>
            </div> <!-- END Page block  -->
            <!-- Page block content  -->
            <div class="page-block page-block-bottom cream-bg grid-container">
                <div class="sidebar-shadow push-25"></div>

<?php include template(member_left); ?>

 
               <div class="content-with-sidebar grid-75">
                        <div class="with-shadow grid-100 light-bg margin-bottom clearfix">
                            <div class="content-page grid-100">
                                <h2 class="bigger-header with-border subheader-font">
                                    <?php echo $L['f_table_of_charges'];?>
                                </h2>
               <!-- Content  --> 
               <div class="content-holder grid-100"> 
                    <div class="cart-header well-shadow well-table light-bg margin-bottom hide-on-mobile">
                        <div class="well-box-middle grid-50 tablet-grid-50"><?php echo $L['action'];?></div>
                        <div class="well-box-middle align-center last grid-25 tablet-grid-25 active-color"><?php echo $L['amount'];?></div>
                        <div class="well-box-middle align-center grid-25 tablet-grid-25"><?php echo $L['maximum_days'];?></div>
                    </div>
                    
                    <div class="cart-product-list well-shadow">
                    
                        <!-- TABLE  --> 
                        <div class="cart-product well-table light-bg">
                            <div class="well-box-middle well-border-gradient grid-50 tablet-grid-50">
                                <div class="cart-product-info">
                                    <div class="cart-product-title">
                                        <span class="header-font dark-color active-hover"><strong><?php echo $L['f_registration'];?></strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="well-box-middle align-center last grid-25 tablet-grid-25 active-color">
                                <?php if($CFG['register_credit']) { ?><strong><i class="icon-plus"></i> <?php echo $CFG['register_credit'];?> <?php echo $L['min_points'];?></strong>
<?php } else { ?>
<?php echo $L['not_charged'];?>
<?php } ?>
                            </div>
                            <div class="well-box-middle well-border-gradient align-center grid-25 tablet-grid-25 middle-color">
                                <strong>--</strong>
                            </div>
                        </div><!-- END   --> 

                        <!-- TABLE  --> 
                        <div class="cart-product well-table light-bg">
                            <div class="well-box-middle well-border-gradient grid-50 tablet-grid-50">
                                <div class="cart-product-info">
                                    <div class="cart-product-title">
                                        <span class="header-font dark-color active-hover"><strong><?php echo $L['f_login_to_account'];?></strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="well-box-middle align-center last grid-25 tablet-grid-25 active-color">
                                <?php if($CFG['login_credit']) { ?><strong><i class="icon-plus"></i> <?php echo $CFG['login_credit'];?> <?php echo $L['min_points'];?></strong>
<?php } else { ?>
<?php echo $L['not_charged'];?>
<?php } ?>
                            </div>
                            <div class="well-box-middle well-border-gradient align-center grid-25 tablet-grid-25 middle-color">
                                <strong><?php if($CFG['max_login_credit']) { ?><?php echo $CFG['max_login_credit'];?><?php } else { ?>--<?php } ?></strong>
                            </div>
                        </div><!-- END   --> 

                        <!-- TABLE  --> 
                        <div class="cart-product well-table light-bg">
                            <div class="well-box-middle well-border-gradient grid-50 tablet-grid-50">
                                <div class="cart-product-info">
                                    <div class="cart-product-title">
                                        <span class="header-font dark-color active-hover"><strong><?php echo $L['f_add_listing_go'];?></strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="well-box-middle align-center last grid-25 tablet-grid-25 active-color">
                                <?php if($CFG['post_info_credit']) { ?><strong><i class="icon-plus"></i> <?php echo $CFG['post_info_credit'];?> <?php echo $L['min_points'];?></strong>
<?php } else { ?>
<?php echo $L['not_charged'];?>
<?php } ?>
                            </div>
                            <div class="well-box-middle well-border-gradient align-center grid-25 tablet-grid-25 middle-color">
                                <strong><?php if($CFG['max_info_credit']) { ?><?php echo $CFG['max_info_credit'];?><?php } else { ?>--<?php } ?></strong>
                            </div>
                        </div><!-- END   --> 

                        <!-- TABLE  --> 
                        <div class="cart-product well-table light-bg">
                            <div class="well-box-middle well-border-gradient grid-50 tablet-grid-50">
                                <div class="cart-product-info">
                                    <div class="cart-product-title">
                                        <span class="header-font dark-color active-hover"><strong><?php echo $L['adding_comment'];?></strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="well-box-middle align-center last grid-25 tablet-grid-25 active-color">
                                <?php if($CFG['post_comment_credit']) { ?><strong><i class="icon-plus"></i> <?php echo $CFG['post_comment_credit'];?> <?php echo $L['min_points'];?></strong>
<?php } else { ?>
<?php echo $L['not_charged'];?>
<?php } ?>
                            </div>
                            <div class="well-box-middle well-border-gradient align-center grid-25 tablet-grid-25 middle-color">
                                <strong><?php if($CFG['max_comment_credit']) { ?><?php echo $CFG['max_comment_credit'];?><?php } else { ?>--<?php } ?></strong>
                            </div>
                        </div><!-- END   --> 

                        <!-- TABLE  --> 
                        <div class="cart-product well-table light-bg">
                            <div class="well-box-middle well-border-gradient grid-50 tablet-grid-50">
                                <div class="cart-product-info">
                                    <div class="cart-product-title">
                                        <span class="header-font dark-color active-hover"><strong><?php echo $L['adding_top'];?></strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="well-box-middle align-center last grid-25 tablet-grid-25 active-color">
                                <?php if($CFG['info_top_gold']) { ?><strong><i class="icon-minus"></i> <?php echo $CFG['info_top_gold'];?> <?php echo $CFG['currency'];?></strong> <?php echo $L['per_days'];?>
<?php } else { ?>
<?php echo $L['disabled'];?>
<?php } ?>
                            </div>
                            <div class="well-box-middle well-border-gradient align-center grid-25 tablet-grid-25 middle-color">
                                <strong>--</strong>
                            </div>
                        </div><!-- END   --> 

                        <!-- TABLE  --> 
                        <div class="cart-product well-table light-bg">
                            <div class="well-box-middle well-border-gradient grid-50 tablet-grid-50">
                                <div class="cart-product-info">
                                    <div class="cart-product-title">
                                        <span class="header-font dark-color active-hover"><strong><?php echo $L['adding_recomend'];?></strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="well-box-middle align-center last grid-25 tablet-grid-25 active-color">
                                <?php if($CFG['info_recomend']) { ?><strong><i class="icon-minus"></i> <?php echo $CFG['info_recomend'];?> <?php echo $CFG['currency'];?></strong> <?php echo $L['per_days'];?>
<?php } else { ?>
<?php echo $L['disabled'];?>
<?php } ?>
                            </div>
                            <div class="well-box-middle well-border-gradient align-center grid-25 tablet-grid-25 middle-color">
                                <strong>--</strong>
                            </div>
                        </div><!-- END   --> 


      </div>                     
</div> 
                 </div>                    
     </div> 
                        </div>   
               </div><!-- END Content  -->
       
       </section>

<?php include template(footer); ?>
