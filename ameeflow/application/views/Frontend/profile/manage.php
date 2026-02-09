
<section class="content">
	<div class="row">
<?php 
$acLnk = 'signin/updateUserProfile';
if($sessionDetailsArr['addedBy']==0){
	
	$name = $sessionDetailsArr['userName'];
	$email = $sessionDetailsArr['userEmail'];
}else{
	$name = $sessionDetailsArr['auName'];
	$email = $sessionDetailsArr['auEmailId'];
}
?>

		<div class="col-md-12">
			<div class="box">
				<div class="box-header no-border">
					<h3 class="box-title">University: &nbsp;<?php if(isset($sessionDetailsArr['universityName']) && $sessionDetailsArr['universityName']!=''){echo $sessionDetailsArr['universityName'];} ?></h3>
				</div>
				<form id="manageFrm" class="form-horizontal" method="post" action="<?php echo $acLnk;?>" enctype="multipart/form-data">

					<input type="hidden" id="userId" name="userId" value="<?php if(isset($sessionDetailsArr['userId']) && $sessionDetailsArr['userId']!=''){echo $sessionDetailsArr['userId'];}else{echo '0';}?>"/>
					<input type="hidden" id="addedBy" name="addedBy" value="<?php if(isset($sessionDetailsArr['addedBy']) && $sessionDetailsArr['addedBy']!=''){echo $sessionDetailsArr['addedBy'];}else{echo '0';}?>"/>
					<input type="hidden" id="userAccessId" name="userAccessId" value="<?php if(isset($sessionDetailsArr['userAccessId']) && $sessionDetailsArr['userAccessId']!=''){echo $sessionDetailsArr['userAccessId'];}else{echo '0';}?>"/>
					<input type="hidden" id="universityId" name="universityId" value="<?php if(isset($sessionDetailsArr['universityId']) && $sessionDetailsArr['universityId']!=''){echo $sessionDetailsArr['universityId'];}else{echo '0';}?>"/>
					<input type="hidden" id="h_ajax_base_url" name="h_ajax_base_url" value="<?php echo base_url();?>" />

					<div class="box-body row">
						<div id="result_display" style="margin: -15px 20px 25px 20px"></div>
						<div class="col-md-11">
							
							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="userName"> Full Name *</label>
								<div class="col-sm-7">
									<input type="text" class="form-control required" id="userName" name="userName" placeholder="" value="<?php if(isset($name) && $name!=''){echo $name;} ?>" autocomplete="off" />
								</div>
							</div>

							<?php if($sessionDetailsArr['addedBy']==0){?>
							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="unitName"> Unit Name *</label>
								<div class="col-sm-7">
									<input type="text" class="form-control required" id="unitName" name="unitName" placeholder="" value="<?php if(isset($sessionDetailsArr['unitName']) && $sessionDetailsArr['unitName']!=''){echo $sessionDetailsArr['unitName'];} ?>" autocomplete="off" />
								</div>
							</div>

							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="unitShortName"> Unit Short Name *</label>
								<div class="col-sm-7">
									<input type="text" class="form-control required" id="unitShortName" name="unitShortName" placeholder="" value="<?php if(isset($sessionDetailsArr['unitShortName']) && $sessionDetailsArr['unitShortName']!=''){echo $sessionDetailsArr['unitShortName'];} ?>" autocomplete="off" />
								</div>
							</div>

							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="overSightName"> Unit Oversight Name *</label>
								<div class="col-sm-7">
									<input type="text" class="form-control required" id="overSightName" name="overSightName" placeholder="" value="<?php if(isset($sessionDetailsArr['overSightName']) && $sessionDetailsArr['overSightName']!=''){echo $sessionDetailsArr['overSightName'];} ?>" autocomplete="off" />
								</div>
							</div>
							<?php } ?>
							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="userEmail"> Email Address *</label>
								<div class="col-sm-7">
									<input type="text" class="form-control required" id="userEmail" name="userEmail" placeholder="" value="<?php if(isset($email) && $email!=''){echo $email;} ?>" autocomplete="off" />
								</div>
							</div>

							<div class="mb-3 row" style="display:<?php if($sessionDetailsArr['lightAccess']==0){echo 'block'; }else{echo 'none';}?>;">
								<label class="col-sm-5 col-form-label " for="userEmail"> Login ID *</label>
								<div class="col-sm-7 pt-2">
									<strong><?php echo $sessionDetailsArr['auLoginId'];?></strong>
								</div>
							</div>

							<div class="mb-3 row" style="display:<?php if($sessionDetailsArr['lightAccess']==0){echo 'block'; }else{echo 'none';}?>;">
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
