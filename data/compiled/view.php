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

                    <!-- Sidebar claim box --> 
                    <div class="sidebar-box sidebar-bottom cream-gradient">    


                  <!-- Блок вывода всех объявлений данного пользователя -->
                  <h3 class="header-font active-color"><?php echo $L['all_userads'];?></h3>
                  <?php 
                    $sqls = "SELECT * FROM `aw_info` WHERE `userid`=$infouserid";
                    $infoss = $db->getAll($sqls);
                  ?>                    
                  <?php if(is_array($infoss)) foreach($infoss AS $info) { ?>
                  <?php $url=url_rewrite('view',array('vid'=>$info['id']));  ?> 
                  <a class="dark-color active-hover" href="<?php echo $url;?>" target="_blank"><?php echo $info['title'];?></a><br>
                  
<?php } ?>

                  <!-- END Блок вывода всех объявлений данного пользователя -->


                  <!-- Блок вывода всех компаний данного пользователя -->
                  <p>&nbsp;</p>
                  <h3 class="header-font active-color"><?php echo $L['all_usercompany'];?></h3><br>

                  <?php 
                    $sqls = "SELECT * FROM `aw_com` WHERE `userid`=$infouserid";
                    $infoss = $db->getAll($sqls);
                  ?>                    
                  <?php if(is_array($infoss)) foreach($infoss AS $info) { ?>
                    <?php $url=url_rewrite('com', array('act'=>'view', 'comid'=>$info['comid']));  ?> 
                    <a class="dark-color active-hover" href="<?php echo $url;?>" target="_blank"><?php echo $info['comname'];?></a><br>
                  
<?php } ?>

                  <!-- END Блок вывода всех компаний данного пользователя -->



<!--                        <h2 class="header-font active-color"><?php echo $L['report_abuse'];?></h2>
          						 <form name="report" method="POST" action="member.php" onsubmit="return chkreport()">
         							    <input type="hidden" name="act" value="report">
                          <ul class="grid-90 tablet-grid-90 mobile-grid-90 product-filter">
                              <li class="custom-radio middle-color active-hover">
                                  <input type="radio" name="types" id="types" value="1">
                                  <label for="brand-trend"><?php echo $L['report_abuse_type_1'];?></label>
                              </li>
                              <li class="custom-radio middle-color active-hover">
                                  <input type="radio" name="types" id="types" value="2">
                                  <label for="brand-denim"><?php echo $L['report_abuse_type_2'];?></label>
                              </li>
                              <li class="custom-radio middle-color active-hover">
                                  <input type="radio" name="types" id="types" value="3">
                                  <label for="brand-logg"><?php echo $L['report_abuse_type_3'];?></label>
                              </li>
                              <li class="custom-radio middle-color active-hover">
                                  <input type="radio" name="types" id="types" value="4">
                                  <label for="brand-hc"><?php echo $L['report_abuse_type_4'];?></label>
                              </li>
                          </ul>
              <input type="hidden" name="id" value="<?php echo $id;?>">
                          <ul class="sidebar-list">
                             <li class="sidebar-divider"></li>
                             <li class="align-center">
                                 <button type="submit" name="submit" class="button-small light-color middle-gradient dark-gradient-hover"><?php echo $L['send'];?></button>
                              </li>  
                          </ul>
                        </form>
 -->                    </div><!-- END Sidebar claim box --> 


                    <!-- Sidebar management box --> 



  					<?php if($infouserid>0 && $infouserid==$_userid) { ?>
                    <div class="sidebar-box sidebar-bottom cream-gradient">    
                        <h3 class="header-font active-color"><?php echo $L['management'];?></h3>
                            <ul class="sidebar-list">
                                <li class="sidebar-divider"></li>
                                <li>
<span>
<a class="button-small light-color middle-gradient dark-gradient-hover" href="member.php?act=editinfo&id=<?php echo $id;?>"><?php echo $L['change'];?></a>
<a class="button-small light-color middle-gradient dark-gradient-hover" href="member.php?act=delinfo&id=<?php echo $id;?>" onClick="if(!confirm('<?php echo $L['confirm_delete'];?>'))return false;"><?php echo $L['delete'];?></a>
                                <li class="sidebar-divider"></li>
<!-- 					<a class="button-small active-gradient light-color dark-gradient-hover" href="member.php?act=recom&id=<?php echo $id;?>"><?php echo $L['recommend'];?></a>
<a class="button-small active-gradient light-color dark-gradient-hover" href="member.php?act=top&id=<?php echo $id;?>"><?php echo $L['in_top'];?></a>
 -->					</span>    
                                </li>
                            </ul>
</div>
<?php } else { ?>
<!--                     <div class="sidebar-box sidebar-bottom cream-gradient">
                      <h2 class="header-font active-color"><?php echo $L['management'];?></h2>
                      <ul class="sidebar-list">
                        <li class="sidebar-divider"></li>
                        <li>
                          <blockquote class="active-border cream-bg margin-bottom">
                            <?php echo $L['management_text'];?>
                           <?php echo $L['management_text_1'];?>
                            <br/>                    
                            <a class="button-small light-color active-gradient dark-gradient-hover" href="member.php?act=table_charges"><?php echo $L['f_table_of_charges'];?></a>
                          </blockquote>
                        </li>
                        <?php if(!$_userid) { ?>
                        <li class="align-center">
                          <a class="button-small light-color active-gradient dark-gradient-hover" href="member.php?act=register"><?php echo $L['go_to_registration'];?></a>
                        </li>
                        <?php } ?>
                      </ul>

                      <form name="form3" action="member.php?act=editinfo" method="POST">
                        <ul class="sidebar-list">
                          <div class="custom-selectbox dark-color light-gradient active-hover">
                            <select name="act" id="act">
                              <option value="editinfo"><?php echo $L['edit_ad'];?></option>
                              <option value="delinfo"><?php echo $L['delete_ad'];?></option>
                            </select>
                          </div>
                          <li class="sidebar-divider"></li>
                          <li>
                            <input name="password" type="password" id="delpass" class="text-input input-no-margin dark-color light-bg" placeholder="<?php echo $L['f_password_enter'];?>" autocomplete="off"></li>

                          <li class="align-center">
                            <input class="button-small light-color middle-gradient dark-gradient-hover" onClick="return chktype();" type="submit" value="<?php echo $L['run'];?>" name="submit">                    
                            <input type="hidden" name="id" value="<?php echo $id;?>" />                    
                          </li>
                        </ul>
                      </form>
                    </div> -->
                    <!-- END Sidebar management box -->                    
                 <?php } ?>                    


               </div><!-- END Sidebar  --> 
               <!-- Content  --> 
               <div class="content-with-sidebar grid-75">
                   <div class="product-detail-shadow">
                   
                       <!-- Product detail informations  -->
                       <div class="product-detail cream-gradient grid-container">

                            <?php if($is_pro) { ?><div class="ribbon-small ribbon-red">
                               <div class="ribbon-inner">
                                   <span class="ribbon-text"><?php echo $L['recom'];?></span>
                                   <span class="ribbon-aligner"></span>               
                               </div>
                            </div><?php } ?>

                            <!-- gallery  --> 
