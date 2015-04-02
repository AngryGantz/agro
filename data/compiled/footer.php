<?php if(!defined('IN_AWEBCOM'))die('Access Denied'); ?>       <footer>
            <!-- Footer blocks  -->
            <div class="footer-top grid-container clearfix">
                    <div class="grid-25 tablet-grid-25">
                        <h3 class="light-color subheader-font">
                            <strong><?php echo $L['information'];?></strong>
                        </h3>
                        
<?php if(is_array($static)) foreach($static AS $key => $val) { ?>
<?php if($val[type]>0) { ?>
                        <ul class="middle-color">
                            <li class="light-hover">
                          <a href="<?php echo $val['url'];?>"><?php echo $val['title'];?></a>
<!-- NOT USE THIS TEMPLATE DELIMITIER<?php if($key<(count($static)-1)) { ?> | <?php } ?>-->
                            </li>
                        </ul>
<?php } ?>
                 
<?php } ?>

                    </div>

                    <div class="grid-25 tablet-grid-25">
                        <h3 class="light-color subheader-font">
                            <strong><?php echo $L['account'];?></strong>
                        </h3>

                        <ul class="middle-color">
                            <?php if($_userid) { ?>
<li class="light-hover">
                                <a href="member.php"><?php echo $L['f_control_panel'];?></a>
                            </li>
                            <li class="light-hover">
                                <a href="member.php?act=info"><?php echo $L['f_my_listing'];?></a>
                            </li>
<!--                             <li class="light-hover">
                                <a href="member.php?act=pay"><?php echo $L['fill_up_balance'];?></a>
                            </li>
 -->                            <li class="light-hover">
                                <a href="member.php?act=logout&mid=<?php echo $_userid;?>"><?php echo $L['f_logout'];?></a>
                            </li>
 <?php } else { ?>
<li class="light-hover">
                                <a href="member.php?act=register"><?php echo $L['f_registration'];?></a>
                            </li>
                            <li class="light-hover">
                                <a href="member.php?act=login&refer=<?php echo $PHP_URL;?>"><?php echo $L['f_login_to'];?></a>
                            </li>
                            <li class="light-hover">
                                <a href="member.php?act=get_password"><?php echo $L['f_forgot_password'];?></a>
                            </li>
   <?php } ?>
                        </ul>
                    </div>

                    <div class="grid-25 tablet-grid-25">
                        <h3 class="light-color subheader-font">
                            <strong><?php echo $L['navigation'];?></strong>
                        </h3>

                        <ul class="middle-color">
                            <li class="light-hover">
                                <a href="<?php echo $CFG['weburl'];?>"><?php echo $L['f_home'];?></a>
                            </li>
                            <li class="light-hover">
                                <a href="sitemap.xml">Google Sitemap</a>
                            </li>
                            <?php if($CFG['wap']) { ?>
<li class="light-hover">
                                <a href="./wap">WAP</a>
                            </li>
<?php } ?>
                            <li class="light-hover">
                                <a href="rss.php">RSS</a>
                            </li>
                        </ul>
                    </div>


<!--                     <div class="grid-25 tablet-grid-25">

                        <h3 class="light-color subheader-font">
                            <strong><?php echo $L['we_accept'];?></strong>
                        </h3>

                        <a href="member.php?act=pay"><img src="templates/<?php echo $CFG['tplname'];?>/images/icons/webmoney.png" alt="Webmoney" /></a>
                        <a href="member.php?act=pay"><img src="templates/<?php echo $CFG['tplname'];?>/images/icons/paypal.png" alt="PayPal" /></a>
                        <a href="member.php?act=pay"><img src="templates/<?php echo $CFG['tplname'];?>/images/icons/interkassa.png" alt="Interkassa" /></a>
                        <a href="member.php?act=pay"><img src="templates/<?php echo $CFG['tplname'];?>/images/icons/qiwi.png" alt="QIWI" /></a>
    

                </div> -->
            </div><!-- END Footer blocks  -->


            <!-- Footer copyright and social buttons -->
            <div class="footer-bottom grid-container clearfix">
                <div class="footer-copyright middle-color grid-70">
                    Powered by <a href="http://www.studioboss.kz" class="light-hover">StudioBoss</a>. &copy; <?php echo date("Y");?>
<span class="f_r debug"><?php echo debug();?></span>
                </div>

                <div class="footer-social grid-30">
                    <a href="https://www.facebook.com/" class="middle-color light-hover transition-color" target="_blank">
                        <i class="icon-facebook-sign"></i>
                    </a>
                    <a href="https://twitter.com/" class="middle-color light-hover transition-color" target="_blank">
                        <i class="icon-twitter"></i>
                    </a>
                    <a href="http://www.linkedin.com/" class="middle-color light-hover transition-color" target="_blank">
                        <i class="icon-linkedin-sign"></i>
                    </a>
                    <a href="http://pinterest.com/" class="middle-color light-hover transition-color" target="_blank">
                        <i class="icon-pinterest-sign"></i>
                    </a>
                    <a href="https://plus.google.com/" class="middle-color light-hover transition-color" target="_blank">
                        <i class="icon-google-plus-sign"></i>
                    </a>
                </div>
            </div><!-- END Footer copyright and social buttons -->

       </footer>
       <!-- Scripts -->
   <script type="text/javascript" src="js/jquery.js"></script>
       <script type="text/javascript" src="templates/<?php echo $CFG['tplname'];?>/js/jquery-1.11.0.min.js"></script>
       <script type="text/javascript" src="templates/<?php echo $CFG['tplname'];?>/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
       <script type="text/javascript" src="templates/<?php echo $CFG['tplname'];?>/js/juicy/js/jquery.juicy.js"></script>
       <script type="text/javascript" src="templates/<?php echo $CFG['tplname'];?>/js/shoppie.scripts.js"></script>
       <script type="text/javascript" src="templates/<?php echo $CFG['tplname'];?>/js/tooltips.js"></script>
       <script type="text/javascript" src="js/common.js"></script>
   <script type="text/javascript">
            Global.documentReady(); 
            Homepage.documentReady();
            Product.documentReady(); 
       </script>
       <!-- css3-mediaqueries.js for IE less than 9 -->
       <!--[if lt IE 9]>
       <script type="text/javascript" src="templates/<?php echo $CFG['tplname'];?>/js/css3-mediaqueries.js"></script>
       <![endif]-->
    </body>
</html>