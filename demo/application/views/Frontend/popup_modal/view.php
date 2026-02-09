<div class="modal fade" id="dialog_read_more_popup_messages" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
	            <strong id="read_more_popup_title">Alert</strong>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
            </div>   
			<div class="modal-body" id="read_more_popup_title_content">
				<i style="font-size:24px;" class="fa fa-spinner fa-spin"></i>		 
			</div>
    	</div>
</div>
</div>

<div class="modal fade" id="dialog_feature_disabled_popup_messages" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
	            <strong id="read_more_popup_title">Alert</strong>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
            </div>
 			<div class="modal-body" id="read_more_popup_title_content">This function is disabled for non-academic units. Please go to STEP 5 to start.</div>
    	</div>
</div>
</div>
<script type="text/javascript">
	function open_popup_messages(status, val, id){ //alert(val);
		
		jQuery.ajax({
			url: '<?php echo base_url(); ?>readiness/open_popup_messages_ajax?status='+status+'&val='+val,
			type: 'GET',
			beforeSend: function(){
				$('#lnk_'+id).html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function (result) { 
				var res = result.split("@@@@");
				jQuery('#read_more_popup_title').html(res[0]);
				//var description = res[1].replace(/(<p[^>]+?>|<p>|<\/p>)/img, "");
				jQuery('#read_more_popup_title_content').html(''+res[1]+'');
				jQuery("#dialog_read_more_popup_messages").modal('show');
				$('#lnk_'+id).html('');
			}
		});
	}
	function dialog_feature_disabled_popup_messages(){
		jQuery("#dialog_feature_disabled_popup_messages").modal('show');
	}
</script>