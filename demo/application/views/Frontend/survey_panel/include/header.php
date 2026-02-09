<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php if(isset($survey_detail->survey_name)&&$survey_detail->survey_name!=''){echo $survey_detail->survey_name.' | ';}?>AMEE</title>
<link href="<?php echo base_url(); ?>assets/frontend/images/favicon.png" rel="shortcut icon">
<!--<link rel="icon" href="images/favicon.png">-->
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
                    	<h1>
                    		<?php if(isset($survey_detail->survey_name)&&$survey_detail->survey_name!=''){echo $survey_detail->survey_name;}?>
						</h1>
                    </div>
					<div id="google_translate_element" class="google_translate" align="right"></div>
                </div>
            </div>
            
        </div>
    </div>
    

<!--google_translate_element-->

<script type="text/javascript">
	function googleTranslateElementInit(){
		new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'ar,de,en,es,fr,ja,ko,zh-CN', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
	}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>


<div class="wrapper">
<div class="container">
	<div class="row">
	
	

