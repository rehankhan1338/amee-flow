<style>
.alert-success{ margin:-20px 0 30px;}
.ticket_chat h4{ font-size:20px;}
.ticket_chat .lbl{ font-size:16px; margin-top:6px;display:block;}
.ticket_chat .com_box {display: inline-block;float: right;margin-top:-20px;width: 100px;}
.ticket_chat .chat_box {font-size: 16px; margin-top: 20px;margin-bottom: 10px;}
.ticket_chat .chat_box .user_comment {border: 1px solid #eee;border-radius: 0 20px 0 20px;padding: 10px 20px;box-shadow: 0 1px 8px #ddd;background-color: #fff;text-align: right;
line-height:25px;}
.ticket_chat .chat_box .admin_comment {border-radius: 20px 20px 0 20px;padding: 10px 20px;box-shadow: 0 1px 8px #ddd;background-color:rgba(3, 63, 123, 0.1);text-align: left;
line-height:25px;}
.chat_box p {margin:5px 0;}
small{ font-size:90% !important; color:#000 !important; font-style:italic;}
.ticket_chat .com_box .btn{padding:5px 10px;}
</style>

<div class="survey_heading" style="text-align: left;margin-top: -20px; margin-bottom:5px;;">
	<h3 style="font-weight:600;">Tickets</h3>
	<div class="btn_div" style="float:right;">
		<a class="btn btn-default" href="<?php echo base_url();?>tickets"> <i class="fa fa-long-arrow-left"></i> Back to Listing</a>
 	</div>
</div>

<div class="col-md-12"> 
<div class="ticket_chat">
	<h4>Ticket ID - <?php echo $ticket_details->unique_ticket_id;?> </h4>
	<div class="com_box" style="display:none;">
		<input <?php if(isset($ticket_details->ticket_status) && $ticket_details->ticket_status==1){?> checked="checked" <?php } ?> id="toggle-event-ticket_status<?php echo $ticket_details->id;?>" onchange="return update_ticket_status('<?php echo $ticket_details->id;?>');" data-toggle="toggle" data-width="80" data-height="28" data-onstyle="danger" data-offstyle="success" data-on="Closed" data-off="Open" type="checkbox">
		<input type="hidden" name="h_ticket_status_<?php echo $ticket_details->id;?>" value="<?php echo $ticket_details->ticket_status;?>" id="h_ticket_status_<?php echo $ticket_details->id;?>" />
		<span id="spinner_ticket_status_<?php echo $ticket_details->id;?>"></span>
	</div>
	<label class="lbl"><i>Date : <?php echo date('d M Y, h:i A',$ticket_details->generated_time);?></i></label>
	<label class="lbl"><i>Type of Support : <?php echo $this->config->item('support_types_array_config')[$ticket_details->type_of_support]['name'];?></i></label>
	
	<?php foreach($ticket_conversations_data as $conv){?>
		<div class="chat_box">
		<div class="<?php if($conv->msg_by==0){echo 'user_comment'; }else{echo 'admin_comment';} ?>">
			<p><?php echo $conv->problem_msg;?></p>
			<label class="lbl"><?php echo date('d M Y, h:i A',$conv->msg_time);?></label> 
			<small>&nbsp;(<?php if($conv->msg_by==0){
				echo $dept_session_details->first_name.' '.$dept_session_details->last_name;
				 }else{echo 'Admin';}?>)</small>
		</div>
		</div>
	<?php } ?>
</div>
<div class="">
	<hr class="hr" />
	<form id="frm" method="post" class="reply_class_inner mt10" action="" enctype="multipart/form-data" style="display:<?php if(isset($ticket_details->ticket_status) && $ticket_details->ticket_status==0){echo 'block';}else{echo 'none';}?>;"> 
		<input type="hidden" id="h_conversation_cnt" name="h_conversation_cnt" value="<?php echo $ticket_details->conversation_cnt;?>" />
		<input type="hidden" id="h_unique_ticket_id" name="h_unique_ticket_id" value="<?php echo $ticket_details->unique_ticket_id;?>" />
		<input type="hidden" id="h_send_message_to" name="h_send_message_to" value="<?php echo $ticket_details->send_message_to;?>" />
		<input type="hidden" id="h_type_of_support" name="h_type_of_support" value="<?php echo $ticket_details->type_of_support;?>" />
		<div class="form-group">
			<label>Reply *</label>
			<textarea id="editor" name="problem_message"></textarea>			
		</div>
		<div class="form-group"><button class="btn btn-primary" type="submit">Submit Now!</button></div>
	</form>
</div>
</div>  
<div class="clearfix"></div>

<script type="text/javascript">
function update_ticket_status(id){
	var update_status_chk = $('#h_ticket_status_'+id).val();
	if(update_status_chk==0){ var update_status = 1;}else{var update_status = 0;}
	 $.ajax({url: "<?php echo base_url();?>tickets/update_status?id="+id+"&ticket_status="+update_status, 
		beforeSend: function(){ 
			$('#spinner_ticket_status_'+id).html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(result){
			$('#h_ticket_status_'+id).val(update_status);
			if(update_status==0){$('.reply_class_inner').show();}else{$('.reply_class_inner').hide();}
			$('#spinner_ticket_status_'+id).html(result);
		}
	});
}
</script>   