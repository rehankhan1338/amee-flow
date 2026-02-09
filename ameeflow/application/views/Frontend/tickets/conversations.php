<style>
.ticket_chat .com_box {display: inline-block;float: right;margin-top:-20px;width: 100px;}
.ticket_chat .chat_box {margin-top: 20px;margin-bottom: 10px;}
.ticket_chat .chat_box .user_comment {border: 1px solid #eee;border-radius: 0 20px 0 20px;padding: 10px 20px;box-shadow: 0 1px 8px #ddd;background-color: #fff;text-align: right;
line-height:25px;}
.ticket_chat .chat_box .admin_comment {border-radius: 20px 20px 0 20px;padding: 10px 20px;box-shadow: 0 1px 8px #ddd;background-color:rgba(3, 63, 123, 0.1);text-align: left;
line-height:25px;}
.chat_box p {margin-bottom:5px;font-size: 15px;}
small{ font-size:80% !important; color:#000 !important; font-style:italic;}
.ticket_chat label{ display:block; font-weight:500; font-size:14px;}
</style>
<div class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box no-border">
				<!-- <div class="box-header no-border">
					<h3 class="box-title">Listing</h3>
					<div class="box-tools pull-right"> 
						<a style="padding: 3px 15px;vertical-align:top; margin-left:5px;" href="<?php echo base_url().'tickets/generate';?>" class="btn btn-outline-primary" > Create your support ticket </a>					
					</div>
				</div> -->
				<div class="box-body row ticket_page">

			<div class="col-md-12">
 				<script type="text/javascript">
					function update_ticket_status(id){
						var update_status_chk = $('#h_ticket_status_'+id).val();
						if(update_status_chk==0){ var update_status = 1;}else{var update_status = 0;}
						 $.ajax({url: "<?php echo base_url();?>home/ticket_update_status?id="+id+"&ticket_status="+update_status, 
							beforeSend: function(){ 
								$('#spinner_ticket_status_'+id).html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
							},
							success: function(result){
								$('#h_ticket_status_'+id).val(update_status);
								if(update_status==0){$('.reply_class_inner').show();}else{$('.reply_class_inner').hide();}
								$('#spinner_ticket_status_'+id).html(result);
							}
						});
					}
				</script>
				<div class="ticket_chat">
					<h4>Ticket ID - <?php echo $ticket_details->unique_ticket_id;?> </h4>
					<div class="com_box">
						<input <?php if(isset($ticket_details->ticket_status) && $ticket_details->ticket_status==1){?> checked="checked" <?php } ?> id="toggle-event-ticket_status<?php echo $ticket_details->id;?>" onchange="return update_ticket_status('<?php echo $ticket_details->id;?>');" data-toggle="toggle" data-width="80" data-height="24" data-onstyle="danger" data-offstyle="success" data-on="Closed" data-off="Open" type="checkbox">
						<input type="hidden" name="h_ticket_status_<?php echo $ticket_details->id;?>" value="<?php echo $ticket_details->ticket_status;?>" id="h_ticket_status_<?php echo $ticket_details->id;?>" />
						<span id="spinner_ticket_status_<?php echo $ticket_details->id;?>"></span>
					</div>
					<label><i>Date : <?php echo date('d M Y, h:i A',$ticket_details->generated_time);?></i></label>
					<label><i>Type of Support : <?php echo $this->config->item('support_types_array_config')[$ticket_details->type_of_support]['name'];?></i></label>
					
					<?php foreach($ticket_conversations_data as $conv){?>
						<div class="chat_box">
						<div class="<?php if($conv->msg_by==0){echo 'user_comment'; }else{echo 'admin_comment';} ?>">
							<p><?php echo $conv->problem_msg;?></p>
							<label><?php echo date('d M Y, h:i A',$conv->msg_time);?></label> 
							<span>&nbsp;<?php if($conv->msg_by==0){
									if($createdBy==1){
										echo ucwords(trim($sessionDetailsArr['userName']));
									}else{
										echo ucwords(trim($sessionDetailsArr['fullName']));
									}
								 }else{echo 'Admin';}?></span>
						</div>
						</div>
					<?php } ?>
				</div>
				<div class="">
					<hr class="hr" />
					<form id="conFrm" method="post" class="reply_class_inner mt10" action="home/conversationEntry" style="display:<?php if(isset($ticket_details->ticket_status) && $ticket_details->ticket_status==0){echo 'block';}else{echo 'none';}?>;"> 
						<input type="hidden" id="h_conversation_cnt" name="h_conversation_cnt" value="<?php echo $ticket_details->conversation_cnt;?>" />
						<input type="hidden" id="msg_by" name="msg_by" value="<?php echo $msg_by;?>" />
						<input type="hidden" name="createdBy" id="createdBy" value="<?php echo $createdBy;?>" />
						<input type="hidden" name="createdById" id="createdById" value="<?php echo $createdById;?>" />
						<input type="hidden" id="h_ticketId" name="h_ticketId" value="<?php echo $ticket_details->id;?>" />
						<input type="hidden" id="h_ticketUniqueId" name="h_ticketUniqueId" value="<?php echo $ticket_details->unique_ticket_id;?>" />
						<input type="hidden" name="ticketSecBaseUrl" id="ticketSecBaseUrl" value="<?php echo $ticketSecBaseUrl;?>" />
						<div id="resTicket"></div>
						<div class="form-fields">
							<label class="form-label">Reply *</label>
							<textarea id="conMsgContent" name="conMsgContent"></textarea>			
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary" id="conversationBtn" style="padding:5px 30px;">Submit Now!</button>	
						</div>
					</form>
				</div>
			</div>  
		</div>
	</div>
</div>
</div>
</div>

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