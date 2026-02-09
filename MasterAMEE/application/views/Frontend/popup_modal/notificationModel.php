<?php
/*$notiPopShowSts = 0;
$cookie_prefix = $this->config->item('cookie_prefix');
if(isset($_COOKIE[$cookie_prefix."notification_data".$universityId]) && $_COOKIE[$cookie_prefix."notification_data".$universityId]!=''){	
	$jsonNotiArr = json_decode($_COOKIE[$cookie_prefix."notification_data".$universityId]);
	foreach($jsonNotiArr as $notiD){
		if($notiD->popShowSts==1){
			$notiPopShowSts = 1;
			break;
		}
	}
}*/
?>
<div class="modal fade fooNotiModel" id="fooNotiModel" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<strong>Notification</strong>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<?php
				$notiPopShowSts = 0;
				$notiIdsArr = array();
				$notiIds = '';
				$cookie_prefix = $this->config->item('cookie_prefix');
				$universityId = $this->config->item('cv_university_id');
				if(isset($_COOKIE[$cookie_prefix."notification_data".$universityId]) && $_COOKIE[$cookie_prefix."notification_data".$universityId]!=''){	
					$jsonNotiArr = json_decode($_COOKIE[$cookie_prefix."notification_data".$universityId]);
					foreach($jsonNotiArr as $notiD){
					if($notiD->popShowSts==1){
					$notiIdsArr[] = $notiD->notificationId;?>
					<div class="notItem">
						<h4 class="htitle"><?php echo $notiD->title;?> - <small><?php echo date('d M Y, h:i A',$notiD->createTime);?></small></h4>
						<?php echo $notiD->messageBody;?>
					</div>
				<?php $notiPopShowSts = 1; } } $notiIds = implode(',',$notiIdsArr); } ?>
			</div>
			<?php if($notiPopShowSts==1){?><div class="modal-footer">
				<button type="button" class="btn btn-primary" id="disnotiBtn" onclick="return notiDismissFun('<?php echo $notiIds;?>');">Dismiss it!</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div><?php } ?>
		</div>
	</div>
</div>
<?php if($notiPopShowSts==1){?>
<script type="text/javascript">  
jQuery(function () {  
	jQuery("#fooNotiModel").modal('show');
});
function notiDismissFun(notiIds){//alert(notiIds);
	jQuery.ajax({
		type: "POST", 
		url: '<?php echo base_url();?>home/updateNotificationCookie?deptId=<?php echo $dept_session_details->id;?>&notiIds='+notiIds,
		beforeSend: function(){
			jQuery('#disnotiBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');					
		},
		success: function(result, status, xhr){//alert(result);
			jQuery("#fooNotiModel").modal('hide');
		}
	});
}
</script>
<?php } ?>