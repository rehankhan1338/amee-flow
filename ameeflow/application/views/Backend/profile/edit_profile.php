<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box" style="border-radius: 14px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border: 1px solid #eef0f3; overflow: hidden;">
				<div class="box-header no-border" style="background: linear-gradient(135deg, #f8fafc 0%, #eef2f7 100%); padding: 22px 26px 18px; border-bottom: 1px solid #e5e7eb;">
					<h3 class="box-title" style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 10px;">
						<i class="fa fa-user-circle" style="color: #485b79;"></i> Edit Profile
					</h3>
				</div>
				<form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="" enctype="multipart/form-data">
					<div class="box-body" style="padding: 28px 30px 10px;">
					
						<p id="ret"><?php if(validation_errors() != false) { echo'<div class="alert alert-dismissable alert-danger" style="border-radius: 10px;"><small>'. validation_errors().'</small></div>'; } ?></p>
						<div class="col-md-8 col-lg-7">
						
							<div class="mb-4 row">
								<label class="col-sm-4 col-form-label" for="name" style="font-weight: 600; color: #475569; font-size: .9rem;">Name <span style="color: #e74c3c;">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control required" id="name" name="name" placeholder="Enter your full name" value="<?php echo $session_details->name;?>">
								</div>
							</div>
							
							<div class="mb-4 row">
								<label class="col-sm-4 col-form-label" for="email" style="font-weight: 600; color: #475569; font-size: .9rem;">Mobile No. <span style="color: #e74c3c;">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control number required" maxlength="10" title="Enter your 10-digit mobile number" id="email" name="email" placeholder="Enter mobile number" value="<?php echo $session_details->email;?>">
								</div>
							</div>
							
							<div class="mb-4 row">
								<label class="col-sm-4 col-form-label" for="user_name" style="font-weight: 600; color: #475569; font-size: .9rem;">User Name / Login ID <span style="color: #e74c3c;">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control required" id="user_name" name="user_name" placeholder="Enter username" value="<?php echo $session_details->username;?>">
								</div>
							</div>
							
							<div class="mb-4 row">
								<label class="col-sm-4 col-form-label" for="inputEmail3" style="font-weight: 600; color: #475569; font-size: .9rem;">Password</label>
								<div class="col-sm-8">
									<input type="password" class="form-control" id="inputEmail3" name="password" placeholder="Leave blank to keep current password">
									<small style="color: #8b97a8; font-size: .78rem; margin-top: 4px; display: block;">Only fill this if you want to change your password.</small>
								</div>
							</div>
							
							<div class="mb-4 row">
								<label class="col-sm-4 col-form-label" for="userfile" style="font-weight: 600; color: #475569; font-size: .9rem;">Profile Picture</label>
								<div class="col-sm-8">
									<input type="file" onchange="readURL(this);" name="photo" id="userfile" class="form-control" style="padding: 8px 14px !important;" /> 
								</div>
							</div>
							
							<div class="mb-3 row" id="preview_row" style="display: none;">
								<label class="col-sm-4 col-form-label" style="font-weight: 600; color: #475569; font-size: .9rem;">Preview</label>
								<div class="col-sm-8">
									<div style="width: 120px; height: 120px; border-radius: 14px; overflow: hidden; border: 2px solid #eef0f3; background: #f8f9fb;">
										<img id="blah" src="#" alt="" style="max-width: 100%; max-height: 100%; display: block; object-fit: cover; width: 100%; height: 100%;" />
									</div>
								</div>						
							</div>
						</div>
					</div>
					<div class="box-footer" style="padding: 18px 30px; border-top: 1px solid #e5e7eb; background: #f8fafc;">
						<button type="submit" class="btn btn-primary" name="submit_login" style="padding: 10px 36px; border-radius: 38px; font-weight: 600; font-size: .9rem; background: linear-gradient(135deg, #485b79, #3a4d6b); border: none; transition: all .2s ease;">
							<i class="fa fa-check"></i> Update Profile
						</button>
					</div>
				</form>
			
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
$(function(){
	// Show preview container when a file is selected
	$('#userfile').on('change', function(){
		if(this.files && this.files[0]){
			$('#preview_row').show();
		}
	});

	$('#frm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.mb-4').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.mb-4').removeClass('has-error');
			element.remove();
		},rules: {
			new_password: {
				required: true,	
			},	
			confirm_password: {
				equalTo: "#new_password",
			}	
		}
	});  
});
</script>
