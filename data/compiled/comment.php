<?php if(!defined('IN_AWEBCOM'))die('Access Denied'); ?><script type="text/javascript">
function comment(){
parent.document.getElementById("showcomment").innerHTML=document.getElementById("comment").innerHTML;
}
</script>
<body onload="comment()">
<div id="comment">
<?php if($comment) { ?>
<?php if(is_array($comment)) foreach($comment AS $comment) { ?>
<div class="blog-comment middle-color">
<strong class="dark-color"><?php echo $comment['username'];?></strong>
 <?php echo $comment['postdate'];?>
<p><?php echo nl2br($comment[content]);?></p>
</div>
<div class="margin-bottom"><hr /></div>

<?php } ?>

<div class="well-shadow well-box cream-bg px13 f_gray">
<?php echo $L['mp_total_records'];?>: <?php echo $pager['count'];?>&nbsp;&nbsp;<?php echo $L['mp_displaying_pages'];?>: <font color="red"><?php echo $pager['page'];?></font> <?php echo $L['mp_of'];?> <?php echo $pager['page_count'];?>&nbsp;&nbsp;<?php echo $L['mp_data_page'];?>: <?php echo $pager['size'];?>&nbsp;&nbsp;
</div>
<div class="page">
<?php if($pager[first]) { ?>
<a class="pager-page" href="<?php echo $pager['first'];?>" target='icomment'><?php echo $L['mp_first'];?></a>
<?php } else { ?><?php } ?>
<?php if($pager[prev]) { ?>
<a class="pager-page" href="<?php echo $pager['prev'];?>" target='icomment'><?php echo $L['mp_previous'];?></a>
<?php } else { ?><?php } ?>
<?php if($pager[next]) { ?>
<a class="pager-page" href="<?php echo $pager['next'];?>" target='icomment'><?php echo $L['mp_next'];?></a>
<?php } else { ?><?php } ?>
<?php if($pager[last]) { ?>
<a class="pager-page" href="<?php echo $pager['last'];?>" target='icomment'><?php echo $L['mp_last'];?></a>
<?php } else { ?><?php } ?>

</div>
</div>
<?php } else { ?>
 <div class="grid-100 well well-box cream-bg"><?php echo $L['no_comments_yet'];?></div>
<?php } ?>
