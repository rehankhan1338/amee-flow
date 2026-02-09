<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title ; ?></title>
  <link href="<?php echo base_url(); ?>assets/frontend/images/favicon.png" rel="shortcut icon">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
<style type="text/css">
.login-page, .register-page {background: #fff url('<?php echo base_url();?>assets/frontend/images/default/noise.white.png');}
.login-logo a, .register-logo a{color:#656565;}
.skin-red .wrapper, .skin-red .main-sidebar, .skin-red .left-side {background-color: #f8f8f8;}
.login-box, .register-box { background: #fff;padding: 5px;box-shadow: 0 0 2px rgba(0,0,0,0.3);width:36%;}
img{ display:inline-block !important; padding-bottom:10px;}
.skin-red .wrapper, .skin-red .main-sidebar, .skin-red .left-side {background: #fff url('<?php echo base_url();?>assets/frontend/images/default/noise.white.png');}
.loginbox h1 {font-family: 'RobotoCondensed', Arial, Helvetica, sans-serif;font-size: 26px;color: #fff;border-bottom: 1px solid #56647d;line-height: normal;margin-bottom: 5px;text-align:center;text-transform:uppercase;margin-top:0;    padding-bottom: 5px;}
.loginbox h1 span {color: #FB9337;} 
.login-box-body, .register-box-body {box-shadow:none;background: #32415a url('<?php echo base_url();?>assets/frontend/images/patternbg.png');color:#fff;border-radius: 2px;}
.login-box-msg a{ color:#fff; font-style:italic; font-size:16px;}
.error{color: red;margin-top: 5px;letter-spacing: 0;font-style: italic;margin-bottom: 0;}
.login-box-msg, .register-box-msg {padding: 5px 0;}
</style>
</head>
<body class="hold-transition skin-red login-page">
<!-- Site wrapper -->
<div class="wrapper"> 
 
<div class="login-box">	  
 
  <div class="login-box-body loginbox"><h1><span>AMEE</span> Admin Panel</h1>
    <p class="login-box-msg"><a href="<?php echo base_url(); ?>admin"> <?php echo $this->config->item('project_name_page_first'); ?></span> <?php echo $this->config->item('project_name_page_second'); ?></a></p>
    <!--<p class="login-box-msg">Sign in to start your session</p>-->
   <p class="login-box-msg" style="font-size:17px;">Enter the email address associated with your account  and we will send you a recovery link to reset your password.</p>
 <p id="ret"> 
	<?php  if(isset($success_msg) && $success_msg!=''){ ?>
            
            <div class="alert alert-dismissable alert-success" style="margin:0;"><?php echo $success_msg;?></div>
            
		<?php } if(isset($error_login) && $error_login!=''){ ?>
            
            <div class="alert alert-dismissable alert-danger" style="margin:0;"><?php echo $error_login;?></div>
            
		<?php } 
		
		if(validation_errors() != false) { 		
			echo'<div class="alert alert-dismissable alert-danger" style="margin:0;">'. validation_errors().'</div>'; 			
		} ?>
 </p>
                                      
    <form role="form" id="frm" method="POST" action="">
      <div class="form-group has-feedback">
        <input type="text" name="username" id="username" class="form-control email required" placeholder="Email" autocomplete="off" />
        <span class="glyphicon glyphicon-email form-control-feedback"></span>
      </div>
       
      <div class="row">
        
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat" style="font-weight:600;" name="submit_login">Request Password</button>
        </div>
        <!-- /.col -->
      </div>
	  
	  <div class="row">
	<div class="col-xs-6">
          <!--<div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>-->
        </div>
		 <div class="col-xs-6" style="margin-top:10px;">
		 
		 <a style="border-bottom:1px dotted #fff; color:#fff; font-style: italic;  float:right;" href="<?php echo base_url();?>admin"> <i class="fa fa-sign-in" aria-hidden="true"></i>
 Signin</a>
		 </div>
		 </div>
    </form>

</div> 
<!-- /.login-box -->

<!-- jQuery 2.2.0 -->
<script src="<?php echo base_url(); ?>assets/backend/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo base_url(); ?>assets/backend/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url();?>assets/backend/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/iCheck/icheck.min.js"></script>
  <script>
	$(function () {
		
		$('#frm').validate();
	});   
</script> 
</body>
</html>
