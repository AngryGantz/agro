<?php if(!defined('IN_AWEBCOM'))die('Access Denied'); ?>       <a id="top"></a>
       <header>
            <!--    Top menu    -->
            <nav class="top-menu grid-container hide-on-tablet hide-on-mobile">
                <div class="grid-100">
<?php if($_userid) { ?>
                    <div class="top-menu-left">
                        <ul>
                            <li>
                                <a href="member.php" class="dark-color"><i class="icon-user"></i> <?php echo $L['f_welcome'];?> <?php echo $_username;?></a>
                            </li>
                            <li>
                                <a href="member.php" class="dark-color"><i class="icon-home"></i> <?php echo $L['f_control_panel'];?></a>
                            </li>
<?php if($_status<=0) { ?>
                            <li>
                                <a href="member.php?act=send_check_email" class="dark-color"><i class="icon-envelope"></i> <?php echo $L['f_send_check_email'];?></a>
                            </li>
<?php } ?>
                            <li>
                                <a href="member.php?act=logout&mid=<?php echo $_userid;?>" class="dark-color"><i class="icon-signout"></i> <?php echo $L['f_logout'];?></a>
                            </li>
                        </ul>
                    </div>
        <?php } else { ?>
                    <div class="top-menu-left">
                        <ul>
                            <li>
                                <a href="index.php" class="dark-color"><?php echo $L['f_home'];?></a>
                            </li>
                            <?php if($CFG['wap']) { ?><li>
                                <a href="./wap" class="dark-color">WAP</a>
                            </li><?php } ?>
                            <li>
                                <a href="rss.php" class="dark-color">RSS</a>
                            </li>
                        </ul>
                    </div>
<?php } ?>

                    <div class="top-menu-right">
                        <ul>
<?php if(!$_userid) { ?>
                            <li>
                                <a href="member.php?act=login&refer=<?php echo $PHP_URL;?>" class="dark-color"><i class="icon-off"></i> <?php echo $L['f_login_to'];?></a>
                            </li>

                            <li>
                                <a href="member.php?act=register" class="dark-color"><i class="icon-signin"></i> <?php echo $L['f_registration'];?></a>
                            </li>
                            <li>
                                <a href="member.php?act=get_password" class="dark-color"><i class="icon-unlock"></i> <?php echo $L['f_forgot_password'];?></a>
                            </li>
<?php } ?>


                            <!-- IN PROCESS
<li id="languages-box-holder">
                                <a href="#" class="dark-color">
                                    RU <i class="icon-caret-down"></i>
                                </a>

                                <ul class="languages-box popup-box cream-bg">
                                    <li class="arrow-top"><span class="shadow cream-bg"></span></li>
                                    <li class="focusor-top"></li>

                                    <li>
                                        <a href="#" class="dark-color">
                                            <i class="icon-lang-ru"></i>
                                            <?php echo $L['f_rus'];?>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="dark-color">
                                            <i class="icon-lang-en"></i>
                                            English
                                        </a>
                                    </li>
                                </ul>

                            </li>
-->
                        </ul>
                    </div>
                </div>
            </nav><!--    END Top Menu    -->
            <!--    Middle header    -->

            <div class="header-middle grid-container light-gradient">
<?php if($CFG['slogan']) { ?><div id="top_anonce"><h1><?php echo $CFG['slogan'];?></h1></div><?php } ?>
                <div class="grid-100">
                    <a href="<?php echo $CFG['weburl'];?>" class="header-logo" title="<?php echo $CFG['webname'];?>">
                        <img src="templates/<?php echo $CFG['tplname'];?>/images/logo.png" alt="<?php echo $CFG['webname'];?>" />
                    </a>

                    <div class="grid-80 remove-whitespaces">
                        <div class="header-middle-box">
<form name="form" class="input-with-submit header-search" action="search.php" method="post">
                                <input name="keywords" id="keywords" type="text" class="text-input input-round dark-color light-bg" placeholder="<?php echo $L['f_keywords'];?>">
                                <button type="submit" class="input-round-submit middle-color dark-hover"><i class="icon-search"></i></button>
                            </form>
                        </div>

<!--                         <div class="header-middle-box last-box hide-on-mobile hide-on-tablet">
                            <div class="header-cart" id="header-cart">
                                <a href="postcom.php" class="text-input input-round dark-color light-bg">
                                   <strong class="dark-color"><?php echo $L['add_company'];?></strong>
                                </a>

                            </div>
                        </div>
 -->
                        <div class="header-middle-box last-box hide-on-mobile hide-on-tablet">
                            <div class="header-cart" id="header-cart">
                                <a href="<?php echo $CFG['postfile'];?>" class="text-input input-round dark-color light-bg">
                                   <strong class="active-color"><?php echo $L['f_add_listing'];?></strong>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div><!--    END Middle header    -->
               
<?php include template(menu); ?>

       </header>
