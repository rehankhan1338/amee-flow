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
<style>.fph4 {line-height: 25px;font-size: 15px;margin-bottom: 20px;text-align: center;color: #fff;font-family: "Helvetica Neue", Arial, Helvetica, sans-serif;margin-top: 15px;}
.captacha_sec { display: table; width: 100%; }
.captcha_text { letter-spacing: 5px; background-color: #f5f5f5; padding: 0 40px !important; font-size: 20px; height: 35px; line-height: 35px; }
#enter_captcha_txt { letter-spacing: 2px; }</style>
</head>
<body class="loginpage">
	<div class="loginbox">
    	<div class="loginboxinner">        	
            <div class="logo">
            	<h1><span>AMEE.</span> <?php echo $page_title;?></h1>
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
			<h4 class="fph4">Enter the email addresss with which you registered your account below and we will send you recovery link to reset your password.</h4>
            <form class="login_form" method="post" id="forgot_pass" action="home/forgot_password_send_mail">
            	<input type="hidden" name="h_base_url" id="h_base_url" value="<?php echo base_url();?>" />
				<input type="hidden" name="ajax_base_url" id="ajax_base_url" value="<?php echo $this->config->item('ajax_base_url');?>" />
				<input type="hidden" name="h_redirect_url" id="h_redirect_url" value="<?php if(isset($_GET['redirect_url']) && $_GET['redirect_url']!=''){echo $_GET['redirect_url'];}?>" />
                <div class="username">
                	<div class="usernameinner">
                    	<input type="text" name="username" id="username" class="required email" placeholder="E-Mail Address" title="Required" />
                    </div>
                </div>                
                                  
               <div class="form-group"> <button type="submit" id="submit_btn" style="margin-bottom:10px; margin-top:10px;">Send Reset Email</button> </div>           
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
	$('#forgot_pass').validate({
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
				var form = $('#forgot_pass');
				var url = site_base_url+form.attr('action');
				$.ajax({
					type: "POST",
					url: url,
					data: form.serialize(), // serializes the form's elements.
					beforeSend: function(){
						$('#submit_btn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
					},
					success: function(result, status, xhr){//alert(result);
						if(result=='success'){
							$('.loginmsg').html('<div class="alert alert-success"><strong>Success!</strong> We have sent you recovery link to reset your password, please check your mail and click the link sent to you.</div>');
							$('.nousername').show();
							$("html, body").animate({ scrollTop: 0 }, "slow");
							$('#forgot_pass')[0].reset();
							$('#submit_btn').html('Send Reset Email');
						}else{
							$("html, body").animate({ scrollTop: 0 }, "slow");
							$('.loginmsg').html('<div class="alert alert-danger">'+result+'</div>');
							$('.nousername').show();
							$('#submit_btn').html('Send Reset Email');
						}
					},
					error: function(xhr, status, error_desc){				
						$("html, body").animate({ scrollTop: 0 }, "slow");
						$('.loginmsg').html('<div class="alert alert-danger">'+error_desc+'</div>');
						$('.nousername').show();
						$('#submit_btn').html('Send Reset Email');
					}
				});
					
			return false;
		}
	});
});
</script>
</body>

</html>
