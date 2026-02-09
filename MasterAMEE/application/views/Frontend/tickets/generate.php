<div id="resMsg"></div>
<form class="" method="post" id="ticketFrm" action="tickets/generate_ticket">
<input type="hidden" id="h_base_url" name="h_base_url" value="<?php echo base_url();?>" />
  	<div class="col-md-12">
		<div class="form-group">
			<label for="fs_title">Type of Support *</label>
			<?php $support_types=$this->config->item('support_types_array_config');?>
			<select name="type_of_support" class="form-control required" id="type_of_support" style="width:30%;">
				<option value="">-- select --</option>
				<?php foreach($support_types as $key => $value){ if($value['status']==0){?>
				<option value="<?php echo $key;?>"><?php echo $value['name'];?></option>
				<?php } }?>
			</select>
		</div>
		<div class="form-group">
			<label>Message *</label>
			<textarea name="fs_message" id="editor"></textarea>
		</div>
		<div class="form-group">
			<label for="fs_send_message_to">Send Message to *</label>	
			<?php $support_roles=$this->config->item('support_roles_array_config');?>	
			<select name="fs_send_message_to" class="form-control required" id="fs_send_message_to" style="width:30%;">
				<option value="">-- select --</option>
				<?php foreach($support_roles as $key => $value){ if($value['status']==0){?>
				<option value="<?php echo $key;?>"><?php echo $value['name'];?></option>
				<?php } }?>
			</select>
		</div>
	</div>
	<div class="clearfix"></div>	 	 			
	<div class="col-md-12">
		<div class="clearfix"></div>
		<button type="submit" class="btn btn-primary" id="saveBtn">Submit Now!</button>	
	</div>
	<div class="clearfix"></div>	
</form>
<script>
jQuery(function () {
	jQuery('#ticketFrm').validate({
		ignore: [], 
		highlight: function(element) {
			jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error').addClass('has-success');
			element.remove();
		},
		submitHandler: function(form){
			var site_base_url = jQuery('#h_base_url').val();
			var form = jQuery('#ticketFrm');
			var url = site_base_url+form.attr('action');
			for (instance in CKEDITOR.instances) {
				CKEDITOR.instances[instance].updateElement();
			}
			jQuery.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					jQuery('#saveBtn').prop("disabled", true);
					jQuery('#saveBtn').html('Submitting <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					var resultArr = result.split('||');
					if(resultArr[0]=='success'){
						window.location=site_base_url+'tickets';
					}else{						
						jQuery('#resMsg').html('<div class="alert alert-danger">'+resultArr[1]+'</div>');
						jQuery("html, body").animate({ scrollTop: 0 }, "slow");
						jQuery('#saveBtn').html('Submit Now!');
						jQuery('#saveBtn').prop("disabled", false);
					}				
				},
				error: function(xhr, status, error_desc){				
					jQuery("html, body").animate({ scrollTop: 0 }, "slow");
					jQuery('#resMsg').html('<div class="alert alert-danger">'+error_desc+'</div>');
					jQuery('#saveBtn').html('Submit Now!');
					jQuery('#saveBtn').prop("disabled", false);
				}
			});		
			return false;
		}
	});
});
</script>