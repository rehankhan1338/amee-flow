<form id="loginFrm" method="POST" action="<?php echo $frmAction;?>">
	<input type="hidden" id="h_base_url" name="h_base_url" value="<?php echo base_url();?>" />
	<?php if($accTypeSts==1){?>
		<input type="hidden" id="unishortName" name="unishortName" value="<?php echo $uniDetails['shortName'];?>" />
	<?php } ?>
	<?php $cookie_prefix = $this->config->item('cookie_prefix'); ?>		
	<div class="form-group has-feedback">
		<input type="text" name="username" class="form-control" autocomplete="off" placeholder="<?php if($accTypeSts==1){echo 'Email ID / Login ID';}else{echo 'Username';}?>" value="<?php 
			if($accTypeSts==1){
				if(isset($_COOKIE[$cookie_prefix.'system_admin_username_cookie']) && $_COOKIE[$cookie_prefix.'system_admin_username_cookie']!=''){ 
					echo $_COOKIE[$cookie_prefix.'system_admin_username_cookie']; 
				}
			}else{
				if(isset($_COOKIE[$cookie_prefix.'admin_username_cookie']) && $_COOKIE[$cookie_prefix.'admin_username_cookie']!=''){ 
					echo $_COOKIE[$cookie_prefix.'admin_username_cookie']; 
				} 
			}			
		?>">
		<span class="glyphicon glyphicon-user form-control-feedback"></span>
	</div>	
	<div class="form-group has-feedback">
		<input type="password" name="password" class="form-control" autocomplete="off" placeholder="Password" value="<?php 
		if($accTypeSts==1){
			if(isset($_COOKIE[$cookie_prefix.'system_admin_password_cookie']) && $_COOKIE[$cookie_prefix.'system_admin_password_cookie']!=''){ 
				echo $_COOKIE[$cookie_prefix.'system_admin_password_cookie']; 
			}
		}else{
			if(isset($_COOKIE[$cookie_prefix.'admin_password_cookie']) && $_COOKIE[$cookie_prefix.'admin_password_cookie']!=''){ 
				echo $_COOKIE[$cookie_prefix.'admin_password_cookie']; 
			}
		}
		?>">
		<span class="glyphicon glyphicon-lock form-control-feedback"></span>
	</div>	
	<div class="row">
		<div class="col-xs-12">
			<button type="submit" class="btn btn-primary btn-block btn-flat" id="loginBtn" name="submit_login"> <?php echo $btnText;?></button>
		</div>
	</div>	
	<div class="row" style="margin-top:5px;">
		<div class="col-md-5">
			<div class="checkbox icheck">
				<label><input type="checkbox" name="remember_me" <?php if((isset($_COOKIE[$cookie_prefix.'system_admin_username_cookie']) && $_COOKIE[$cookie_prefix.'system_admin_username_cookie']!='' && $accTypeSts==1) || (isset($_COOKIE[$cookie_prefix.'admin_username_cookie']) && $_COOKIE[$cookie_prefix.'admin_username_cookie']!='' && $accTypeSts==0)){?> checked="checked" <?php } ?>> Remember Me</label>
			</div>
		</div>
		<?php if($accTypeSts==1){?>
		<div class="col-md-7" style="margin-top:10px;">		  
			<a style="font-style: italic; font-weight: 600; float:right;" href="<?php //echo base_url().$this->config->item('admin_directory_name');?>/forgot_password"> Forgot Password</a>
		</div>
		<?php } ?>
	</div>	
</form>
<script type="text/javascript">
$(document).ready(function(){
	$('#loginFrm').validate({
		ignore: [], 
		submitHandler: function(form){
			var site_base_url = $('#h_base_url').val();
			var form = $('#loginFrm');
			var url = form.attr('action');
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					$('#loginBtn').prop("disabled", true);
					$('#loginBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
						window.location=result_arr[1];
					}else{
						$("html, body").animate({ scrollTop: 0 }, "slow");
						$('#login_err_msg').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						$('#loginBtn').html('<?php echo $btnText;?>');
						$('#loginBtn').prop("disabled", false);
					}
				},
				error: function(xhr, status, error_desc){				
					$("html, body").animate({ scrollTop: 0 }, "slow");
					$('#login_err_msg').html('<div class="alert alert-danger">'+error_desc+'</div>');
					$('#loginBtn').html('<?php echo $btnText;?>');
					$('#loginBtn').prop("disabled", false);
				}
			});		
			return false;
		}
	});
});
</script>