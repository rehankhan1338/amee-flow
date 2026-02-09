<div class="notiPageData">
<?php if(count($department_notification_list)>0){ 
foreach ($department_notification_list as $row){?>
<div class="col-md-12 notItems">
	<h4 class="htitle"><?php echo $row['title'];?> &nbsp;<small><?php echo '&ndash;&nbsp;'.date('d M Y, h:i A',$row['createTime']);?></small></h4>
	<?php echo $row['messageBody'];?>
</div> 
<?php } } ?>
<div class="clearfix"></div> 