<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php if(isset($test_detail->test_title)&&$test_detail->test_title!=''){echo $test_detail->test_title;}?></title>
<link href="<?php echo base_url();?>assets/frontend/images/favicon.png" rel="shortcut icon">
<meta name="viewport" id="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/frontend/survey/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/frontend/survey/css/font-awesome.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/frontend/survey/css/custom.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/frontend/survey/css/responsive.css" />
<link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>

<script src="<?php echo base_url();?>assets/frontend/survey/js/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url();?>assets/frontend/survey/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/frontend/survey/js/jquery.validate.min.js" type="text/javascript"></script>
</head>

<body data-spy="scroll">
  	<div class="header">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-12">
                	<div class="survey_name">
                    	<h1><?php if(isset($test_detail->test_title)&&$test_detail->test_title!=''){echo $test_detail->test_title;}?>
						
						<span style="text-transform:capitalize;">
							<?php 
							if(isset($test_detail->current_test_type) && $test_detail->current_test_type==1){
								echo ' (Pre Test)';
							}else if(isset($test_detail->current_test_type) && $test_detail->current_test_type==2){
								echo ' (Post Test)';
							}
							?>
						</span>
						</h1>
						
                    </div>
					<div id="countdown" class="timer google_translate" align="right"></div>
                </div>
            </div>
            
        </div>
    </div>
     

<div class="wrapper">
<div class="container">
	<div class="row">
	