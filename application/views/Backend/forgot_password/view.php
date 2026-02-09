<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title ; ?></title>
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
   .login-logo a, .register-logo a{
  	color:#656565;
  }.error{
	  color: #d73925;
    font-size: 13px;
    font-style: italic;
    letter-spacing: 1px;
}  .skin-red .wrapper, .skin-red .main-sidebar, .skin-red .left-side {
    background-color: #f8f8f8;
}
.login-box, .register-box { 
    margin: 2% auto;
}

.login-page, .register-page {
    background: #f8f8f8;
}
img{ display:inline-block !important; padding-bottom:10px;}
   </style>
</head>
<body class="hold-transition skin-red login-page">
<!-- Site wrapper -->
<div class="wrapper">

    <?php if(isset($success_msg) && $success_msg!=''){?>
	  	<div class="alert alert-success " style="margin:15px 15px 0px;"><?php echo $success_msg;?> </div> 
	  <?php } ?>
	  
<div class="login-box">

<div class="login-logo" style="font-style:italic; ">
		<?php if(isset($configuration_details->logo)&& $configuration_details->logo!=''){?>
			<img src="<?php echo base_url(); ?>assets/backend/logo/<?php echo $configuration_details->logo;?>" alt="LOGO HERE" class="img-responsive" />
		<?php }else{ ?>
			<img src="<?php echo base_url(); ?>assets/backend/images/backend_dummy_logo.png" alt="LOGO HERE" class="img-responsive" />
		<?php }?><br>
    <a href="#"><b>Forgot </b>Password</a>
  </div>
  
 
  <!-- /.login-logo -->
  <div class="login-box-body">
    
    <p class="login-box-msg" style="font-size:16px;">Enter the email addresss with which you registered your account below and we will send you recovery link to reset your password.</p>

 <p id="ret">
 
	<?php  if(isset($error_login) && $error_login!=''){ ?>
            
            <div class="alert alert-dismissable alert-danger" style="margin:0;"><?php echo $error_login;?></div>
            
		<?php } 
		
		if(validation_errors() != false) { 
		
			echo'<div class="alert alert-dismissable alert-danger" style="margin:0;">'. validation_errors().'</div>'; 
			
		} ?>
 </p>
                                      
    <form role="form" id="frm" method="POST" action="">
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control required" placeholder="Email">
        <span class="glyphicon glyphicon-email form-control-feedback"></span>
      </div>
       
      <div class="row">
        
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name="submit_login">Request Password</button>
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
		 
		 <a style="border-bottom:1px dotted #3c8dbc; font-style: italic; font-weight: 600; float:right;" href="<?php echo base_url();?>admin"> <i class="fa fa-sign-in" aria-hidden="true"></i>
 Signin</a>
		 </div>
		 </div>
    </form>
	 
 <!--<hr style="color:#C23321; border:2px solid #DD4B39;"> 
      <div class="social-auth-links text-center">
     
      <a href="#" class="btn btn-primary btn-social btn-facebook btn-flat"><i class=""></i> </a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class=""></i></a>
    </div> -->
  
    
    <!--</div>
   /.login-box-body -->
</div> <br><br> 
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
		$('input').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue',
			increaseArea: '20%' // optional
		});
		$('#frm').validate();
	});   
</script> 
</body>
</html>
