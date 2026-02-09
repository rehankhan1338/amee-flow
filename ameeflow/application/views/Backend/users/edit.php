<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				 
				<form id="editFrm" class="form-horizontal"  method="post" action="users/update" enctype="multipart/form-data">
				
					<input type="hidden" id="organizationId" name="organizationId" value="<?php echo $orgainzation_details->organizationId; ?>" />
                    <input type="hidden" id="h_ajax_base_url" name="h_ajax_base_url" value="<?php echo $this->config->item('ajax_base_url') . $this->config->item('admin_directory_name'); ?>" />

					<div class="box-body">
						<div class="col-md-11">

							<div class="form-group">
								<label class="col-sm-4 control-label" for="organizationName">Origanization Name *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control required" id="organizationName" name="organizationName" placeholder="" value="<?php echo $orgainzation_details->organizationName; ?>">
								</div>
							</div>
							
							<?php if(count($orgainzation_members_data)>0){
							
							 foreach($orgainzation_members_data as $member){?>
							
							<div class="form-group">
								<label class="col-sm-4 control-label" for="inputEmail3"> First Name *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control required" id="firstName" name="firstName" placeholder=" First Name" value="<?php echo $member->firstName; ?>">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-4 control-label" for="inputEmail3"> Last Name *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control required" id="lastName" name="lastName" placeholder="Last Name" value="<?php echo $member->lastName; ?>">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 control-label" for="inputEmail3">Email *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control required" id="email" name="email" placeholder="Email" value="<?php echo $member->email; ?>">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 control-label" for="inputEmail3">Password *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control required" id="password" name="password" placeholder="Password" value="">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 control-label" for="inputEmail3">Contact Number *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control required" id="contactNo" name="contactNo" placeholder="Contact Number" value="<?php echo $member->contactNo; ?>">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 control-label" for="inputEmail3">What is your role? *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control required" id="role" name="role" placeholder="what is your role?" value="<?php echo $member->role; ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" for="inputEmail3">Address *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control required" id="streetAddress" name="streetAddress" placeholder="Address" value="<?php echo $member->streetAddress; ?>">
								</div>
							</div>
							

							<div class="form-group">
								<label class="col-sm-4 control-label">Status *</label>
								<div class="col-sm-8">

									<select class="form-control required" id="is_status" name="is_status">
										<option value="">Select...</option>
										<option value="1" <?php if ($member->isActive == 1) { ?> selected="selected" <?php } ?>>Active</option>
										<option value="0" <?php if ($member->isActive == 0) { ?> selected="selected" <?php } ?>>Inactive</option>
									</select>
								</div>
							</div>

							<?php } } ?>  
							
							 

						</div>

					</div>
			<div class="box-footer">
				<button type="submit" id="editbtn" class="btn btn-primary" name="submit">Add Now!</button>
			</div>
			</form>

		</div>
	</div>
	</div>
</section>
<script type="text/javascript">
	$(document).ready(function() {
		$('#editFrm').validate({
			ignore: [],
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element) {
				element.closest('.form-group').removeClass('has-error').addClass('has-success');
				element.remove();
			},
			submitHandler: function(form) {
				var ajax_base_url = $('#h_ajax_base_url').val();
				var form = $('#editFrm');
				var url = ajax_base_url + form.attr('action');
				$.ajax({
					type: "POST",
					url: url,
					data: form.serialize(), // serializes the form's elements.
					beforeSend: function() {
						$('#editbtn').prop("disabled", true);
						$('#editbtn').html('Please Wait &nbsp;<i class="fas fa-spinner"></i>');
					},
					success: function(result, status, xhr) { //alert(result);
						var result_arr = result.split('||')
						if (result_arr[0] == 'success') {
							window.location = result_arr[1];
						} else {
							$('#result_display').html('<div class="alert alert-danger">' + result_arr[1] + '</div>');
							$('#editbtn').prop("disabled", false);
							$('#editbtn').html('Add Now!');
						}
					},
					error: function(xhr, status, error_desc) {
						$('#result_display').html('<div class="alert alert-danger">' + error_desc + '</div>');
						$('#editbtn').prop("disabled", false);
						$('#editbtn').html('Add Now!');
					}
				});
				return false;
			}
		});
	});
</script>