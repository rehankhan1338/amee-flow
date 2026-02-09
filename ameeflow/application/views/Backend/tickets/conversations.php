<section class="content">
	<div class="box no-border">
<style>
blockquote {
    padding: 10px 20px;
    margin: 0 0 20px;
    font-size: 17.5px;
    border-left: 5px solid #eee;
}
blockquote p{ margin-bottom:0}
	</style>
		<div class="box-header no-border">
			<script type="text/javascript">
				function update_ticket_status(id){
					var update_status_chk = $('#h_ticket_status_'+id).val();
					if(update_status_chk==0){ var update_status = 1;}else{var update_status = 0;}
					 $.ajax({url: "<?php echo base_url();?>home/ticket_update_status?id="+id+"&ticket_status="+update_status+"&callFrom=admin", 
						beforeSend: function(){ 
							$('#spinner_ticket_status_'+id).html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
						},
						success: function(result){
							$('#h_ticket_status_'+id).val(update_status);
							if(update_status==0){
								$('.reply_class_inner').show();
							}else{
								$('.reply_class_inner').hide();
								window.location = '<?php echo $ticketSecBaseUrl.'tickets';?>';
							}
							$('#spinner_ticket_status_'+id).html(result);

						}
					});
				}
			</script>
			<h3 class="box-title"><label style="margin-right:20px;">Ticket ID - <?php echo $ticket_details->unique_ticket_id;?></label>			
				<input <?php if(isset($ticket_details->ticket_status) && $ticket_details->ticket_status==1){?> checked="checked" <?php } ?> id="toggle-event-ticket_status<?php echo $ticket_details->id;?>" onchange="return update_ticket_status('<?php echo $ticket_details->id;?>');" data-toggle="toggle" data-size="mini" data-onstyle="danger" data-offstyle="success" data-on="Closed" data-off="Open" type="checkbox">
				<input type="hidden" name="h_ticket_status_<?php echo $ticket_details->id;?>" value="<?php echo $ticket_details->ticket_status;?>" id="h_ticket_status_<?php echo $ticket_details->id;?>" />
				<span id="spinner_ticket_status_<?php echo $ticket_details->id;?>"></span>			
			</h3>		 
		</div>
		<div class="box-body">
			  <?php foreach($ticket_conversations_data as $conv){?>
			  	<div class="col-md-12">
				  <blockquote style="font-size:16px;" <?php if($conv->msg_by==1){?>class="pull-right"<?php } ?>>
					<?php echo $conv->problem_msg;?> 
					<label style="font-size:15px;"><?php echo date('D, d M Y, h:i A',$conv->msg_time);?> &nbsp; <?php if($conv->msg_by==0){
					//$user_data = filter_array($supplier_users_data,$conv->user_id,'user_id');
					//echo $user_data[0]['user_name'];
					 }else{echo '(Admin)';}?></label>
				  </blockquote>
				 </div> 
			  <?php } ?>
 		</div>
 		<div class="box-footer">
			<form id="conFrm" method="post" class="reply_class_inner mt10" action="home/conversationEntry" style="display:<?php if(isset($ticket_details->ticket_status) && $ticket_details->ticket_status==0){echo 'block';}else{echo 'none';}?>;"> 
				<input type="hidden" id="h_conversation_cnt" name="h_conversation_cnt" value="<?php echo $ticket_details->conversation_cnt;?>" />
				<input type="hidden" id="msg_by" name="msg_by" value="<?php echo $msg_by;?>" />
				<input type="hidden" name="createdBy" id="createdBy" value="<?php echo $ticket_details->createdBy;?>" />
				<input type="hidden" name="createdById" id="createdById" value="<?php echo $ticket_details->createdById;?>" />
				<input type="hidden" id="h_ticketId" name="h_ticketId" value="<?php echo $ticket_details->id;?>" />
				<input type="hidden" id="h_ticketUniqueId" name="h_ticketUniqueId" value="<?php echo $ticket_details->unique_ticket_id;?>" />
				<input type="hidden" name="ticketSecBaseUrl" id="ticketSecBaseUrl" value="<?php echo $ticketSecBaseUrl;?>" />
				<div id="resTicket"></div>
				<div class="form-fields">
					<label class="form-label">Reply *</label>
					<textarea id="conMsgContent" name="conMsgContent"></textarea>					
				</div>
				<div class="form-fields">
					<button type="submit" class="btn btn-primary" id="conversationBtn" style="padding:6px 30px;">Submit Now!</button>
				</div>
			</form>
		</div>
 	</div>
</section> 


<script>

$(function() {
	 if($('#conMsgContent').length > 0){
    	CKEDITOR.replace( 'conMsgContent',{height: '150px',}); 
	}
	$('#conFrm').validate({
		ignore: [],
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnTxt = $('#conversationBtn').html();
			var baseUrl = '<?php echo base_url(); ?>';
			var form = $('#conFrm');
			var url = baseUrl+form.attr('action');
			for (instance in CKEDITOR.instances) {
				CKEDITOR.instances[instance].updateElement();
			}
            $.ajax({
                type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function() {
					$('#conversationBtn').prop("disabled", true);
					$('#conversationBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr) {
					var resultArr = result.split('||');
					if(resultArr[0] == 'success'){
						window.location = resultArr[1];
					}else{
						$('#resTicket').html('<div class="alert alert-danger">' + resultArr[1] + '</div>');
						$("html, body").animate({scrollTop: 0}, "slow");
						$('#conversationBtn').html(btnTxt);
						$('#conversationBtn').prop("disabled", false);
					}
				},
				error: function(xhr, status, error_desc){
					$("html, body").animate({scrollTop: 0}, "slow");
					$('#resTicket').html('<div class="alert alert-danger">' + error_desc + '</div>');
					$('#conversationBtn').html(btnTxt);
					$('#conversationBtn').prop("disabled", false);
				}
			});
			return false;
		}
	});
});
</script>