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
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/js/fancybox/jquery.fancybox-1.3.4.css" type="text/css">
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/js/juicy/css/themes/shoppie-product/style.css" type="text/css">
        <!--[if IE 7]>
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/style/font-awesome/css/font-awesome-ie7.min.css">
        <![endif]-->
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/style/colors/red.css" type="text/css">
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/style/base.css" type="text/css">
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/style/layout.css" type="text/css">
        <link rel="stylesheet" href="templates/<?php echo $CFG['tplname'];?>/style/pages/product-detail.css" type="text/css">
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
                    <div class="sidebar-box sidebar-bottom cream-gradient">    
                        <h2 class="header-font active-color"><?php echo $L['notice'];?></h2>
                            <ul class="sidebar-list">
                                <li class="sidebar-divider"></li>
                                <li>
                                    <blockquote class="active-border cream-bg margin-bottom">
<?php echo $L['notice_text'];?>
</blockquote>    
                                </li>

                                <li class="sidebar-divider"></li>
<?php if($thumb) { ?>
                                 <li>
 <img src="<?php echo $thumb;?>" width="250" height="120" alt="<?php echo $comname;?>" />
  </li>
  <li class="sidebar-divider"></li>
  <?php } ?>
  
                                <li>

<span>
<a class="button-small light-color middle-gradient dark-gradient-hover" href="member.php?act=editcom&id=<?php echo $comid;?>"><?php echo $L['change'];?></a>
                                <li class="sidebar-divider"></li>
</span>    
                                </li>
                            </ul>
</div>
               </div><!-- END Sidebar  --> 
               
               <!-- Content  --> 
               <div class="content-with-sidebar grid-75">
                   <div class="product-detail-shadow">
                       <!-- Product detail informations  -->
                       <div class="product-detail cream-gradient grid-container">
                            <!-- gallery  --> 
