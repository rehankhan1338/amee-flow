
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				
				<form id="editfrm" method="post" action="spotlight/update_entry" enctype="multipart/form-data">

					<input type="hidden" id="spotlightId" name="spotlightId" value="<?php echo $submission_details->spotlightId;?>"/>
					<input type="hidden" id="h_ajax_base_url" name="h_ajax_base_url" value="<?php echo base_url().$this->config->item('admin_directory_name');?>" />
					<div class="box-header">
						<div class="col-md-12">		
							<h3>Submitted By &mdash; <?php 
							echo $submission_details->firstName.' '.$submission_details->lastName; 
							if(isset($submission_details->createdTime) && $submission_details->createdTime!='' && $submission_details->createdTime>0){
								echo ' on '.date('m/d/Y, h:i A',$submission_details->createdTime);
							}
							?></h3>
							<div class="">
								<?php echo $submission_details->spotlightContent;?>
							</div>
						</div>
					</div>
					<div class="box-body">										
						<div class="col-md-12">	
							<div id="result_display"></div>				        
					        <div class="form-group">
								<label class="control-label">Updated Spotlight Content Display on Web *</label>
								<textarea id="editor" name="updatedSpotlightContent"><?php echo $submission_details->updatedSpotlightContent;?></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Display on Web *</label>
								<select class="form-control required" id="displayWebSts" name="displayWebSts" style="width:30%;"> 
									<option value="">Select...</option>
									<option value="0" <?php  if($submission_details->displayWebSts==0){?> selected="selected"<?php } ?>>Yes</option>
									<option value="1" <?php  if($submission_details->displayWebSts==1){?> selected="selected"<?php } ?>>No</option>
								</select>
							 </div>
                            <div class="form-group">
								<label class="control-label">Status *</label>
								<select class="form-control required" id="isStatus" name="isStatus" style="width:30%;"> 
									<option value="">Select...</option>
									<option value="0" <?php  if($submission_details->isStatus==0){?> selected="selected"<?php } ?>>Accept</option>
									<option value="1" <?php  if($submission_details->isStatus==1){?> selected="selected"<?php } ?>>Reject</option>
								</select>
							 </div>
							 <div class="form-group" >
								<label for="logo" class="control-label">Photo</label>
								<br />
								<?php if(isset($submission_details->profilePic) && $submission_details->profilePic!=''){?>
									<div class="col-md-2" style="padding:0;">
										<img id="blah" src="<?php echo base_url().'assets/upload/photo/'.$submission_details->profilePic;?>" class="img-responsive" alt="" />
									</div>
								<?php	
								}else{
									echo 'Photo is not present of User, please tell them to user to add the photo.';
								}
								?>
								<div class="input-group" style="display:none;">
									<input type="file" class="<?php //if(isset($submission_details->photo) && $submission_details->photo!=''){}else{echo 'required';}?>" id="photoImg" name="photoImg" onchange="readURL(this);" />
								</div>
							</div>
							 
						</div>
					</div>
					<div class="box-footer">
						<button type="submit" class="btn btn-primary" style="padding:5px 30px;" id="editbtn" name="submit">Update</button>
					</div>
				</form>
			
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
$(document).ready(function(){
	$('#editfrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error').addClass('has-success');
			element.remove();
		},
		submitHandler: function(form){
			var ajax_base_url = $('#h_ajax_base_url').val();
			var form = $('#editfrm');
			var url = ajax_base_url+form.attr('action');
			var formData = new FormData($('#editfrm').get(0));
			formData.append('photoImg', $('#photoImg')[0].files[0]);
			for(var instanceName in CKEDITOR.instances){
				CKEDITOR.instances[instanceName].updateElement();
			}
			$.ajax({
				type: "POST",
				url: url,
				enctype: 'multipart/form-data',
				data: formData,
				processData: false,
				contentType: false,
				beforeSend: function(){
					$('#editbtn').prop("disabled", true);
					$('#editbtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					if(result=='success'){
						window.location=ajax_base_url+'spotlight/submissions';
					}else{
						$('#result_display').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						$('#editbtn').prop("disabled", false);
						$('#editbtn').html('Update');
					}
				},
				error: function(xhr, status, error_desc){
					$('#result_display').html('<div class="alert alert-danger">'+error_desc+'</div>');
					$('#editbtn').prop("disabled", false);
					$('#editbtn').html('Update');
				}
			});		
			return false;
		}
	});
});
</script>
