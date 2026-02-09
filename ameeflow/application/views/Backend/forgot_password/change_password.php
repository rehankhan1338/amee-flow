<form role="form" id="frm" method="POST" action="">

	<div class="form-group has-feedback">
		<input type="password" name="new_password" id="new_password" class="form-control required" placeholder="New Password">
	</div>
	
	<div class="form-group has-feedback">
		<input type="password" name="confirm_password" id="confirm_password" class="form-control required" placeholder="Confirm Password">
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<button type="submit" class="btn btn-primary btn-block btn-flat" name="submit_login">Set Password</button>
		</div>
	</div>
	
	<div class="row" style="margin-top:5px;">
		<div class="col-md-5">
			<div class="checkbox icheck">&nbsp;</div>
		</div>
		<div class="col-md-7" style="margin-top:10px;">		  
			<a style="font-style: italic; font-weight: 600; float:right;" href="<?php echo base_url().$this->config->item('admin_directory_name');?>"><i class="fa fa-sign-in" aria-hidden="true"></i> Sign-in</a>
		</div>
	</div>
	
</form>