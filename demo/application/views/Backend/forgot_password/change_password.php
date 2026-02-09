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
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-red login-page">
<!-- Site wrapper -->
<div class="wrapper">

  
<div class="login-box">

<div class="login-logo" style="font-style:italic; ">
		<?php if(isset($configuration_details->logo)&& $configuration_details->logo!=''){?>
			<img src="<?php echo base_url(); ?>assets/backend/logo/<?php echo $configuration_details->logo;?>" alt="LOGO HERE" class="img-responsive" />
		<?php }else{ ?>
			<img src="<?php echo base_url(); ?>assets/backend/images/backend_dummy_logo.png" alt="LOGO HERE" class="img-responsive" />
		<?php }?><br>
    <a href="#"><b>Create</b> Password</a>
  </div>
  
 
  <!-- /.login-logo -->
  <div class="login-box-body">
  <!--  <p class="login-box-msg"><a href="<?php echo base_url(); ?>"> <<< BACK HOME</a></p>
    <p class="login-box-msg">Sign in to start your session</p>-->

 <p id="ret">
	<?php  if(isset($error_login) && $error_login!=''){ ?>
            
            <div class="alert alert-dismissable alert-danger"><?php echo $error_login;?></div>
            
		<?php } 
		
		if(validation_errors() != false) { 
		
			echo'<div class="alert alert-dismissable alert-danger"><small>'. validation_errors().'</small></div>'; 
			
		} ?>
 </p>
                                      
    <form role="form" id="frm" method="POST" action="">
      <div class="form-group has-feedback">
        <input type="password" name="new_password" id="new_password" class="form-control required" placeholder="New Password">
        
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="confirm_password" id="confirm_password" class="form-control required" placeholder="Confirm Password">
        
      </div>
      <div class="row">
         
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name="submit_login">Set Password</button>
        </div>
        <!-- /.col --><div class="col-xs-6" style="margin-top:10px; float:right;">
		 
		 <a style="border-bottom:1px dotted #3c8dbc; font-style: italic; font-weight: 600; float:right;" href="<?php echo base_url();?>admin"> <i class="fa fa-sign-in" aria-hidden="true"></i>
 Signin</a>
		 </div>
      </div>
    </form>
 
      
    
    <!--</div>
   /.login-box-body -->
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
		$('input').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue',
			increaseArea: '20%' // optional
		});
		$('#frm').validate(
	 {
	 	  ignore: [], 
		  highlight: function(element) {
		    $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		  },
		  success: function(element) {
		    element.closest('.form-group').removeClass('has-error').addClass('has-success');
		    element.remove();
		  },rules: {
               new_password: {
                 required: true,
      
               } ,

                   confirm_password: {
                    equalTo: "#new_password",
               }


           }
	 });
	});   
</script> 
</body>
</html>
