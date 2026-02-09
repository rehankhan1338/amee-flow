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
</head>
<body class="loginpage">
	<div class="loginbox">
    	<div class="loginboxinner">        	
            <div class="logo">
            	<h1><span>AMEE.</span> Program / Unit Login <label>3rd Level Access </label></h1>
				
                <p><?php echo $this->config->item('project_name_page_first'); ?></p>
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
            <form class="login_form" method="post" id="login_frm" action="home/check_login">
            	<input type="hidden" name="h_base_url" id="h_base_url" value="<?php echo base_url();?>" />
				<input type="hidden" name="ajax_base_url" id="ajax_base_url" value="<?php echo $this->config->item('ajax_base_url');?>" />
				<input type="hidden" name="h_redirect_url" id="h_redirect_url" value="<?php if(isset($_GET['redirect_url']) && $_GET['redirect_url']!=''){echo $_GET['redirect_url'];}?>" />
                <div class="username">
                	<div class="usernameinner">
                    	<input type="text" name="username" id="username" class="required" placeholder="Username" title="Required." autocomplete="off" />
                    </div>
                </div>                
                <div class="password">
                	<div class="passwordinner">
                    	<input type="password" name="password" id="password" class="required" placeholder="Password" title="Required." autocomplete="off" />
                    </div>
                </div>                
                <button type="submit" id="sign_btn">Log In</button>            
                <div class="row">        
					<div class="col-md-12">
						<a href="<?php echo base_url().'forgot_password';?>" style="color: #f9f9f9;font-size: 13px;font-weight: 600;">I forgot my password</a>
					</div>
                </div>            
            </form>            
        </div><!--loginboxinner-->
    </div><!--loginbox-->
<script>
$(document).ready(function(){
	$('#login_frm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error').addClass('has-success');
			element.remove();
		},
		submitHandler: function(form){
			var site_base_url = $('#h_base_url').val();
			var ajax_base_url = $('#ajax_base_url').val();
			var form = $('#login_frm');
			var url = ajax_base_url+form.attr('action');
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					$('#sign_btn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					if(result=='success'){
						var h_redirect_url = $('#h_redirect_url').val();
						if(h_redirect_url!=''){
							window.location=site_base_url+h_redirect_url;
						}else{
							window.location=site_base_url+'department/readiness';
						}
					}else{
						$("html, body").animate({ scrollTop: 0 }, "slow");
						$('.loginmsg').html('<div class="alert alert-danger">'+result+'</div>');
						$('.nousername').show();
						$('#sign_btn').html('Log In');
					}
				},
				error: function(xhr, status, error_desc){				
					$("html, body").animate({ scrollTop: 0 }, "slow");
					$('.loginmsg').html('<div class="alert alert-danger">'+error_desc+'</div>');
					$('.nousername').show();
					$('#sign_btn').html('Log In');
				}
			});		
			return false;
		}
	});
});
</script>
</body>
</html>