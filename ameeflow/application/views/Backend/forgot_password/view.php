<form role="form" id="frm" method="POST" action="">

	<p class="login-box-msg" style="font-size:16px; padding:0; margin-bottom:30px; line-height:25px;">Enter the email addresss with which you registered your account below and we will send you recovery link to reset your password.</p>
	
	<div class="form-group has-feedback">
		<input type="text" name="username" class="form-control email required" placeholder="Email" autocomplete="off" />
		<span class="glyphicon glyphicon-email form-control-feedback"></span>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<button type="submit" class="btn btn-primary btn-block btn-flat" name="submit_login">Request Password</button>
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