<?php if($com_images) { ?>
                            <div class="product-images grid-40 tablet-grid-40 juicy-wrapper">
                                <ul id="product-gallery" class="juicy-slider middle-border">
<?php if(is_array($com_images)) foreach($com_images AS $row) { ?>
                                    <li>
                                        <a href="<?php echo $row['path'];?>" class="fancybox" target="_blank">
                                            <img class="juicy-bg" src="<?php echo $row['path'];?>" data-thumb="<?php echo $row['path'];?>" alt="" />
                                        </a>                                                                                                                              
                                    </li> 

<?php } ?>

                                </ul>
                                <div class="juicy-slider-nav juicy-thumbs middle-border dark-border-hover active-border-selected" data-type="thumbs"></div>
                            </div><!-- END gallery  --> 
<?php } ?>
                            <!-- description  --> 

                           <div class="product-info grid-55 tablet-grid-55">
                                <h1 class="header-font dark-color"><?php echo $comname;?></h1>
                                <p class="product-perex">
                                   <?php echo $description;?>
                                </p>
                                <div class="product-meta-price clearfix">
                                    <div class="product-meta middle-color grid-75">

                                        <table>
                                            <tr>
                                                <td><?php echo $L['d_added'];?>:</td>
                                                <td><span class="f_b"><?php echo $postdate;?></span></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $L['viewed'];?>:</td>
                                                <td><span class="f_b"><?php echo $click;?></span></td>
                                            </tr>
                                        </table> 

                                    </div>

                                </div>
                                <p>&nbsp;</p>
                                
                <h4><a class="dark-color active-hover" href="<?php echo $pricelist;?>" title="Прайслист компании"><?php echo $L['download_price'];?></a> </h4>
                            </div><!-- END Product description  --> 
                       </div><!-- END Product detail informations  --> 
                       <div class="product-detail-tabs grid-100 light-bg">
                           <!--  Page tabs   --> 
                           <div class="page-tabs shoppie-tabs">
                               <h2 class="header-font">
                                   <a class="middle-color active-hover light-bg transition-color" href="#tab-description">
                                       <span class="hide-on-mobile"><?php echo $L['about_company'];?></span>
                                       <i class="icon-align-left hide-on-desktop hide-on-tablet"></i>
                                   </a>
                               </h2>
                               <h2 class="header-font">
                                   <a class="middle-color active-hover light-bg transition-color" href="#tab-cont">
                                       <span class="hide-on-mobile"><?php echo $L['f_contacts'];?></span>
                                       <i class="icon-comments hide-on-desktop hide-on-tablet"></i>
                                   </a>
                               </h2>
   <?php if($CFG['map_check'] && $mappoint) { ?>
                               <h2 class="header-font">
                                   <a class="middle-color active-hover light-bg transition-color" href="#tab-maps">
                                       <span class="hide-on-mobile" onclick="window.frames[0].loadGMap();"><?php echo $L['map'];?></span>
                                       <i class="icon-comments hide-on-desktop hide-on-tablet"></i>
                                   </a>
                               </h2>
   <?php } ?>
                               <h2 class="header-font">
                                   <a class="middle-color active-hover light-bg transition-color" href="#tab-info">
                                       <span class="hide-on-mobile"><?php echo $L['ads'];?></span>
                                       <i class="icon-link hide-on-desktop hide-on-tablet"></i>
                                   </a>
                               </h2>                 
   <?php if(count($match_com)) { ?>
                               <h2 class="header-font">
                                   <a class="middle-color active-hover light-bg transition-color" href="#tab-recom">
                                       <span class="hide-on-mobile"><?php echo $L['popular'];?></span>
                                       <i class="icon-link hide-on-desktop hide-on-tablet"></i>
                                   </a>
                               </h2>
   <?php } ?>
                           </div> <!--  END Page tabs   -->
                           <div class="page-tabs-holder">
                               <!--  description page tab   -->
                               <div class="page-tab grid-100" id="tab-description">
                                   <p><?php echo $introduce;?></p> 
                               </div><!--  END description page tab   -->
                               
                               
                               <!--  contact page tab   -->
                               <div class="page-tab grid-100" id="tab-cont">
                                   <hr class="margin-bottom" />
                                   <div class="grid-100 product-review">

                                       <div class="product-review-author middle-color">
                                            <?php echo $L['name_surname'];?>: <strong class="dark-color"><?php if($linkman) { ?><?php echo $linkman;?><?php } else { ?><?php echo $L['unknown_2'];?><?php } ?></strong>
                                       </div> 
   
                                       <div class="product-review-author middle-color">
                                            <?php echo $L['phone'];?>: <strong class="dark-color"><?php if($phone) { ?><?php echo $phone;?><?php } else { ?><?php echo $L['unknown'];?><?php } ?></strong>
                                       </div> 
   
                                       <div class="product-review-author middle-color">
                                            E-mail: <strong class="dark-color"><?php if($email) { ?><?php echo $email;?><?php } else { ?><?php echo $L['unknown'];?><?php } ?></strong>
                                       </div> 
   
                                       <div class="product-review-author middle-color">
                                            <?php echo $L['fax'];?>: <strong class="dark-color"><?php if($fax) { ?><?php echo $fax;?><?php } else { ?><?php echo $L['unknown'];?><?php } ?></strong>
                                       </div> 
   
                                       <div class="product-review-author middle-color">
                                            Skype: <strong class="dark-color t_c"><?php if($icq) { ?><?php echo $icq;?><?php } else { ?><?php echo $L['unknown'];?><?php } ?></strong>
                                       </div> 
   
                                       <div class="product-review-author middle-color">
                                            <?php echo $L['area'];?>: <strong class="dark-color"><?php echo $areaname;?></strong>
                                       </div>
                                       <div class="product-review-author middle-color">
                                            <?php echo $L['address'];?>: <strong class="dark-color"><?php if($address) { ?><?php echo $address;?><?php } else { ?><?php echo $L['unknown'];?><?php } ?></strong>
                                       </div> 
                                       <div class="product-review-author middle-color">
                                            <?php echo $L['operation_time'];?>: <strong class="dark-color"><?php if($hours) { ?><?php echo $hours;?><?php } else { ?><?php echo $L['unknown_2'];?><?php } ?></strong>
                                       </div> 
                                   </div>
                               </div><!--  END maps page tab   -->

   <?php if($CFG['map_check'] && $mappoint) { ?>
                               <!--  maps page tab   -->
                               <div class="page-tab grid-100" id="tab-maps">
                                   <hr class="margin-bottom" />
                                   <div class="grid-100 product-review">
                                  <iframe id="map" src="do.php?act=big_map&mark=1&mappoint=<?php echo $mappoint;?>&address=<?php echo $address;?>&width=700&height=400" frameborder="0" scrolling="no" width="700" height="400"></iframe>
                                   </div>
                               </div><!--  END maps page tab   -->
   <?php } ?>

                               <!--  owner ads page tab   -->
                               <div class="page-tab grid-100" id="tab-info">
                                   <h4 class="header-font active-color"><?php echo $L['all_ownerads'];?>:</h4> 
                                   <hr class="margin-bottom" />
                                   <div class="grid-100 product-review">
                                      <!-- Блок вывода всех объявлений данного пользователя -->
                                      <?php 
                                        $sqls = "SELECT * FROM `aw_info` WHERE `userid`=$userid";
                                        $infoallads = $db->getAll($sqls);
                                      ?>                    
                                      <?php if(is_array($infoallads)) foreach($infoallads AS $allads) { ?>
                                        <?php $url=url_rewrite('view',array('vid'=>$allads['id']));  ?> 
                                        <p><a class="dark-color active-hover" href="<?php echo $url;?>" target="_blank"><?php echo $allads['title'];?>&nbsp;<?php echo number_format($allads[price], 0, '.', ' ');?><?php echo $allads['unit'];?></a></p>
                                      
<?php } ?>

                                      <!-- END Блок вывода всех объявлений данного пользователя -->                                   
                                   </div> 
                               </div><!--  END owner ads page tab   -->

                               
                               <!--  recom page tab   -->
                               <div class="page-tab grid-100 clearfix" id="tab-recom">
                                   <!--  Product  -->
                                    <?php if(count($match_com)) { ?>
<?php if(is_array($match_com)) foreach($match_com AS $val) { ?>
                                   <div class="grid-25 tablet-grid-25">
                                       <div class="product-box light-bg transition-all">
                                           <div class="ribbon-small ribbon-green">
                                               <div class="ribbon-inner">
                                                   <span class="ribbon-text"><?php echo $L['popular'];?></span>
                                                   <span class="ribbon-aligner"></span>               
                                               </div>
                                           </div> 
                                           
                                   <a class="product-img" href="<?php echo $val['url'];?>">
       <?php if($val[thumb]) { ?>
   <span><img src="<?php echo $val['thumb'];?>" alt="<?php echo $val['comname'];?>" /></span>
   <?php } else { ?>
   <span><img src="images/ico/no_img.gif" alt="<?php echo $val['comname'];?>" /></span>
   <?php } ?>
                                           </a>
                                           
                                           <div class="product-info light-bg middle-border">
                                               <h3 class="product-title subheader-font">
                                                   <a href="<?php echo $val['url'];?>" class="dark-color active-hover">
                                                       <strong><?php echo cut_str($val[comname], 23, '...');?></strong>
                                                   </a>
                                               </h3>
                                           </div>
                                       </div>
                                   </div><!--  END Product   --> 
   
<?php } ?>

                                   <?php } ?>
                               </div><!--  END recom page tab   -->
                           </div>            
                           
                       </div><!-- END all tabs  -->   
                    </div>

