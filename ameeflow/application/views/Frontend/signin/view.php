<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		<title><?php if(isset($home_title) && $home_title!=''){ echo $home_title;}else if(isset($title) && $title!=''){echo 'AMEE Flow : : '.$title;}else{echo 'iTrain-e';}?></title>
		<?php $version = '1.0.6';?>
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/frontend/images/ico/favicon.png">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/toolkit/css/bootstrap.min.css?v=<?php echo $version;?>">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/toolkit/plugins/fontawesome/css/fontawesome.min.css?v=<?php echo $version;?>">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/toolkit/plugins/fontawesome/css/all.min.css?v=<?php echo $version;?>">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/toolkit/css/style.css?v=<?php echo $version;?>">
		<style>
			.error{color:#FF0000 !important;}
			.alert{ padding:10px; font-weight:600;}
			.login-wrapper .login-content .form-login label{ margin-bottom:3px; font-weight:600;}
			.login-wrapper .login-content .login-userheading{ margin:0;}
			.login-wrapper .login-content .login-userheading h3{ margin:0 0 5px}
			.login-wrapper .login-content .login-userheading h4{ margin-bottom:10px;}			 
			.password-container input[type="password"] {width: 100%;padding-right: 40px;}
			.toggle-password {position: absolute;right: 10px;top: 50%;transform: translateY(-50%);cursor: pointer;}
			::-ms-reveal {display: none;}
		</style>
		<script src="<?php echo base_url(); ?>assets/backend/js/jquery-1.11.3.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/backend/js/jquery-migrate-1.2.1.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/backend/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/backend/js/jquery.validate.min.js" type="text/javascript"></script>
		<script src="https://unpkg.com/feather-icons"></script>
    </head>
    <body class="account-page">
        <div class="main-wrapper">
			<div class="account-content">
			
			
			<div class="login-wrapper">
	<div class="login-content">
	<img src="<?php echo base_url(); ?>assets/backend/images/amee-flow-logo-400-n.png" alt="AMEE Flow" class="img-fluid img-responsive" />
		<div class="login-userset">
<?php $cookie_prefix=$this->config->item('cookie_prefix'); 
$stuTitle = 'User';
$stuSubTitle = 'Please login to your user dashboard.';
$instTitle = 'Project Manager';
$instSubTitle = 'Please login to your project manager dashboard.';
?>
<style>
.log_switch_btns {display: grid;grid-template-columns: 1fr 1fr;margin-bottom: 1rem;background-color: #eee;border-radius: 8px;padding: 0.25rem; gap:0.25rem;}
.log_switch_btns .btn{opacity: 0.7; border-radius:4px; font-weight:600;}
.log_switch_btns .btn.active{opacity: 1; background-color: #40516C;border-color: #40516C; color:white;box-shadow: rgba(81, 81, 81, 0.36) 0px 8px 24px;}
.log_switch_btns .btn:hover{opacity: 0.5; background-color: #40516C;border-color: #40516C; color:white;}
</style>
<div class="log_switch_btns">
	<button type="button" id="logFirstBtn" class="btn active" onclick="return activeSec('1');"><?php echo $stuTitle;?></button>
	<button type="button" id="logSecondBtn" class="btn" onclick="return activeSec('2');"><?php echo $instTitle;?></button>
</div>	  
<script>
function togglePassword() {
    var passField = document.getElementById("password");
    if (passField.type === "password") {
        passField.type = "text";
		$('.toggle-password').html('<i class="icon-sm" data-feather="eye-off"></i>');
    } else {
        passField.type = "password";
		$('.toggle-password').html('<i class="icon-sm" data-feather="eye"></i>');
    }
	feather.replace();
}
function activeSec(val){
	var secSts = parseInt(val);
	$('#loginSection').val(secSts);
	$('#curStep').val('1');
	if(secSts==1){
		$('#logTitle').html('<?php echo $stuTitle.' Login';?>');
		$('#logSecTxt').html('<?php echo $stuTitle;?>');
		$('#logSubTitle').html('<?php echo $stuSubTitle;?>');
		$('#logFirstBtn').addClass('active');
		$('#logSecondBtn').removeClass('active');
		
		$('#stepOne').hide();
		$('#stepTwo').show();
		$('.cls').addClass('required');
		$('#universityId').removeClass('required');
	}else{
		$('#logTitle').html('<?php echo $instTitle.' Login';?>');
		$('#logSecTxt').html('<?php echo $instTitle;?>');
		$('#logSubTitle').html('<?php echo $instSubTitle;?>');
		$('#logSecondBtn').addClass('active');
		$('#logFirstBtn').removeClass('active'); 
		$('#stepOne').show();
		$('#stepTwo').hide();
		$('#universityId').addClass('required');
		$('.cls').removeClass('required');
	}
}			 
</script> 
		<form action="signin/checkLogin" id="loginFrm" method="post" class="">
			<input type="hidden" name="h_base_url" id="h_base_url" value="<?php echo base_url();?>" />
			<input type="hidden" name="h_ajax_base_url" id="h_ajax_base_url" value="<?php echo $this->config->item('ajax_base_url');?>" />
			<input type="hidden" name="h_redirect_url" id="h_redirect_url" value="<?php if(isset($_GET['redirect_url']) && $_GET['redirect_url']!=''){echo $_GET['redirect_url'];}?>" />
			<input type="hidden" id="loginSection" name="loginSection" value="1" />	
			<input type="hidden" id="curStep" name="curStep" value="1" />	
			<div class="login-userheading">
				<h3 style="font-weight:26px;" id="logTitle"><?php echo $stuTitle.' Login';?></h3>
				<h4 style="font-size:17px;" class="logSubTitle" id="logSubTitle"><?php echo $stuSubTitle;?></h4>
			</div>
			<div id="result_display" class="login_err_msg"></div>
				<?php if(isset($success_msg) && $success_msg!=''){?>
					<div class="alert alert-success"><?php echo $success_msg;?></div>
				<?php } ?>
				<?php if(isset($error_msg) && $error_msg!=''){?>
					<div class="alert alert-danger"><?php echo $error_msg;?></div>
				<?php } ?>
			<div class="form-login" id="stepOne" style="display:none;">
				<label>Organization *</label>
				<div class="form-addons">
					<select class="form-control" id="universityId" name="universityId">
						<option value="">Select...</option>
						<?php foreach($activeAccountDataArr as $uni){?>
							<option value="<?php echo $uni['universityId'];?>"><?php echo $uni['universityName'];?></option>
						<?php } ?>
					</select>
				</div>
			</div>	
			
			<div id="stepTwo" >
				<div class="form-login">
					<label>Email ID / Login ID *</label>
					<div class="form-addons">
						<input type="text" class="form-control cls required" autocomplete="off" value="" id="email" name="email" placeholder="Email" />
					</div>
				</div>
				<div class="form-login">
					<label>Password *</label>
					<div class="pass-group password-container">
						<input type="password" class="form-control cls required"  autocomplete="new-password" value="" id="password" name="password" placeholder="Password" />
						<span class="toggle-password" onclick="togglePassword()"> <i class="icon-sm" data-feather="eye"></i> </span>
					</div>
				</div>
				<div class="form-login" id="forgotPassSec">
					<div class="alreadyuser">
						<h4><a onclick="return redirectfpPage();" class="hover-a">Forgot Password?</a></h4>
					</div>
				</div>
			</div>
			<div class="form-login">
				<button type="submit" class="btn btn-login" id="submitBtn">Continue</button>
			</div>
			
		</form>
			
			
		</div>
	</div>
	<div class="login-img">
		<div class="login_text_sec">
			<div>			 
				<h1>Welcome to AMEE Flow!</h1>
				<h5>Your personalized assessment and program review project management platform is just a login away!</h5>
				<ul>
					<li>Access powerful tools to streamline assessment and program review tasks, track progress, and support continuous improvement-all in one intuitive system.</li>
					<li><strong>Don't have an account?</strong> Contact an AMEE Flow administrator for login credentials at <a style="color:#eee;" href="mailto:ameeflow@assessmentmadeeasy.com">ameeflow@assessmentmadeeasy.com</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<script>
function redirectfpPage(){
	var loginSection = parseInt($('#loginSection').val());			
	if(loginSection==2){
		var rp = 'forgot-password/project-manager';
	}else{
		var rp = 'forgot-password/user';
	}
	window.location='<?php echo base_url();?>'+rp;		
}
$(document).ready(function(){
	feather.replace();
	$('#loginFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error').addClass('has-success');
			element.remove();
		},
		submitHandler: function(form){			
			var btnText = $('#submitBtn').html();
			var site_base_url = $('#h_base_url').val();
			var ajax_base_url = $('#h_ajax_base_url').val();
			var curStep = parseInt($('#curStep').val());
			var loginSection = parseInt($('#loginSection').val());
			
			if(loginSection==2 && curStep==1){
				$('#stepTwo').show();
				$('#email').addClass('required');
				$('#password').addClass('required');
				$('#stepOne').hide();
				$('#curStep').val('2');
				$('#submitBtn').html('Log In');
			}else{			
				var form = $('#loginFrm');
				var url = ajax_base_url+form.attr('action');
				$.ajax({
					type: "POST",
					url: url,
					data: form.serialize(), // serializes the form's elements.
					beforeSend: function(){
						$('#submitBtn').prop("disabled", true);
						$('#submitBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
					},
					success: function(result, status, xhr){//alert(result);
						var result_arr = result.split('||');
						if(result_arr[0]=='success'){
							window.location=result_arr[1];							
						}else{
							$("html, body").animate({ scrollTop: 0 }, "slow");
							$('#result_display').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
							$('#submitBtn').prop("disabled", false);
							$('#submitBtn').html(btnText);
						}
					},
					error: function(xhr, status, error_desc){				
						$("html, body").animate({ scrollTop: 0 }, "slow");
						$('#result_display').html('<div class="alert alert-danger">'+error_desc+'</div>');
						$('#submitBtn').prop("disabled", false);
						$('#submitBtn').html(btnText);
					}
				});	
			}		
			return false;
		}
	});
});
</script>
			
			</div>
        </div>	 
    </body>
</html>