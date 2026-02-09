<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php if(!empty($title)){echo $title; }else{echo '';}?></title>
<link href="<?php echo base_url(); ?>assets/frontend/images/favicon.png" rel="shortcut icon">
<link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/style.default.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/backend/css/font-awesome.min.css" type="text/css" />
<script src="<?php echo base_url();?>assets/frontend/js/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/frontend/js/jquery-migrate-3.0.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/frontend/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/frontend/js/jquery.validate.min.js" type="text/javascript"></script> 
<style>.loginbox .error {color: #fffccc;font-size: 13px;font-weight: 600;letter-spacing: 0.2px;margin-bottom: 15px;}</style>
</head>
<body class="loginpage">
	<div class="loginbox">
    	<div class="loginboxinner">        	
            <div class="logo">
            	<h1><span>AMEE.</span><?php echo $page_title;?></h1>
                <p><?php echo $this->config->item('project_name_page_first').' '.$this->config->item('project_name_page_second'); ?></p>
            </div>
  			<?php if(isset($success_msg) && $success_msg!=''){?>
				<div class="alert alert-success"><?php echo $success_msg; ?></div>
			<?php }?>
 			<?php if(isset($error_msg) && $error_msg!=''){?>
				<div class="nousername">
					<div class="loginmsg"><?php echo $error_msg; ?></div>
	            </div>
			<?php }?> 
            <div class="nousername" style="display:none;font-weight: 600;"><div class="loginmsg"></div></div>
            <form class="login_form" method="post" id="recover_pass_frm" action="">
                <div class="password">
                	<div class="passwordinner">
                    	<input type="password" name="new_password" id="new_password" placeholder="New Password" class="required" />
                    </div>
                </div>                
                <div class="password">
                	<div class="passwordinner">
                    	<input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" class="required" />
                    </div>
                </div>                
                <button type="submit" id="submit_btn" style="margin-bottom:10px;">Set Password</button>            
                <div class="row">        
					<div class="col-md-12">
						<a href="<?php echo base_url();?>" style="color: #f9f9f9;font-size:14px; font-style:italic;">Signin</a>
					</div>
                </div>            
            </form>            
        </div><!--loginboxinner-->
    </div><!--loginbox-->
<script>
$(document).ready(function(){
	$('#recover_pass_frm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error').addClass('has-success');
			element.remove();
		},
		errorElement: 'div',
		errorClass: 'error',
		errorPlacement: function (error, element) {
			error.insertAfter(element.parent().parent());
		},
		rules: {
			new_password: {
				required: true,
				pwcheck: true,
				minlength: 8	
			},	
			confirm_password: {
				equalTo: "#new_password",
			}	
		},
		messages: {
			new_password: {
				required: "Password required",
				pwcheck: "Password must contain at least one uppercase (A-Z) and one lowercase (a-z) and one (0-9) and one special character and at least eight characters.",
				minlength: "Password must contain at least eight characters."
			}
		}
	});
	$.validator.addMethod("pwcheck", function(value) {
	   return /^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8,}$/.test(value);
	});
});
</script>
</body>
</html>