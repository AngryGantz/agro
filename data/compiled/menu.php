<?php if(!defined('IN_AWEBCOM'))die('Access Denied'); ?> <!--    Main menu    -->
            <nav class="main-menu grid-container" id="main-menu">
                <div class="mobile-overlay"></div>
                <!--   Mobile main menu    -->
                <ul class="main-menu-mobile">
                    <li class="middle-color light-hover">
                        <a href="#menu-mobile" class="main-menu-item click-slide"><i class="icon-reorder"></i></a>
                    </li>

                    <li class="middle-color light-hover">
                        <a href="index.php" class="main-menu-item"><i class="icon-home"></i></a>
                    </li>

                    <li class="main-menu-cart active-color light-hover">
                        <a href="<?php echo $CFG['postfile'];?>" class="main-menu-item">
                            <?php echo $L['f_add_listing'];?>
                        </a>
                    </li>
                </ul><!--   END Mobile main menu    -->
                <!--   Tablet and desktop main menu    -->
                <ul class="main-menu-desktop dark-gradient transition-all" id="menu-mobile">
                    <li class="middle-color light-hover home">
                        <a href="<?php echo $CFG['weburl'];?>" class="main-menu-item transition-all"><i class="icon-home"></i></a>
                    </li>

                    <li class="middle-color light-hover back">
                        <a href="#menu-mobile" class="main-menu-item click-slide"><i class="icon-chevron-left"></i></a>
                    </li>

                    <li class="light-color active-hover">
                        <a href="#" class="main-menu-item transition-all"><i class="icon-th"></i> <?php echo $L['f_categories'];?></a>

                        <!--    Mega menu for main menu item    -->
                        <ul class="mega-menu cream-bg full-width">
                            <li class="mega-menu-active cream-gradient"></li>

<?php $i='0';?>

                           <?php if(is_array($cats_list)) foreach($cats_list AS $cat) { ?>
   <?php if($i<7) { ?>
                            <li class="mega-menu-box">
                                <a href="<?php echo $cat['caturl'];?>"><span class="mega-menu-title active-color clearfix"><?php echo $cat['catname'];?></span></a>
 
<!--                                 <ul class="mega-menu-list">
<?php if(is_array($cat[children])) foreach($cat[children] AS $child) { ?>
                                    <li>
                                        <a href="<?php echo $child['url'];?>" class="dark-color active-hover">
                                            <?php echo $child['name'];?><span class="middle-color"><?php if($info_count[$child[id]]==0) { ?> (0)<?php } else { ?> (<?php echo $info_count[$child['id']];?>)<?php } ?></span>
                                        </a>
                                    </li>
    
<?php } ?>

                                </ul>
 -->                            </li>
<?php } ?>

<?php $i++;?>


<?php } ?>
	
                             <div class="f_r"><a href="cat.php" class="button-small button-with-icon light-color active-gradient dark-gradient-hover hide-on-mobile">
                                <?php echo $L['f_see_all'];?> <span><i class="icon-angle-right"></i></span>
                            </a></div>
                        </ul><!--   END Mega menu for main menu item    -->
                    </li>

                    <li class="light-color active-hover">
                        <a href="article.php" class="main-menu-item transition-all"><?php echo $L['f_articles'];?></a>
                        </li>				

                    <li class="light-color active-hover">
                        <a href="com.php" class="main-menu-item transition-all"><?php echo $L['f_company'];?></a>
                    </li>

                    <li class="light-color active-hover">
                        <a href="help.php" class="main-menu-item transition-all"><?php echo $L['f_help'];?></a>
                    </li>
<?php if(!empty($CFG['mailspam'])) { ?>
                    <li class="light-color active-hover">
                        <a href="cont.php" class="main-menu-item transition-all"><?php echo $L['f_contacts'];?></a>
                    </li>
<?php } ?>
                </ul><!--   END Tablet and desktop main menu    -->
            </nav><!--    END Main Menu    -->