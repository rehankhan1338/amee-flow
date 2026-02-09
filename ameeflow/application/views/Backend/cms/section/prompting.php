<section class="content">
	<div class="row">
		<div class="col-md-12" >
			<form class="" id="cmsFrm" method="post" action="cms/savePromptData">
			
				<input type="hidden" id="baseUrl" name="baseUrl" value="<?php echo base_url().$this->config->item('admin_directory_name');?>" />
				<input type="hidden" id="promptId" name="promptId" value="<?php if(isset($secContent['promptId']) && $secContent['promptId']!=''){echo $secContent['promptId'];}?>" />
				<div class="box no-border">	 
					<div class="box-body row" style="margin-top:10px;">
						
						<div id="resDisplay"></div>
						
						<div class="col-6">							
							<div class="form-group">
								<h5>API Role *</h5>
								<label class="col-form-label">How do you want the AI to assist?<!--System role is assistant that provides concise and accurate answers.--></label>
								<textarea rows="15" class="form-control required" id="msgSystemRole" style="resize:none;" name="msgSystemRole"><?php if(isset($secContent['msgSystemRole']) && $secContent['msgSystemRole']!=''){echo $secContent['msgSystemRole'];}?></textarea>
							</div>						
						</div>
 					 
						<div class="col-6">							
							<div class="form-group">
								<h5>System Prompt *</h5>
								<label class="col-form-label" for="msgUserRole">Create a prompt for each section</label>
								<textarea rows="15" class="form-control required" id="msgUserRole" style="resize:none;" name="msgUserRole"><?php if(isset($secContent['msgUserRole']) && $secContent['msgUserRole']!=''){echo $secContent['msgUserRole'];}?></textarea>
							</div>						
						</div>
					
						<div class="clearfix"></div>
						
						<div class="col-6">								
							<div class="form-group">
								<h5 class="mt-3">Max Token *</h5>
								<label class="col-form-label" for="maxTokenCnt">How many words do you want the AI to generate for user? </label>
								<input type="number" class="form-control required" id="maxTokenCnt" name="maxTokenCnt" value="<?php if(isset($secContent['maxTokenCnt']) && $secContent['maxTokenCnt']!=''){echo $secContent['maxTokenCnt'];}?>" />
							</div>						
						</div>
						
						<div class="clearfix"></div>
						
					</div> 
				
					<div class="box-footer">
						<button class="btn btn-primary" id="submitBtn" type="submit" style="padding:6px 50px;"><?php if(isset($secContent['promptId']) && $secContent['promptId']!=''){echo 'Update';}else{echo 'Submit';}?></button>
					</div>
				</div>
			
			</form>
<script>
$(document).ready(function(){
	$('#cmsFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){			
			var btnText = $('#submitBtn').html();
			var site_base_url = $('#baseUrl').val();
			var form = $('#cmsFrm');
			var url = site_base_url+form.attr('action');
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(), // serializes the form's elements.
				beforeSend: function(){
					$('#submitBtn').prop("disabled", true);
					$('#submitBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||');
					if(result_arr[0]=='success'){
						window.location=result_arr[1];							
					}else{
						$("html, body").animate({ scrollTop: 0 }, "slow");
						$('#resDisplay').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						$('#submitBtn').prop("disabled", false);
						$('#submitBtn').html(btnText);
					}
				},
				error: function(xhr, status, error_desc){				
					$("html, body").animate({ scrollTop: 0 }, "slow");
					$('#resDisplay').html('<div class="alert alert-danger">'+error_desc+'</div>');
					$('#submitBtn').prop("disabled", false);
					$('#submitBtn').html(btnText);
				}
			});			
			return false;
		}
	});
});
</script>
		</div>
	</div>
</section>