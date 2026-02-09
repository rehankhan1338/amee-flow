<div class="col-md-12">
<div class="welcome_div">
<style type="text/css">
.form-control{width:40%;}
.sweepstakes h4{margin:0 0 30px 0;}
.error{color:#a94442; font-size:14px;}
.next_btn {margin-top: 10px;padding: 5px 20px;}
.alert{margin-top:15px; padding:10px 15px;    font-weight: 600;}
.alert p{ font-weight:600;font-family:'Raleway', sans-serif; line-height:25px;}
</style>	
	<?php if(isset($survey_detail->is_introduction_msg) && $survey_detail->is_introduction_msg==0){?>
		<!--<h1 class="title"> Let's go with this! </h1>-->
		<?php echo $survey_detail->survey_introduction;?>
	<?php } ?>	
			
			<div id="result_display"></div>	 
	
			<form class="" id="startSurveyFrm" method="post" action="survey_form/start_survey_entry<?php if(isset($_GET['previewSts']) && $_GET['previewSts']==1){echo '?previewSts=1';}?>">
			
				<input type="hidden" name="h_survey_code" id="h_survey_code" value="<?php echo $survey_detail->survey_code;?>" />
				<input type="hidden" name="h_survey_id" id="h_survey_id" value="<?php echo $survey_detail->survey_id;?>" />
				<input type="hidden" name="h_anonymousSurvey" id="h_anonymousSurvey" value="<?php echo $survey_detail->anonymousSurvey;?>" />
				<input type="hidden" name="h_department_id" id="h_department_id" value="<?php echo $survey_detail->department_id;?>" />
				<input type="hidden" name="h_ajax_base_url" id="h_ajax_base_url" value="<?php echo $this->config->item('ajax_base_url');?>" />
				<input type="hidden" name="h_base_url" id="h_base_url" value="<?php echo base_url();?>" />
				
				<?php if($survey_detail->anonymousSurvey==1){?>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-2 col-form-label">First Name *</label>
					<div class="col-sm-10">
						<input type="text" class="form-control required" id="firstName" name="firstName" value="" placeholder="First Name" autocomplete="off" />
					</div>
				</div>
				
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-2 col-form-label">Last Name *</label>
					<div class="col-sm-10">
						<input type="text" class="form-control required" id="lastName" name="lastName" value="" placeholder="Last Name" autocomplete="off" />
					</div>
				</div>
				
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-2 col-form-label">Email *</label>
					<div class="col-sm-10">
						<input type="text" class="form-control email required" id="email" name="email" value="" placeholder="Email" autocomplete="off" />
					</div>
				</div>
				<?php } ?>
				
				<div class="form-group">
					<button type="submit" class="next_btn" id="startSurveyBtn" style="padding:5px 50px; font-size:15px;">Start Survey</button>
				</div>
				
			</form> 
          	  	
     
</div>
</div>

<script>
jQuery(document).ready(function(){ 
	jQuery('#startSurveyFrm').validate({
		highlight: function(element) {
			jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error').addClass('has-success');
			element.remove();
		},
		errorElement: 'span',
		errorClass: 'error',
		errorPlacement: function (error, element) {
			error.insertAfter(element);
		},
		submitHandler: function(form){
			var ajax_base_url = jQuery('#h_ajax_base_url').val();
			var site_base_url = jQuery('#h_base_url').val();
			var survey_code = jQuery('#h_survey_code').val();
			var form = jQuery('#startSurveyFrm');
			var url = ajax_base_url+form.attr('action');
			jQuery.ajax({
				type: "POST",
				url: url,
				headers: {'X-Requested-With': 'XMLHttpRequest'},
				data: form.serialize(), // serializes the form's elements.
				beforeSend: function(){
					jQuery('#startSurveyBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||');
					if(result_arr[0]=='success'){
						window.location=site_base_url+'survey/form/questions/'+survey_code+'/'+result_arr[1];
					}else{
						jQuery("html, body").animate({ scrollTop: 0 }, "slow");
						jQuery('#result_display').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						jQuery('#startSurveyBtn').html('Start Survey');
					}
				},
				error: function(xhr, status, error_desc){				
					jQuery("html, body").animate({ scrollTop: 0 }, "slow");
					jQuery('#result_display').html('<div class="alert alert-danger">'+error_desc+'</div>');
					jQuery('#startSurveyBtn').html('Start Survey');
				}
			});		
			return false;
		}
	});
});
</script>