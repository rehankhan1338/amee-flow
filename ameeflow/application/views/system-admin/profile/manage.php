
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header no-border">
					<h3 class="box-title">University: &nbsp;<?php if(isset($sessionDetailsArr['universityName']) && $sessionDetailsArr['universityName']!=''){echo $sessionDetailsArr['universityName'];} ?></h3>
				</div>
				<form id="manageFrm" class="form-horizontal" method="post" action="updateProfile" enctype="multipart/form-data">

					<input type="hidden" id="uniAdminId" name="uniAdminId" value="<?php if(isset($sessionDetailsArr['uniAdminId']) && $sessionDetailsArr['uniAdminId']!=''){echo $sessionDetailsArr['uniAdminId'];}else{echo '0';}?>"/>
					<input type="hidden" id="universityId" name="universityId" value="<?php if(isset($sessionDetailsArr['universityId']) && $sessionDetailsArr['universityId']!=''){echo $sessionDetailsArr['universityId'];}else{echo '0';}?>"/>
					<input type="hidden" id="h_ajax_base_url" name="h_ajax_base_url" value="<?php echo base_url().$this->config->item('system_directory_name');?>" />

					<div class="box-body row">
						<div id="result_display" style="margin: -15px 20px 25px 20px"></div>
						<div class="col-md-11">
							
							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="fullName"> Full Name *</label>
								<div class="col-sm-7">
									<input type="text" class="form-control required" id="fullName" name="fullName" placeholder="" value="<?php if(isset($sessionDetailsArr['fullName']) && $sessionDetailsArr['fullName']!=''){echo $sessionDetailsArr['fullName'];} ?>" autocomplete="off" />
								</div>
							</div>

							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="unitName"> Unit/Department *</label>
								<div class="col-sm-7">
									<input type="text" class="form-control required" id="unitName" name="unitName" placeholder="" value="<?php if(isset($sessionDetailsArr['unitName']) && $sessionDetailsArr['unitName']!=''){echo $sessionDetailsArr['unitName'];} ?>" autocomplete="off" />
								</div>
							</div>

							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="contactNo"> Contact Number *</label>
								<div class="col-sm-7">
									<input type="text" class="form-control required" id="contactNo" name="contactNo" placeholder="" value="<?php if(isset($sessionDetailsArr['contactNo']) && $sessionDetailsArr['contactNo']!=''){echo $sessionDetailsArr['contactNo'];} ?>" autocomplete="off" />
								</div>
							</div>

							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="email"> Email ID / Login ID *</label>
								<div class="col-sm-7">
									<input type="text" class="form-control required" id="email" name="email" placeholder="" value="<?php if(isset($sessionDetailsArr['email']) && $sessionDetailsArr['email']!=''){echo $sessionDetailsArr['email'];} ?>" autocomplete="off" />
								</div>
							</div>

							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="password"> Password <br />(If you don't want to change, please leave blank)</label>
								<div class="col-sm-7">
									<input type="password" class="form-control" id="password" name="password" placeholder="" value="" autocomplete="off" />
								</div>
							</div>

							
							 
                            
						</div>
						 
					</div>

					<div class="box-footer">
						<button type="submit" class="btn btn-primary" style="padding:5px 30px;" id="managebtn" name="submit">Update</button>
					</div>
				</form>
			
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
$(document).ready(function(){
	$('#manageFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.mb-3 row').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.mb-3 row').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var ajax_base_url = $('#h_ajax_base_url').val();
			var form = $('#manageFrm');
			var url = ajax_base_url+form.attr('action');
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(), // serializes the form's elements.
				beforeSend: function(){
					$('#managebtn').prop("disabled", true);
					$('#managebtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
						window.location=result_arr[1];
					}else{
						$('#result_display').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						$('#managebtn').prop("disabled", false);
						$('#managebtn').html('Update');
					}
				},
				error: function(xhr, status, error_desc){
					$('#result_display').html('<div class="alert alert-danger">'+error_desc+'</div>');
					$('#managebtn').prop("disabled", false);
					$('#managebtn').html('Update');
				}
			});		
			return false;
		}
	});
});
</script>
