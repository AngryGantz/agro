<?php if(!defined('IN_AWEBCOM'))die('Access Denied'); ?>                <!-- Sidebar  -->
                <div class="sidebar grid-25 cream-gradient transition-all" id="sidebar-mobile">
                    <!-- Sidebar submenu box -->
                    <div class="sidebar-box sidebar-top cream-gradient">
                        <nav class="submenu">
                            <ul class="expandable-menu">
                                <li class="align-right back">
                                    <a href="#sidebar-mobile" class="dark-color active-hover click-slide"><i class="icon-chevron-right"></i></a>
                                </li>
<?php if(!$_userid) { ?>
                                <li>
                                    <a href="member.php?act=register" class="dark-color active-hover"><?php echo $L['f_registration'];?></a>
                                </li>
                                <li class="sidebar-divider"></li>
                                <li>
                                    <a href="member.php?act=login&refer=<?php echo $PHP_URL;?>" class="dark-color active-hover"><?php echo $L['f_login_to'];?></a>
                                </li>
                                <li class="sidebar-divider"></li>
                                <li>
                                    <a href="member.php?act=get_password" class="dark-color active-hover"><?php echo $L['f_forgot_password'];?></a>
                                </li>
<?php } ?>
<?php if($_userid) { ?>
                                <li>
                                    <a href="member.php" class="dark-color active-hover <?php if($act=='index') { ?>selected<?php } ?>"><?php echo $L['f_control_panel'];?></a>
                                </li>
                                <li class="sidebar-divider"></li>
                                <li>
                                    <a href="member.php?act=modify" class="dark-color active-hover <?php if($act=='modify') { ?>selected<?php } ?>"><?php echo $L['change_data'];?></a>
                                </li>
                                <li class="sidebar-divider"></li>
                                <li>
                                    <a href="member.php?act=edit_password" class="dark-color active-hover <?php if($act=='edit_password') { ?>selected<?php } ?>"><?php echo $L['change_password'];?></a>
                                </li>
<!--                                 <li class="sidebar-divider"></li>
                                <li>
                                    <a href="member.php?act=pay" class="dark-color active-hover <?php if($act=='pay') { ?>selected<?php } ?>"><?php echo $L['fill_up_balance'];?></a>
                                </li>
                                <li class="sidebar-divider"></li>
                                <li>
                                    <a href="member.php?act=inout" class="dark-color active-hover <?php if($act=='inout') { ?>selected<?php } ?>"><?php echo $L['exchange_points'];?> <?php echo $CFG['currency'];?></a>
                                </li>
<?php } ?>
                                <li class="sidebar-divider"></li>
                                <li>
                                    <a href="member.php?act=table_charges" class="dark-color active-hover <?php if($act=='table_charges') { ?>selected<?php } ?>"><?php echo $L['f_table_of_charges'];?></a>
                                </li>
<?php if($_userid) { ?>
                                <li class="sidebar-divider"></li>
                                <li>
                                    <a href="member.php?act=exchange" class="dark-color active-hover <?php if($act=='exchange') { ?>selected<?php } ?>"><?php echo $L['usage_charges'];?></a>
                                </li>
 -->                                <li class="sidebar-divider"></li>
                                <li>
                                    <a href="member.php?act=info" class="dark-color active-hover <?php if($act=='info') { ?>selected<?php } ?>"><?php echo $L['f_my_listing'];?></a>
                                </li>
                                <li class="sidebar-divider"></li>
                                <li>
                                    <a href="member.php?act=info_comment" class="dark-color active-hover <?php if($act=='info_comment') { ?>selected<?php } ?>"><?php echo $L['my_comments'];?></a>
                                </li>
                                <li class="sidebar-divider"></li>
                                <li>
                                    <a href="member.php?act=com" class="dark-color active-hover <?php if($act=='com') { ?>selected<?php } ?>"><?php echo $L['my_company'];?></a>
                                </li>
                                <li class="sidebar-divider"></li>
                                <li>
                                    <a href="postcom.php" class="dark-color active-hover"><?php echo $L['add_company'];?></a>
                                </li>
                                <li class="sidebar-divider"></li>
                                <li>
                                    <a href="member.php?act=logout" class="dark-color active-hover"><?php echo $L['f_logout'];?></a>
                                </li>
<?php } ?>
                            </ul>
                        </nav>
                    </div><!-- END Sidebar submenu box -->
                </div><!-- END Sidebar  -->