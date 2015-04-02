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
                    <strong class="active-color"><?php echo $L['my_company_edit'];?></strong>
                </div>
            </div> <!-- END Page block  -->

            <!-- Page block content  -->
            <div class="page-block page-block-bottom cream-bg grid-container">
                <div class="sidebar-shadow push-25"></div>

<?php include template(member_left); ?>

 
               <!-- Content  --> 
               <div class="content-with-sidebar grid-75">
     <form id="form" class="content-form margin-bottom" name="post" method="post" action="member.php" enctype="multipart/form-data">   
                        <div class="with-shadow grid-100 light-bg margin-bottom clearfix">
                            <div class="content-page grid-100">

                            <h2 class="bigger-header with-border subheader-font">
                                <?php echo $L['summary_information'];?>
                            </h2>

                                <div class="form-input">
                                    <label for="areaid" class="middle-color"><span class="f_b f_red px18">*</span> <?php echo $L['area'];?></label>
<div class="custom-selectbox dark-color light-gradient active-hover">
<select name="areaid" id="areaid">
<option value="">-- <?php echo $L['select'];?> --</option>
 <?php echo $com_area;?>
</select>
</div>
<span class="tips" id="tip_span_areaid"></span>
                                </div>	

                                <div class="form-input">
                                    <label for="catname" class="middle-color"><span class="f_b f_red px18">*</span> <?php echo $L['category'];?></label>
                                    <span class="f_b px16 f_gray currency"><?php echo $catname;?></span>
                                </div> 
   
                                <div class="form-input">
                                    <label for="comname" class="middle-color"><span class="f_b f_red px18">*</span> <?php echo $L['company_name'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" value="<?php echo $comname;?>" name="comname" id="comname" style="width:500px;"/>
<span class="tips" id="tip_span_comname"></span>
                                </div> 

                                <div class="form-input">
                                    <label for="keywords" class="middle-color"><?php echo $L['keywords'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" value="<?php echo $keywords;?>" name="keywords" id="keywords" style="width:400px;" />
<p class="middle-color"><?php echo $L['keywords_tip'];?></p>
                                </div>


                                <div class="form-input">
                                    <label for="thumb" class="middle-color"><?php echo $L['company_logo'];?></label>
<img src="<?php echo $thumb;?>" width="150px" height="50px">
<input type="file" class="text-input dark-color light-bg" style="width:300px;" name="thumb" id="thumb" />
<p class="middle-color"><?php echo $L['width_height'];?>: <?php echo $CFG['com_thumbwidth'];?>&#215;<?php echo $CFG['com_thumbheight'];?></p>
                                </div> 

                                <div class="form-input">
                                    <label for="thumb" class="middle-color"><?php echo $L['pricelist'];?></label>
                                    <input type="file" class="text-input dark-color light-bg" style="width:300px;" name="pricelist" id="pricelist" />
                                    <p class="middle-color"><?php echo $L['formats'];?>: ZIP, RAR, 7Z</p>
                                </div> 


                                <div class="form-input">
                                    <label for="hours" class="middle-color"><?php echo $L['operation_time'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" value="<?php echo $hours;?>" name="hours" id="hours" style="width:300px;"/>
                                </div>  

                                <div class="form-input">
                                    <label for="introduce" class="middle-color"><span class="f_b f_red px18">*</span> <?php echo $L['about_company'];?></label>
                                   <textarea class="textarea-input dark-color light-bg" name="introduce" id="introduce"><?php echo $introduce;?></textarea>
<span class="tips" id="tip_span_introduce"></span>
                                </div>


                            <h2 class="bigger-header with-border subheader-font">
                                <?php echo $L['contact_details'];?>
                            </h2>

                                <div class="form-input">
                                    <label for="linkman" class="middle-color"><span class="f_b f_hid px18">*</span> <?php echo $L['name_surname'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" style="width:300px;" name="linkman" id="linkman" value="<?php echo $linkman;?>" />
                                </div>

          <div class="grid-100 well well-box cream-bg">

                                <div class="form-input">
                                    <label for="email" class="middle-color"><span class="f_b f_hid px18">*</span> E-mail</label>
                                    <input type="text" class="text-input dark-color light-bg" style="width:300px;" name="email" id="email" value="<?php echo $email;?>" placeholder="E-mail"/>
                                </div>

                                <div class="form-input">
                                    <label for="phone" class="middle-color"><span class="f_b f_hid px18">*</span> <?php echo $L['phone'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" style="width:300px;" name="phone" id="phone" value="<?php echo $phone;?>" placeholder="<?php echo $L['phone'];?>"/>
                                </div>

                                <div class="form-input">
                                    <label for="icq" class="middle-color"><span class="f_b f_hid px18">*</span> Skype</label>
                                    <input type="text" class="text-input dark-color light-bg" style="width:300px;" name="icq" id="icq" value="<?php echo $icq;?>" placeholder="Skype"/>
                                </div>
<p class="middle-color"><strong><?php echo $L['given_one_three_contacts'];?></strong></p>	
                         </div>
 
         <div class="topmargin5"></div>
 
                                <div class="form-input">
                                    <label for="fax" class="middle-color"><?php echo $L['fax'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" name="fax" id="fax" style="width:300px;" value="<?php echo $fax;?>" placeholder="<?php echo $L['fax'];?>"/>
                                </div>  
 
                                <div class="form-input">
                                    <label for="address" class="middle-color"><?php echo $L['address'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" style="width:400px;" name="address" id="address" value="<?php echo $address;?>"/>
                                </div>

            <?php if($CFG[map_check]==1) { ?>	
                                <div class="form-input">
                     <label for="mappoint" class="middle-color"><?php echo $L['coordinates'];?></label>
<script type="text/javascript" src="js/msgbox/msgbox.js"></script>
<link href="js/msgbox/msgbox.css" type="text/css" rel="stylesheet" />
                    <input type="text" class="text-input dark-color light-bg" style="width:400px;" name="mappoint" id="mappoint" placeholder="<?php echo $L['coordinates'];?>" value="<?php echo $mappoint;?>" readonly="readonly" autocomplete="off"/>
<input name="markmap" type="button" value="<?php echo $L['map'];?>" class="button-normal active-gradient light-color dark-gradient-hover" onclick="Yubox.win('do.php?act=small_map&mark=1&width=700&height=450&p=<?php echo $CFG['map'];?>',700,540,'<?php echo $L['map'];?>',null,null,null,true);">
<p class="middle-color"><?php echo $L['map_check_tip'];?></p>
                        </div>
<?php } ?>

<div class="align-center">
<input type="submit" class="button-normal active-gradient light-color dark-gradient-hover" name="submit" value="<?php echo $L['change'];?>" id="submit" />
<input type="hidden" name="id" value="<?php echo $comid;?>"/>
<input type="hidden" name="act" value="updatecom" />
                    </div> 
<div class="topmargin5"></div>

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
$('#phone').focus();
return false;
}
});
</script>

