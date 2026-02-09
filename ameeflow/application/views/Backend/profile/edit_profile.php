<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header no-border">
					<h3 class="box-title">Edit Profile</h3>
				</div>
				<form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="" enctype="multipart/form-data">
					<div class="box-body">
					
						<p id="ret"><?php if(validation_errors() != false) { echo'<div class="alert alert-dismissable alert-danger"><small>'. validation_errors().'</small></div>'; } ?></p>
						<div class="col-md-11">
						
							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="inputEmail3">Name *</label>
								<div class="col-sm-7">
									<input type="text" class="form-control required" id="name" name="name" placeholder="Name" value="<?php echo $session_details->name;?>"  >
								</div>
							</div>
							
							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="inputEmail3">Mobile No. *</label>
								<div class="col-sm-7">
									<input type="text" class="form-control number required" maxlength="10" title="Enter your 10-digit mobile number" id="email" name="email" placeholder="" value="<?php echo $session_details->email;?>"  >
								</div>
							</div>
							
							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="inputEmail3">User Name / Login ID *</label>
								<div class="col-sm-7">
									<input type="text" class="form-control required" id="user_name" name="user_name" placeholder="User Name" value="<?php echo $session_details->username;?>"  >
								</div>
							</div>
							
							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="inputEmail3">Password<br />(If you don't want to change, please leave blank)</label>
								<div class="col-sm-7">
									<input type="password" class="form-control" id="inputEmail3" name="password" placeholder="password">
								</div>
							</div>
							
							
							
							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="inputEmail3">Profile Pic</label>
								<div class="col-sm-7">
									<input type="file" onchange="readURL(this);" name="photo" id="userfile" style="margin-top:5px;" /> 
								</div>
							</div>
							
							<div class="mb-3 row">
								<label class="col-sm-5 col-form-label " for="inputEmail3"> </label>
								<div class="col-sm-7" style="float:left;">
									<img id="blah" src="#" alt="" style=" max-width:100%; float:left; max-height:100%; margin:auto; display:block;" />
								</div>						
							</div>
						</div>
					</div>
				<div class="box-footer">
				<button type="submit" class="btn btn-primary" name="submit_login">Update Now!</button>
				</div>
				</form>
			
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
$(function(){  
	$('#frm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error').addClass('has-success');
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