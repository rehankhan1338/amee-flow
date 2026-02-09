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
            .captacha_sec { display: table; width: 100%; }
            .captcha_text { letter-spacing: 5px; background-color: #f5f5f5; padding: 0 40px !important; font-size: 20px; height: 35px; line-height: 35px; }
            #enter_captcha_txt { letter-spacing: 2px; }
            .cfl{ float:left;}
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
			
			
			<div class="login-wrapper" >
	<div class="login-content" style="width:100% !important;">

	
		<div class="login-userset">
            <img src="<?php echo base_url(); ?>assets/backend/images/amee-flow-logo-400-n.png" alt="AMEE Flow" class="img-fluid img-responsive" />
 
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
</script> 
		<form action="signin/checkForgotPassword" id="loginFrm" method="post" class="">
			<input type="hidden" name="h_base_url" id="h_base_url" value="<?php echo base_url();?>" />
			<input type="hidden" name="h_ajax_base_url" id="h_ajax_base_url" value="<?php echo $this->config->item('ajax_base_url');?>" />			
			<input type="hidden" id="fpFor" name="fpFor" value="<?php echo $fpFor;?>" />	
			<div class="login-userheading mt-3">
				<h3 style="font-weight:26px;" id="logTitle">Update your password</h3>
				<h4 style="font-size:17px;" class="logSubTitle" id="logSubTitle">Enter your email address and select Send Email.</h4>
			</div>
			<div id="result_display" class="fs16" style="font-size:16px;"></div>
				<?php if(isset($success_msg) && $success_msg!=''){?>
					<div class="alert alert-success"><?php echo $success_msg;?></div>
				<?php } ?>
				<?php if(isset($error_msg) && $error_msg!=''){?>
					<div class="alert alert-danger"><?php echo $error_msg;?></div>
				<?php } ?>
			 
			
			<div id="stepTwo1" >
				<div class="form-login">
					<label>Email ID *</label>
					<div class="form-addons">
						<input type="text" class="form-control cls required" autocomplete="off" value="" id="email" name="email" placeholder="Email" />
					</div>
				</div>
				<div class="form-login mb-3">
                    <label class="mb-2">Enter the text as you see in the image *</label>
                    <div class="captacha_sec">
                        <div class="col-md-6 captcha_text cfl"><?php echo $captcha_text;?></div>
                        <div class="col-md-6 captcha_field cfl fgrp">
                            <input name="capchta_word" id="capchta_word" class="form-control" value="<?php echo $captcha_text;?>" type="hidden">	            	
                            <input name="enter_captcha_txt" id="enter_captcha_txt" class="form-control required" value="" type="text" autocomplete="off" />           	
                        </div>
                    </div>
                </div>
				
			</div>
			<div class="form-login">
				<button type="submit" class="btn btn-login" id="submitBtn">Send Email</button>
			</div>
			
		</form>
			
			
		</div>
	</div>
	 
</div>
<script>
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
                        // window.location=result_arr[1];
                        $("html, body").animate({ scrollTop: 0 }, "slow");							
                        $('#result_display').html('<div class="alert alert-success">'+result_arr[1]+'</div>');						
						$('#loginFrm')[0].reset();
                        $('#submitBtn').prop("disabled", false);
                        $('#submitBtn').html(btnText);
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
			return false;
		}
	});
});
</script>
			
			</div>
        </div>	 
    </body>
</html>