<?php if($images) { ?>
                            <div class="product-images grid-40 tablet-grid-40 juicy-wrapper">
                                <ul id="product-gallery" class="juicy-slider middle-border">
<?php if(is_array($images)) foreach($images AS $val) { ?>
                                    <li>
                                        <a href="<?php echo $val['path'];?>" class="fancybox" target="_blank">
                                            <img style="max-height: 350px;" class="juicy-bg" src="<?php echo $val['path'];?>" data-thumb="<?php echo $val['path'];?>" alt="<?php echo $title;?>" />
                                        </a>                                                                                                                              
                                    </li> 

<?php } ?>

                                </ul>
                                <div class="juicy-slider-nav juicy-thumbs middle-border dark-border-hover active-border-selected" data-type="thumbs"></div>
                            </div><!-- END gallery  --> 
<?php } ?>
                            <!-- description  --> 
                            <div class="product-info grid-55 tablet-grid-55">
                                <h1 class="header-font dark-color"><?php echo $title;?></h1>
                                <p class="product-perex">
                                   <?php echo $description;?>
                                </p>
                               <p><a href="#comments" class="dark-color active-hover"><i class="icon-comment"></i> <?php echo $L['comment_add'];?></a></p>
                                
                                <div class="product-meta-price clearfix">
<?php if($price) { ?>
                                    <div class="product-price active-color grid-55">
                                        <strong><?php echo number_format($price, 2, '.', ' ');?> <?php echo $unit;?></strong>
                                    </div>
 <div class="topmargin10"></div>
<?php } ?>
                                    <div class="product-meta middle-color grid-75">

                                        <table>
                                            <tr>
                                                <td><?php echo $L['d_added_a'];?>:</td>
                                                <td><span class="f_b"><?php echo $postdate;?></span></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $L['id_listing'];?>:</td>
                                                <td><span class="f_b"><?php echo $id;?></span></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $L['viewed'];?>:</td>
                                                <td><span class="f_b"><?php echo $click;?></span></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $L['term_accommodation'];?>:</td>
                                                <td class="active-color"><span class="f_b"><?php echo $lastdate;?></span></td>
                                            </tr>
