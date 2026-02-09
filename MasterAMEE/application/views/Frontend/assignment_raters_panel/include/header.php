<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php if(isset($assingment_detail->assignment_title)&&$assingment_detail->assignment_title!=''){echo $assingment_detail->assignment_title.' | ';}?>AMEE</title>
<link href="<?php echo base_url(); ?>assets/frontend/images/favicon.png" rel="shortcut icon">
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
<style type="text/css">
.footer{position:relative;}
</style>
</head>
<body data-spy="scroll">
  	<div class="header">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-12">
                	<div class="survey_name">
                    	<h1>Welcome to the AMEE Online Assignment rating dashboard</h1>
						<label class="sub_label"><?php if(isset($assingment_detail->assignment_title)&&$assingment_detail->assignment_title!=''){echo $assingment_detail->assignment_title;}?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
		