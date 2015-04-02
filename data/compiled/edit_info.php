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
                    <strong class="active-color"><?php echo $L['modifying_topic'];?></strong>
                </div>
            </div> <!-- END Page block  -->

            <!-- Page block content  -->
            <div class="page-block page-block-bottom cream-bg grid-container">
                <div class="sidebar-shadow push-25"></div>

<?php include template(member_left); ?>

               <!-- Content  --> 
               <div class="content-with-sidebar grid-75">
   <form class="content-form" name="edit" method="post" onSubmit="return chkedit()" action="member.php" enctype="multipart/form-data">
                            <h2 class="bigger-header with-border subheader-font">
                                <?php echo $L['summary_information'];?>
                            </h2>

                                <div class="form-input">
                                    <label for="areaid" class="middle-color"><span class="f_b f_red px18">*</span> <?php echo $L['area'];?></label>
<div class="custom-selectbox dark-color light-gradient active-hover">
<select name="areaid" id="areaid">
<option value="">-- <?php echo $L['select'];?> --</option>
 <?php echo $info_area;?>
</select>
</div>
                                </div>	


                                <div class="form-input">
                                    <label for="title" class="middle-color"><span class="f_b f_red px18">*</span> <?php echo $L['name'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" value="<?php echo $title;?>" name="title" id="title" style="width:500px;"/>
                                </div>
   
                                <div class="form-input">
                                    <label for="keyword" class="middle-color"><?php echo $L['keywords'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" value="<?php echo $keyword;?>" name="keyword" id="keyword" style="width:400px;" />
<p class="middle-color"><?php echo $L['keywords_tip'];?></p>
                                </div>

                                <div class="form-input">
                                    <label for="enddate" class="middle-color"><?php echo $L['term_days'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" name="enddate" id="enddate" value="<?php echo $lastdate;?>" style="width:80px;" onKeyUp="value=value.replace(/\D+/g,'')"/>
<p class="middle-color"><?php echo $L['term_days_tip'];?></p>
                                </div>

                                <div class="form-input">
                                    <label for="price" class="middle-color"><?php echo $L['price'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" name="price" id="price" value="<?php echo $price;?>" style="width:100px;"/>
                                        <div class="custom-selectbox dark-color light-gradient active-hover" style="width:120px;">
                                            <select name="unit" id="unit">
<option value="<?php echo $unit;?>" selected><?php echo $unit;?></option>
                                                <option value="KZT">KZT</option>
                                                <option value="RUB">RUB</option>
                                                <option value="USD">USD</option>
                                                <option value="EUR">EUR</option>
                                            </select>
                                        </div>
                                </div>

            <?php if(is_array($custom)) foreach($custom AS $item) { ?>
                                <div class="form-input">
                                    <label for="custom" class="middle-color"><?php echo $item['cusname'];?></label>
                                    <?php echo $item['html'];?>
                                </div>
            
<?php } ?>


                                <div class="form-input">
                                    <label for="content" class="middle-color"><span class="f_b f_red px18">*</span> <?php echo $L['content'];?></label>
                                   <textarea class="textarea-input dark-color light-bg" name="content" id="content"><?php echo $content;?></textarea>
<span class="tips" id="tip_span_content"></span>
                                </div>

            <?php if($CFG[youtube_check]==1) { ?>
                                <div class="form-input">
                                    <label for="youtube" class="middle-color"><?php echo $L['youtube'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" value="<?php echo $youtube;?>" name="youtube" id="youtube" style="width:500px;"/>
                <p class="middle-color"><?php echo $L['youtube_tip'];?></p>
                                </div>
<?php } ?>


 <div class="form-input">
<label for="image" class="middle-color"><?php echo $L['image'];?></label>
<div class="controls">
<?php if($images) { ?>
                               <?php if(is_array($images)) foreach($images AS $image) { ?>
   <span style="text-align:center"><img src="../<?php echo $image['path'];?>" width="70" height="70" border="1" style="color:#000000"><a href="member.php?act=delimg&imgid=<?php echo $image['imgid'];?>"> <i rel="tooltip" title="<?php echo $L['delete'];?>" class="icon-remove-circle"></i></a></span>
    
<?php } ?>

<?php } ?>

</div>
</div>

 <div class="form-input">
<div class="controls">
  <? for($i=1;$i<=$img_count;$i++){?><input type="file" class="input-large" name="file<?=$i?>" />
  <?}?>
</div>
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

                                <div class="form-input">
                                    <label for="address" class="middle-color"><?php echo $L['address'];?></label>
                                    <input type="text" class="text-input dark-color light-bg" style="width:400px;" name="address" id="address" value="<?php echo $address;?>"/>
                                </div>		

            <?php if($CFG[map_check]==1) { ?>							
                                <div class="form-input">
                                    <label for="mappoint" class="middle-color"><?php echo $L['coordinates'];?></label>
<script type="text/javascript" src="js/msgbox/msgbox.js"></script>
<link href="js/msgbox/msgbox.css" type="text/css" rel="stylesheet" />
                    <input type="text" class="text-input dark-color light-bg" style="width:400px;" name="mappoint" id="mappoint" value="<?php echo $mappoint;?>" readonly="readonly" autocomplete="off"/>
<input name="markmap" type="button" value="<?php echo $L['map'];?>" class="button-normal active-gradient light-color dark-gradient-hover" onclick="Yubox.win('do.php?act=small_map&mark=1&width=700&height=450&p=<?php echo $CFG['map'];?>',700,540,'<?php echo $L['map'];?>',null,null,null,true);">
<p class="middle-color"><?php echo $L['map_check_tip'];?></p>
                        </div>
<?php } ?>

<div class="align-center">
<input type="hidden" name="id" value="<?php echo $id;?>" />
<input type="hidden" name="act" value="updateinfo" />
<input type="hidden" name="thumb" value="<?php echo $thumb;?>" />
                    <input type="submit" name="submit" class="button-normal active-gradient light-color dark-gradient-hover" value="<?php echo $L['change'];?>" id="submit" />					
                    </div> 

                        </div>

                    </form>
                </div><!-- END Content  -->

            </div><!-- END Page block  -->

        </section>

<script type="text/javascript">
function chkedit(){
if(document.edit.title.value==""){
alert('<?php echo $L['title_empty'];?>');
document.edit.title.focus();
return false;
}
if(document.edit.title.value.length>80 || document.edit.title.value.length<5){
alert('<?php echo $L['f_limit_5_80_characters'];?>');
document.edit.title.focus();
return false;
}
if(document.edit.areaid.value==0){
alert('<?php echo $L['areaid_empty'];?>');
document.edit.areaid.focus();
return false;
}

if(document.edit.content.value==""){
alert('<?php echo $L['content_empty'];?>');
document.edit.content.focus();
return false;
}
if(document.edit.phone.value=="" && document.edit.icq.value=="" && document.edit.email.value==""){
alert('<?php echo $L['given_one_three_contacts'];?>');
document.edit.phone.focus();
return false;
}

}
</script>

<?php include template(footer); ?>
