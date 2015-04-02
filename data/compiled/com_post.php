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
                        <div class="progress-step middle-color">
                            <a class="step-outer">
                                <span class="step-inner">
                                    <span>1</span>
                                </span>
                              <?php echo $L['f_select_category'];?>
                            </a>
                        </div>
                        <div class="progress-step active-color current-step">
                            <a class="step-outer">
                                <span class="step-inner">
                                    <span class="light-color active-bg">2</span>
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
               <!-- Content  --> 
               <div class="content-holder grid-100"> 
   <form id="form_post" class="content-form" name="post" action="" method="post" enctype="multipart/form-data" onsubmit="return validate()">

                           <div class="box-table">
   
                            <div class="align-center">
                                <h2 class="subheader-font bigger-header margin-bottom">
                                    <?php echo $L['your_ip'];?>: <strong class="active-color"><?php echo $ip;?></strong>
                                </h2>
 </div>
                                <blockquote class="active-border cream-bg">
                                    <?php echo $L['you_chosen_category'];?>: <strong class="button-normal light-color middle-gradient dark-gradient-hover"><?php echo $com_catinfo['catname'];?></strong>
&nbsp;&nbsp;
   <a href="postcom.php" class="button-small button-with-icon light-color active-gradient dark-gradient-hover">
  <?php echo $L['change_category'];?> <span><i class="icon-hand-right"></i></span>
   </a>
                                </blockquote>

                            <h2 class="bigger-header with-border subheader-font">
                                <?php echo $L['summary_information'];?>
                            </h2>

                                <div class="form-input">
                                    <label for="areaid" class="middle-color"><span class="f_b f_red px18">*</span> <?php echo $L['area'];?></label>
<div class="grid-70">
<div class="custom-selectbox dark-color light-gradient active-hover">
<select name="areaid" id="areaid">
<option value="">-- <?php echo $L['select'];?> --</option>
 <?php echo $area_option;?>
</select>
</div>
                        </div>