<?php if(is_array($custom)) foreach($custom AS $val) { ?>
                                            <tr>
                                                <td><?php echo $val['name'];?>:</td>
                                                <td><span class="f_b"><?php echo $val['value'];?></span></td>
                                            </tr>

<?php } ?>


                                        </table> 
                                    </div>
                                </div>

                            </div><!-- END Product description  --> 
                       </div><!-- END Product detail informations  --> 
                       <div class="product-detail-tabs grid-100 light-bg">
                           <!--  Page tabs   --> 
                           <div class="page-tabs shoppie-tabs">
                               <h2 class="header-font">
                                   <a class="middle-color active-hover light-bg transition-color" href="#tab-description">
                                       <span class="hide-on-mobile"><?php echo $L['description'];?></span>
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
   <?php if($youtube) { ?>
                               <h2 class="header-font">
                                   <a class="middle-color active-hover light-bg transition-color" href="#tab-youtube">
                                       <span class="hide-on-mobile"><?php echo $L['video'];?></span>
                                       <i class="icon-comments hide-on-desktop hide-on-tablet"></i>
                                   </a>
                               </h2>
   <?php } ?>
   <?php if(count($rec_info)) { ?>
                               <h2 class="header-font">
                                   <a class="middle-color active-hover light-bg transition-color" href="#tab-recom">
                                       <span class="hide-on-mobile"><?php echo $L['recom'];?></span>
                                       <i class="icon-link hide-on-desktop hide-on-tablet"></i>
                                   </a>
                               </h2>
   <?php } ?>
                           </div> <!--  END Page tabs   -->
                           <div class="page-tabs-holder">
                               <!--  description page tab   -->
                               <div class="page-tab grid-100" id="tab-description">
                                   <p><?php echo $content;?></p> 
                               </div><!--  END description page tab   -->
                               
                               
                               <!--  contact page tab   -->
                               <div class="page-tab grid-100" id="tab-cont">
                                   <hr class="margin-bottom" />
                                   <div class="grid-100 product-review">
         <?php if($CFG['visitor_view']==1 && !$_userid || $_userid) { ?>
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
                                            Skype: <strong class="dark-color t_c"><?php if($icq) { ?><?php echo $icq;?><?php } else { ?><?php echo $L['unknown'];?><?php } ?></strong>
                                       </div> 
   
                                       <div class="product-review-author middle-color">
                                            <?php echo $L['area'];?>: <strong class="dark-color"><?php echo $areaname;?></strong>
                                       </div>
                                       <div class="product-review-author middle-color">
                                            <?php echo $L['address'];?>: <strong class="dark-color"><?php if($address) { ?><?php echo $address;?><?php } else { ?><?php echo $L['unknown'];?><?php } ?></strong>
                                       </div> 
   
<?php if($_userid && $crypt_email) { ?>
                            <div class="with-shadow grid-100 light-bg margin-bottom clearfix">
                            <div class="content-page grid-100">
                                <h2 class="bigger-header with-border subheader-font">
                                    <?php echo $L['send_message'];?> <?php echo $member['email'];?>
                                </h2>
                            <form name="sendcont" class="content-form margin-bottom" action="member.php?act=send_info_mail" method="POST" onsubmit="return checkcont();">
<input type="hidden" name="email" value="<?php echo $crypt_email;?>" />
                                <div class="form-input">
                                    <label for="surname" class="middle-color"><?php echo $L['your_name'];?> <span class="active-color">*</span></label>
                                    <input type="text" class="text-input dark-color light-bg" name="surname" id="surname" placeholder="<?php echo $L['your_name'];?>"/>
                                </div>
                                <div class="form-input">
                                    <label for="title" class="middle-color"><?php echo $L['theme'];?> <span class="active-color">*</span></label>
                                    <input type="text" class="text-input dark-color light-bg" name="title" id="title" placeholder="<?php echo $L['theme'];?>"/>
                                </div>

                                <div class="form-input">
                                    <label for="content" class="middle-color"><?php echo $L['f_message'];?> <span class="active-color">*</span></label>
                                    <textarea class="textarea-input dark-color light-bg" name="content" id="content" placeholder="<?php echo $L['f_message_content'];?>"></textarea>
                                </div> 
                                <div class="form-input">
                                    <label for="answer" class="middle-color"><?php echo $L['f_answer_question'];?> <span class="active-color">*</span></label>
                                    <input type="text" class="text-input dark-color light-bg" style="width:200px;" name="answer" id="answer" placeholder="<?php echo $L['f_enter_answer_question'];?>"/>
<input type="hidden" id="vid" name="vid" value="<?php echo $verf['vid'];?>" />
<p class="middle-color"><span class="f_b f_red"><?php echo $verf['question'];?></span></p>
                                </div>

                                <div class="form-submit">
                                    <button type="submit" name="submit" class="button-normal uppercase light-color middle-gradient dark-gradient-hover"><?php echo $L['send'];?></button>
                                </div>
                            </form> 
</div>
</div>
<?php } ?>
  
   <?php } else { ?>
                                   <div class="alert alert-error"><?php echo $L['contacts_available_registered'];?>
   </div>
                                   <div class="topmargin5"></div>
   <p>
                    <a class="button-normal middle-gradient light-color dark-gradient-hover" href="member.php?act=register"><?php echo $L['f_registration'];?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="button-normal middle-gradient light-color dark-gradient-hover" href="member.php?act=login&refer=<?php echo $PHP_URL;?>"><?php echo $L['f_log_in_control_panel'];?></a>
   </p>
   <?php } ?>
   
                                   </div>
                               </div><!--  END contact page tab   -->
   <?php if($CFG['map_check'] && $mappoint) { ?>
                               <!--  maps page tab   -->
                               <div class="page-tab grid-100" id="tab-maps">
                                   <hr class="margin-bottom" />
                                   <div class="grid-100 product-review">
   <?php if($CFG['visitor_view']==1 && !$_userid || $_userid) { ?>
                                  <iframe id="map" src="do.php?act=big_map&mark=1&mappoint=<?php echo $mappoint;?>&address=<?php echo $address;?>&width=700&height=400" frameborder="0" scrolling="no" width="700" height="400"></iframe>
   <?php } else { ?>
                                   <div class="alert alert-error"><?php echo $L['contacts_available_registered'];?>
   </div>
                                   <div class="topmargin5"></div>
   <p>
                    <a class="button-normal middle-gradient light-color dark-gradient-hover" href="member.php?act=register"><?php echo $L['f_registration'];?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="button-normal middle-gradient light-color dark-gradient-hover" href="member.php?act=login&refer=<?php echo $PHP_URL;?>"><?php echo $L['f_log_in_control_panel'];?></a>
   </p>
   <?php } ?>
   
                                   </div>
                               </div><!--  END maps page tab   -->
   <?php } ?>
   <?php if($youtube) { ?>
                               <!--  youtube page tab   -->
                               <div class="page-tab grid-100" id="tab-youtube">
                                   <hr class="margin-bottom" />
                                   <div class="grid-100 product-review">
                                    <iframe id="youtube" width="640" height="360" src="<?php echo replaceyoutube($youtube);?>?wmode=transparent" frameborder="0"></iframe>
                                   </div>
                               </div><!--  END youtube page tab   -->
                               <?php } ?>
                               
                               <!--  recom page tab   -->
                               <div class="page-tab grid-100 clearfix" id="tab-recom">
                                   <!--  Product  -->
                                    <?php if(count($rec_info)) { ?>
<?php if(is_array($rec_info)) foreach($rec_info AS $val) { ?>
                                   <div class="grid-25 tablet-grid-25">
                                       <div class="product-box light-bg transition-all">
                                           <div class="ribbon-small ribbon-green">
                                               <div class="ribbon-inner">
                                                   <span class="ribbon-text"><?php echo $L['recom'];?></span>
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
                                                       <strong><?php echo cut_str($val[title], 23, '...');?></strong>
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
                            <input type="hidden" name="id" value="<?php echo $id;?>">
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
function checkcont()
{
if(document.sendcont.surname.value==""){
alert('<?php echo $L['enter_your_name'];?>');
document.sendcont.surname.focus();
return false;
}
if(document.sendcont.title.value==""){
alert('<?php echo $L['enter_theme'];?>');
document.sendcont.title.focus();
return false;
}
if(document.sendcont.content.value==""){
alert('<?php echo $L['enter_content_message'];?>');
document.sendcont.content.focus();
return false;
}
if(document.sendcont.answer.value==""){
alert('<?php echo $L['f_enter_answer_question'];?>');
document.sendcont.answer.focus();
return false;
}
}

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
function chkreport()
{
var radios = document.getElementsByName("types"); 
var resualt = false;
for(i=0;i<radios.length;i++)
{
if(radios[i].checked)
{
    resualt = true;
}
}
if(!resualt)
{   
alert("<?php echo $L['select_type_offense'];?>");
return false;
}
}
function chktype()
{
if(document.form3.password.value==""){
alert('<?php echo $L['f_password_enter'];?>');
document.form3.password.focus();
return false;
}
if(document.form3.act.value=="delinfo"){
return confirm('<?php echo $L['confirm_delete'];?>​​')
}
}
</script>
<iframe id="icomment" name="icomment" src="comment.php?infoid=<?php echo $id;?>" frameborder="0" scrolling="no" width="0" height=0></iframe>

<?php include template(footer); ?>
