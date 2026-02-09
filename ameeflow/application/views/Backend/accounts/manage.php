
<section class="content">
	<div class="row">
<?php
if(isset($accountDetailsArr['universityId']) && $accountDetailsArr['universityId']!=''){
	$universityId = $accountDetailsArr['universityId'];
}else{
	$universityId = 0;
}
?>
		<div class="col-md-12">
			<div class="box">
				<div class="box-header no-border">
					<h3 class="box-title"><?php echo $headTxt;?></h3>
				</div>
				<form id="manageFrm" class="form-horizontal" method="post" action="accounts/manageEntry" enctype="multipart/form-data">

					<input type="hidden" id="universityId" name="universityId" value="<?php echo $universityId;?>"/>
					<input type="hidden" id="h_ajax_base_url" name="h_ajax_base_url" value="<?php echo $this->config->item('ajax_base_url').$this->config->item('admin_directory_name');?>" />

					<div class="box-body row">
					
						<div class="col-md-10<?php //if($universityId==0){echo 'col-md-6';}else{echo 'col-md-10';}?>">
					        
					        <div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="fullName"> University Name *</label>
								<div class="col-sm-6">
									<input type="text" class="form-control required" id="universityName" name="universityName" placeholder="" value="<?php if(isset($accountDetailsArr['universityName']) && $accountDetailsArr['universityName']!=''){echo $accountDetailsArr['universityName'];} ?>" autocomplete="off" />
								</div>
							</div>

							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label" for="shortName"> University ShortName *</label>
								<div class="col-sm-6">
									<input type="text" class="form-control required" id="shortName" name="shortName" placeholder="" value="<?php if(isset($accountDetailsArr['shortName']) && $accountDetailsArr['shortName']!=''){echo $accountDetailsArr['shortName'];} ?>" autocomplete="off" />
								</div>
							</div>

							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="address"> Address *</label>
								<div class="col-sm-6">
									<input type="text" class="form-control required" id="address" name="address" placeholder="" value="<?php if(isset($accountDetailsArr['address']) && $accountDetailsArr['address']!=''){echo $accountDetailsArr['address'];} ?>" autocomplete="off" />
								</div>
							</div>
                           
							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="city"> City *</label>
								<div class="col-sm-6">
									<input type="text" class="form-control required" id="city" name="city" placeholder="" value="<?php if(isset($accountDetailsArr['city']) && $accountDetailsArr['city']!=''){echo $accountDetailsArr['city'];} ?>" autocomplete="off" />
								</div>
							</div>
							
							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="stateId">State *</label>
								<div class="col-sm-6">
									<select class="form-control required" id="stateId" name="stateId">
										<option value="">Select...</option>
										<?php $states_array=$this->config->item('usa_states_array_config');
										foreach($states_array as $key => $value){ if($value['status']==0){?>
										<option value="<?php echo $key;?>"<?php  if(isset($accountDetailsArr['stateId']) && $accountDetailsArr['stateId']==$key){?> selected="selected"<?php } ?>><?php echo $value['name'];//.' &mdash; '.$value['more_details'].'&nbsp;&nbsp;';?></option>
										<?php } }?>
									</select>
								</div>
							</div>

							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="zipCode"> Zip Code *</label>
								<div class="col-sm-6">
									<input type="text" class="form-control required" id="zipCode" name="zipCode" placeholder="" value="<?php if(isset($accountDetailsArr['zipCode']) && $accountDetailsArr['zipCode']!=''){echo $accountDetailsArr['zipCode'];} ?>" autocomplete="off" />
								</div>
							</div>
							<?php if($universityId==0){?>
								<input type="hidden" id="isActive" name="isActive" value="0"/>
							<?php }else{?>
							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label ">Status *</label>
								<div class="col-sm-6">
									<select class="form-control required" id="isActive" name="isActive"> 
										<option value="">Select...</option>
										<option value="0" <?php  if(isset($accountDetailsArr['isActive']) && $accountDetailsArr['isActive']==0){?> selected="selected"<?php } ?>>Active</option>
										<option value="1" <?php  if(isset($accountDetailsArr['isActive']) && $accountDetailsArr['isActive']==1){?> selected="selected"<?php } ?>>Inactive</option>
									</select>
								</div>
							</div>
							<?php } ?>
							 
                            
						</div>

						<?php if($universityId==10220){?>
						<div class="col-md-6">					        

							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="fullName"> Contact Name *</label>
								<div class="col-sm-6">
									<input type="text" class="form-control required" id="fullName" name="fullName" placeholder="" value="<?php if(isset($accountDetailsArr['fullName']) && $accountDetailsArr['fullName']!=''){echo $accountDetailsArr['fullName'];} ?>" autocomplete="off" />
								</div>
							</div>

							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="email"> Email Address *</label>
								<div class="col-sm-6">
									<input type="text" class="form-control required" id="email" name="email" placeholder="" value="<?php if(isset($accountDetailsArr['email']) && $accountDetailsArr['email']!=''){echo $accountDetailsArr['email'];} ?>" autocomplete="off" />
								</div>
							</div>
							
							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="contactNo"> Contact Number *</label>
								<div class="col-sm-6">
									<input type="text" class="form-control required" id="contactNo" name="contactNo" placeholder="" value="<?php if(isset($accountDetailsArr['contactNo']) && $accountDetailsArr['contactNo']!=''){echo $accountDetailsArr['contactNo'];} ?>" autocomplete="off" />
								</div>
							</div>						

						</div>
						<?php } ?>	
					</div>

					<div class="box-footer">
						<button type="submit" class="btn btn-primary" style="padding:5px 30px;" id="managebtn" name="submit"><?php echo $btnTxt;?></button>
					</div>
				</form>
			
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
function removeInvalidChars(input) {
    input.value = input.value.replace(/[^a-zA-Z]/g, ''); // Removes numbers, spaces & special characters
}
$(document).ready(function(){
	$('#manageFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
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
						$('#managebtn').html('<?php echo $btnTxt;?>');
					}
				},
				error: function(xhr, status, error_desc){
					$('#result_display').html('<div class="alert alert-danger">'+error_desc+'</div>');
					$('#managebtn').prop("disabled", false);
					$('#managebtn').html('<?php echo $btnTxt;?>');
				}
			});		
			return false;
		}
	});
});
</script>