<!-- comments -->   
                <div class="content-with-sidebar grid-100">
                    <div class="with-shadow grid-100 light-bg">
                        <div class="content-page content-holder grid-100">
                            <!-- Blog comments -->
                            <a name="comments"></a>
<?php if($CFG['visitor_comment']==1 && !$_userid || $_userid) { ?>
<?php if($CFG['comment_check']==1) { ?>
<div class="well well-box cream-bg">
<span class="f_b f_red"><?php echo $L['comments_checked_before_adding'];?></span>
</div>
<?php } ?>
                            <h2 class="subheader-font uppercase"><?php echo $L['add_comment'];?></h2>
                            <form class="content-form margin-bottom" name="comment" action="member.php?act=comment" method="POST" onsubmit="return checkcomment();">
                            <input type="hidden" name="id" value="<?php echo $comid;?>">
                            <input type="hidden" name="type" value="com">
                                <div class="form-input">
                                    <label for="content" class="middle-color"><span class="f_b f_red px18">*</span> <?php echo $L['content'];?></label>
                                    <textarea class="textarea-input dark-color light-bg" name="content" id="content" cols="10" rows="5"></textarea>
                                </div>

                                <div class="form-input">
                                    <label for="checkcode" class="middle-color"><span class="f_b f_red px18">*</span> <?php echo $L['code'];?></label>
                        <input name="checkcode"  type="text" id="checkcode" class="text-input dark-color light-bg" maxlength="5" style="width:100px;" onfocus='get_code();this.onfocus=null;' />
&nbsp;<span id="imgid"></span></span>
                                </div>

                                <div class="form-submit">
                                    <button type="submit" class="button-normal button-with-icon light-color middle-gradient dark-gradient-hover">
                                       <?php echo $L['comment_add'];?>
                                        <span><i class="icon-angle-right"></i></span>
                                    </button>
                                </div>
                            </form>
   <?php } else { ?>
                                   <div class="alert alert-error"><?php echo $L['comment_add_reg'];?>
   </div>
                                   <div class="topmargin5"></div>
   <p>
                    <a class="button-normal middle-gradient light-color dark-gradient-hover" href="member.php?act=register"><?php echo $L['f_registration'];?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="button-normal middle-gradient light-color dark-gradient-hover" href="member.php?act=login&refer=<?php echo $PHP_URL;?>"><?php echo $L['f_log_in_control_panel'];?></a>
   </p>
   <?php } ?>
                            <hr />
<div id="showcomment"><?php echo $L['comment_loading'];?></div>

                            </div>
                            </div>
                            </div>
<!-- END comments -->   
  
               </div><!-- END Content  --> 
           </div> <!-- END Page block  -->        
       </section>
<script type="text/javascript">
function checkcomment()
{
if(document.comment.content.value==""){
alert('<?php echo $L['enter_content_comment'];?>');
document.comment.content.focus();
return false;
}
if(document.comment.checkcode.value==""){
alert('<?php echo $L['enter_verification_code'];?>');
document.comment.checkcode.focus();
return false;
}
}
</script>
<iframe id="icomment" name="icomment" src="comment_com.php?infoid=<?php echo $comid;?>" frameborder="0" scrolling="no" width="0" height=0></iframe>

<?php include template(footer); ?>
