<?php if(!defined('IN_AWEBCOM'))die('Access Denied'); ?><div class="well-shadow well-box cream-bg px13 f_gray">
<?php echo $L['mp_total_records'];?>: <?php echo $pager['count'];?>&nbsp;&nbsp;<?php echo $L['mp_displaying_pages'];?>: <font color="red"><?php echo $pager['page'];?></font> <?php echo $L['mp_of'];?> <?php echo $pager['page_count'];?>&nbsp;&nbsp;<?php echo $L['mp_data_page'];?>: <?php echo $pager['size'];?>&nbsp;&nbsp;
</div>
<div class="page">
<?php if($pager[first]) { ?>
<a href="<?php echo $pager['first'];?>"><?php echo $L['mp_first'];?></a>
<?php } else { ?><?php } ?>

<?php if($pager[prev]) { ?>
<a href="<?php echo $pager['prev'];?>"><?php echo $L['mp_previous'];?></a>
<?php } else { ?><?php } ?>

<?php if($pager[next]) { ?>
<a href="<?php echo $pager['next'];?>"><?php echo $L['mp_next'];?></a>
<?php } else { ?><?php } ?>

<?php if($pager[last]) { ?>
<a href="<?php echo $pager['last'];?>"><?php echo $L['mp_last'];?></a>
<?php } else { ?><?php } ?>
</div>