<section class="content">
	<div class="box">
<style>
.pull-right{ float:right;}
.moreDetails h4{ font-size:16px;}
</style>
		<div class="box-header with-border">
			<script type="text/javascript">
				function update_ticket_status(id,unique_ticket_id){
					var update_status_chk = $('#h_ticket_status_'+id).val();
					if(update_status_chk==0){ var update_status = 1;}else{var update_status = 0;}
					 $.ajax({url: "<?php echo base_url().$this->config->item('admin_directory_name');?>/tickets/update_status?id="+id+"&ticket_status="+update_status+"&unique_ticket_id="+unique_ticket_id+"&deptFname=<?php echo $department_details->first_name;?>&deptEmail=<?php echo $department_details->email;?>", 
						beforeSend: function(){ 
							$('#spinner_ticket_status_'+id).html('<i class="fa fa-spinner fa-spin"></i>');
						},
						success: function(result){
							$('#h_ticket_status_'+id).val(update_status);
							if(update_status==0){
								$('.reply_class_inner').show();
							}else{
								$('.reply_class_inner').hide();
								$('#manFls').hide();
							}
							$('#spinner_ticket_status_'+id).html(result);
						}
					});
				}
			</script>
			<h3 class="box-title"><label style="margin-right:20px;">Ticket ID - <?php echo $ticket_details->unique_ticket_id;?></label>			
				<?php if(isset($ticket_details->ticket_status) && $ticket_details->ticket_status==0){?>
				<div id="manFls" style="display:inline-block;">
				<input <?php if(isset($ticket_details->ticket_status) && $ticket_details->ticket_status==1){?> checked="checked" <?php } ?> id="toggle-event-ticket_status<?php echo $ticket_details->id;?>" onchange="return update_ticket_status('<?php echo $ticket_details->id;?>','<?php echo $ticket_details->unique_ticket_id;?>');" data-toggle="toggle" data-size="mini" data-onstyle="danger" data-offstyle="success" data-on="Closed" data-off="Open" type="checkbox">
				<input type="hidden" name="h_ticket_status_<?php echo $ticket_details->id;?>" value="<?php echo $ticket_details->ticket_status;?>" id="h_ticket_status_<?php echo $ticket_details->id;?>" />
				<span id="spinner_ticket_status_<?php echo $ticket_details->id;?>"></span>	</div><?php } ?>		
			</h3>
			<div class="moreDetails">	
				<h4>University : <?php echo $university_details->university_name;?></h4>
				<h4>Department : <?php echo $department_details->department_name;?></h4>	
				<h4>Type of Support: <?php echo $this->config->item('support_types_array_config')[$ticket_details->type_of_support]['name'];?></h4>
				<h4>Message To: <?php echo $this->config->item('support_roles_array_config')[$ticket_details->send_message_to]['name'];?></h4> 
			</div>
		</div>
		<div class="box-body">
			  <?php foreach($ticket_conversations_data as $conv){?>
			  	<div class="col-md-12">
				  <blockquote <?php if($conv->msg_by==1){?>class="pull-right"<?php } ?>>
					<?php echo $conv->problem_msg;?> 
					<label><small><?php echo date('D, d M Y, h:i A',$conv->msg_time);?> &nbsp; <i>(<?php if($conv->msg_by==0){
					echo $department_details->first_name.' '.$department_details->last_name;
					 }else{echo 'Admin';}?>)</i></small></label>
				  </blockquote>
				 </div> 
			  <?php } ?>
 		</div>
 		<div class="box-footer">
			<form id="frm" method="post" class="reply_class_inner" action="" enctype="multipart/form-data" style="display:<?php if(isset($ticket_details->ticket_status) && $ticket_details->ticket_status==0){echo 'block';}else{echo 'none';}?>;">
				<div class="form-group">
					<label>Subject *</label>
					<select class="form-control required" id="problem_subject" name="problem_subject">
						<option value="">Select...</option>
						<option value="Regarding AMEE technical support case">Regarding AMEE technical support case</option>
						<option value="AMEE support complete">AMEE support complete</option>
						<option value="A message from AMEE tech support">A message from AMEE tech support</option>
						<option value="An AMEE support ticket has been opened">An AMEE support ticket has been opened</option>
					</select>
				</div> 
				<div class="form-group">
					<label>Reply *</label>
					<textarea class="form-control" id="editor" name="problem_message"></textarea>
					<input type="hidden" id="h_unique_ticket_id" name="h_unique_ticket_id" value="<?php echo $ticket_details->unique_ticket_id;?>" />
					<input type="hidden" id="h_conversation_cnt" name="h_conversation_cnt" value="<?php echo $ticket_details->conversation_cnt;?>" />
					<input type="hidden" id="h_sent_to_email" name="h_sent_to_email" value="<?php echo $department_details->first_name;?>" />
					<input type="hidden" id="h_sent_to_name" name="h_sent_to_name" value="<?php echo $department_details->email;?>" />
				</div>
				<div class="form-group"><button class="btn btn-primary" type="submit">Submit Now!</button></div>
			</form>
		</div>
 	</div>
</section>  