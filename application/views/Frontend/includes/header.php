<!doctype html>
<html lang="en-us">
<head>
<meta charset="utf-8">
<title><?php echo $title;?> :: SOC-Builder</title>
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1"><![endif]-->
<link href="<?php echo base_url();?>assets/frontend/img/ico/favicon.png" rel="shortcut icon">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="<?php echo base_url();?>assets/frontend/css/font-awesome.min.css" rel="stylesheet"><!--Font Awesome css-->
<link href="<?php echo base_url();?>assets/frontend/css/bootstrap.min.css" rel="stylesheet"><!--Bootstrap css-->
<link href="<?php echo base_url();?>assets/frontend/css/main.css" rel="stylesheet"><!--Main css-->
<link href='https://fonts.googleapis.com/css?family=Raleway:400,300,100,500' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
<link href="<?php echo base_url();?>assets/frontend/css/responsive.css" rel="stylesheet"><!--Responsive css-->
<link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/bootstrap-select.css">
<!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
<![endif]-->
<style type="text/css">*, *:before, *:after { *behavior: url(<?php echo base_url();?>assets/frontend/img/boxsizing.htc);}.error {
    color: #ff0000;
    display: block;
    font-size: 12px;
    padding: 5px;
}</style>
<script src="<?php echo base_url();?>assets/frontend/js/jquery-1.11.3.min.js"  type="text/javascript"></script><!--Library-->
<script src="<?php echo base_url();?>assets/frontend/js/jquery-migrate-1.2.1.min.js"  type="text/javascript"></script><!--Library-->
<script src="<?php echo base_url();?>assets/frontend/js/jquery.validate.js"  type="text/javascript"></script><!--Library-->
<script src="<?php echo base_url();?>assets/frontend/js/bootstrap.min.js"></script><!--Bootstrap-->
<script>
$(document).ready(function(){
	$('#register_form').validate();
});
</script>
</head>
<body>
<!-- FULLSCREEN MODAL CODE (.fullscreen) -->
    <div class="modal fade fullscreen" id="menuModal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="color:#fff;">
                <div class="modal-header" style="border:0;">
                        <button type="button" class="close btn btn-link" data-dismiss="modal" aria-hidden="true"><img src="<?php echo base_url();?>assets/frontend/img/close_btn.png" alt=""/></button> 
                        <h4 class="modal-title text-center"><span class="sr-only">main navigation</span></h4>
                </div>
                <div class="modal-body text-center">
                    <ul style="list-style-type:none;">
                        <li><a href="<?php echo base_url();?>" class="big">Home</a></li>
                        <li><a href="<?php echo base_url();?>about_us" class="big">About Us</a></li>
                        <li><a href="<?php echo base_url();?>contact_us" class="big">Contact Us</a></li>
                        <li><a href="<?php echo base_url();?>signup" class="big">Register</a></li>
                        <li><a href="<?php echo base_url();?>signin" class="big">Login</a></li>
                        
                    </ul>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.fullscreen -->
	

   