<span class="tips" id="tip_span_areaid"></span>
                                </div>	
   
                                <div class="form-input">
                                    <label for="comname" class="middle-color"><span class="f_b f_red px18">*</span> <?php echo $L['company_name'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" placeholder="<?php echo $L['f_max_80_characters'];?>" name="comname" id="comname" style="width:500px;"/>
<span class="tips" id="tip_span_comname"></span>
                                </div>

                                <div class="form-input">
                                    <label for="keywords" class="middle-color"><?php echo $L['keywords'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" placeholder="<?php echo $L['keywords_tip'];?>" name="keywords" id="keywords" style="width:400px;" />
<p class="middle-color"><?php echo $L['keywords_tip'];?></p>
                                </div>
   
                                <div class="form-input">
                                    <label for="thumb" class="middle-color"><?php echo $L['company_logo'];?></label>
<input type="file" class="text-input dark-color light-bg" style="width:300px;" name="thumb" id="thumb" />
<p class="middle-color"><?php echo $L['width_height'];?>: <?php echo $CFG['com_thumbwidth'];?>&#215;<?php echo $CFG['com_thumbheight'];?></p>
                                </div> 


                                <div class="form-input">
                                    <label for="hours" class="middle-color"><?php echo $L['operation_time'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" placeholder="<?php echo $L['operation_time'];?>" name="hours" id="hours" style="width:300px;"/>
                                </div>  

                                <div class="form-input">
                                    <label for="content" class="middle-color"><span class="f_b f_red px18">*</span> <?php echo $L['about_company'];?></label>
                                   <textarea class="textarea-input dark-color light-bg" name="content" id="content" placeholder="<?php echo $L['about_company_tip'];?>..."></textarea>
<span class="tips" id="tip_span_content"></span>
                                </div>

                                <div class="form-input">
                                    <label for="content" class="middle-color"><?php echo $L['image'];?></label>
<div class="grid-70 well well-box cream-bg">
                   <div class="box grid-33 tablet-grid-33">
<input type="file" class="text-input dark-color light-bg" style="width:300px;" name="file1" id="file1" onchange="tstFile(this)" multiple="true">&nbsp;
<input type="file" class="text-input dark-color light-bg" style="width:300px;" name="file2" />&nbsp;
<input type="file" class="text-input dark-color light-bg" style="width:300px;" name="file3" />&nbsp;
</div>
<div class="box grid-33 tablet-grid-33 last">
<input type="file" class="text-input dark-color light-bg" style="width:300px;" name="file4" />&nbsp;
<input type="file" class="text-input dark-color light-bg" style="width:300px;" name="file5" />&nbsp;
<input type="file" class="text-input dark-color light-bg" style="width:300px;" name="file6" />
</div>
<p class="middle-color"><?php echo $L['max_size'];?>: <?php echo $maxupload;?> Kb. <?php echo $L['formats'];?>: JPG, JPEG, GIF, PNG</p>
                                </div></div>


                                <div class="form-input">
                                    <label for="content" class="middle-color"><?php echo $L['pricelist'];?></label>
                    <div class="grid-70 well well-box cream-bg">
                   <div class="box grid-33 tablet-grid-33">
                        <input type="file" class="text-input dark-color light-bg" style="width:300px;" name="file7" />&nbsp;
                    </div>
                       <p class="middle-color"> <?php echo $L['formats'];?>: ZIP, RAR, 7Z</p>
                                </div></div>

                            <h2 class="bigger-header with-border subheader-font">
                                <?php echo $L['contact_details'];?>
                            </h2>

                                <div class="form-input">
                                    <label for="linkman" class="middle-color"><span class="f_b f_hid px18">*</span> <?php echo $L['name_surname'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" style="width:300px;" name="linkman" id="linkman" value="<?php echo $member['surname'];?>" />
                                </div>

          <div class="grid-100 well well-box cream-bg">

                                <div class="form-input">
                                    <label for="email" class="middle-color"><span class="f_b f_hid px18">*</span> E-mail</label>
                                    <input type="text" class="text-input dark-color light-bg" style="width:300px;" name="email" id="email" value="<?php echo $member['email'];?>" placeholder="E-mail"/>
                                </div>

                                <div class="form-input">
                                    <label for="phone" class="middle-color"><span class="f_b f_hid px18">*</span> <?php echo $L['phone'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" style="width:300px;" name="phone" id="phone" value="<?php echo $member['phone'];?>" placeholder="<?php echo $L['phone'];?>"/>
                                </div>

                                <div class="form-input">
                                    <label for="icq" class="middle-color"><span class="f_b f_hid px18">*</span> Skype</label>
                                    <input type="text" class="text-input dark-color light-bg" style="width:300px;" name="icq" id="icq" value="<?php echo $member['icq'];?>" placeholder="Skype"/>
                                </div>
<p class="middle-color"><strong><?php echo $L['given_one_three_contacts'];?></strong></p>	
                         </div>
 
                                <div class="form-input">
                                    <label for="fax" class="middle-color"><?php echo $L['fax'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" name="fax" id="fax" style="width:300px;" value="<?php echo $member['fax'];?>" placeholder="<?php echo $L['fax'];?>"/>
                                </div>  
 
                                <div class="form-input">
                                    <label for="address" class="middle-color"><?php echo $L['address'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" style="width:400px;" name="address" id="address" placeholder="<?php echo $L['address_tip'];?>"/>
                                </div>

            <?php if($CFG[map_check]==1) { ?>							
                                <div class="form-input">
                                    <label for="mappoint" class="middle-color"><?php echo $L['coordinates'];?></label>
<script type="text/javascript" src="js/msgbox/msgbox.js"></script>
<link href="js/msgbox/msgbox.css" type="text/css" rel="stylesheet" />
                    <input type="text" class="text-input dark-color light-bg" style="width:400px;" name="mappoint" id="mappoint" placeholder="<?php echo $L['coordinates'];?>" value="<?php echo $member['mappoint'];?>" readonly="readonly" autocomplete="off"/>
<input name="markmap" type="button" value="<?php echo $L['map'];?>" class="button-normal active-gradient light-color dark-gradient-hover" onclick="Yubox.win('do.php?act=small_map&mark=1&width=700&height=450&p=<?php echo $CFG['map'];?>',700,540,'<?php echo $L['map'];?>',null,null,null,true);">
<p class="middle-color"><?php echo $L['map_check_tip'];?></p>
                        </div>
<?php } ?>


<div class="align-center">
    <button type="submit" class="button-normal active-gradient light-color dark-gradient-hover"><?php echo $L['add'];?></button>
<input id="keyword" type="hidden" name="keyword" />
<input type="hidden" name="catid" value="<?php echo $catid;?>" />
<input type="hidden" name="act" value="postok" />
                    </div> 

                        </div>

                    </form>
                </div><!-- END Content  -->

            </div><!-- END Page block  -->

        </section>

<?php include template(footer); ?>

<script type="text/javascript">jQuery.noConflict();</script>
<script type="text/javascript" src="js/valid/validator.full.js"></script>
<link href="js/valid/validator.css" type="text/css" rel="stylesheet" />
<script type="text/javascript">
$.validator("comname")
.setTipSpanId("tip_span_comname")
.setFocusMsg("<?php echo $L['company_name_empty'];?>")
.setRequired("<?php echo $L['f_are_mandatory'];?>")
.setServerCharset("UTF-8")
.setStrlenType("symbol")
.setMinLength(5, "<?php echo $L['f_min_5_characters'];?>")
.setMaxLength(80, "<?php echo $L['f_max_80_characters'];?>");

$.validator("areaid")
.setTipSpanId("tip_span_areaid")
.setFocusMsg("<?php echo $L['areaid_empty'];?>")
.setRequired("<?php echo $L['areaid_empty'];?>")
.setServerCharset("UTF-8")
.setStrlenType("symbol");

$.validator("phone")
.setTipSpanId("tip_span_phone")

$.validator("icq")
.setTipSpanId("tip_span_icq");

$.validator("email")
.setRegexp(/^\w+((-|\.)\w+)*@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/, "<?php echo $L['f_invalid_email'];?>", false)
.setServerCharset("UTF-8")
.setStrlenType("symbol");

$('form').submit(function(){
if($('#phone').val()=='' && $('#icq').val()=='' && $('#email').val()=='') {
$('#links').html("<font color=red><?php echo $L['given_one_three_contacts'];?></font>");
$('#phone').focus();
return false;
}
});
</script>