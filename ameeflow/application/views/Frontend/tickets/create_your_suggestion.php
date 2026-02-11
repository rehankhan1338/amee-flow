<div class="home_wrapper">
	<div class="container">       
        <div class="row">
			<div class="title"><i style="font-size:40px; color:<?php echo $session_details->dashBGColor;?>;" class="far fa-envelope"></i><br>
			<?php if(isset($page_title) && $page_title!=''){ echo $page_title;}?></div>		
		</div>
 		<div class="row ticket_page">
			<div id="resMsg"></div>
			<form id="sendSuggestionFrm" method="post" action="tickets/sendSuggestion">
				<input type="hidden" id="hBaseUrl" name="hBaseUrl" value="<?php echo base_url();?>" />
				<input type="hidden" id="hAjaxUrl" name="hAjaxUrl" value="<?php echo $this->config->item('ajax_base_url');?>" />
				<input type="hidden" id="hRegId" name="hRegId" value="<?php echo $session_details->registration_id;?>" />
				<div class="col-md-12">
					
					<div class="form-group">
						<label class="controlLbl">Please enter your suggestion below.</label>
						<textarea name="givenSuggestion" class="form-control required" maxlength="500" rows="5" id="givenSuggestion"></textarea>
						<label id="given_suggestion_count_desc" style="margin-top:5px; font-size:18px;"></label>
					</div>
					
					<div class="form-group">
						<label class="controlLbl">Overall, how satisfied  or dissatisfied are you with the website?</label>
						<?php $suggestion_box_satisfied_options=$this->config->item('suggestion_box_satisfied_options_array_config');?>
						<select name="satisfiedOption" class="form-control required" id="satisfiedOption" style="width:20%;">
							<option value="">Select...</option>
							<?php foreach($suggestion_box_satisfied_options as $key => $value){ if($value['status']==0){?>
							<option value="<?php echo $key;?>"><?php echo $value['name'];?></option>
							<?php } }?>
						</select>
					</div>
					
					<div class="form-group">
						<label class="controlLbl">Would you like to be contacted about your suggestion? &mdash;</label>
						<label style="margin-left:10px; margin-top:5px; font-size:16px;"><input type="radio" class="required" id="contactMeSts" name="contactMeSts" value="1" />&nbsp; Yes</label>
						<label style="margin-left:10px;margin-top:5px; font-size:16px;"><input type="radio" class="required" id="contactMeSts" name="contactMeSts" value="2" />&nbsp; No</label>
					</div>
					
				</div>
				<div class="clearfix"></div>	 	 			
				<div class="col-md-12">
					<div class="clearfix"></div>
					<button type="submit" class="btn btn-primary" id="submitBtn" style="padding:8px 50px;">Send Now!</button>	
				</div>
				<div class="clearfix"></div>	
			</form>
		</div>
	</div>
</div>

<script>
jQuery(function () {
	var max_desc = parseInt($("#givenSuggestion").attr("maxlength"));
	$("#givenSuggestion").keyup(function(e){
		$("#given_suggestion_count_desc").text("Characters left: " + (max_desc - $(this).val().length));
	});
	jQuery('#sendSuggestionFrm').validate({
		ignore: [], 
		highlight: function(element) {
			jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var site_base_url = jQuery('#hBaseUrl').val();
			var ajaxUrl = jQuery('#hAjaxUrl').val();
			var form = jQuery('#sendSuggestionFrm');
			var url = ajaxUrl+form.attr('action');
			jQuery.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					jQuery("#submitBtn").attr("disabled",true);
					jQuery('#submitBtn').html('Sending <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					if(result=='success'){
						$('#resMsg').html('<div class="alert alert-success sMsg"><strong>Thank You!</strong> Your suggestion has been sent successfully!</div>');
						$("html, body").animate({ scrollTop: 0 }, "slow");
						jQuery('#submitBtn').html('Send Now!');
						$('#sendSuggestionFrm').hide();
						$('#sendSuggestionFrm')[0].reset();						
					}else{						
						jQuery('#resMsg').html('<div class="alert alert-danger">'+result+'</div>');
						jQuery("html, body").animate({ scrollTop: 0 }, "slow");
						jQuery('#submitBtn').html('Send Now!');
						jQuery("#submitBtn").attr("disabled",false);
					}					
				},
				error: function(xhr, status, error_desc){				
					jQuery("html, body").animate({ scrollTop: 0 }, "slow");
					jQuery('#resMsg').html('<div class="alert alert-danger">'+error_desc+'</div>');
					jQuery('#submitBtn').html('Send Now!');
					jQuery("#submitBtn").attr("disabled",false);
				}
			});		
			return false;
		}
	});
});
</script>