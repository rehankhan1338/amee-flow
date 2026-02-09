<div class="col-md-12">
<style type="text/css">
.sweepstakes h4{margin:0 0 30px 0;}
.error{color:#a94442; font-size:14px;}
.next_btn {margin-top: 10px;padding: 5px 20px;}
.alert{margin-top:15px; padding:10px 15px;    font-weight: 600;}
.alert p{ font-weight:600;font-family:'Raleway', sans-serif; line-height:25px;}
.test_page_assignment_panel{ padding:0 15px;}
</style>
<div class="welcome_div">
<h1 class="title"> Welcome to AMEE Online Test </h1>
<div class="test_page_assignment_panel">
<div id="result_display"></div>	
<?php
$test_code = $test_detail->test_code;
$test_type = $test_detail->current_test_type;
$cookie_prefix = $this->config->item('cookie_prefix');
$cookieName = $cookie_prefix.'amee_test_'.$test_code.'_type_'.$test_type;
if($test_type!=3){
?> 
<div class="row">
<div class="instructions"><strong>Instruction: </strong>In order to track your poll/tests scores, we need to collect your email address.  This email address is only used to match pre and post-test scores.  Please use the same email if you are asked to take the test again.</div>
</div>
<?php } ?>
<form class="form-horizontal" id="startTestFrm" method="post" action="test_form/startTestEntry<?php if(isset($_GET['previewSts']) && $_GET['previewSts']==1){echo '?previewSts=1';}?>">
	


		<input type="hidden" name="h_ajax_base_url" id="h_ajax_base_url" value="<?php echo $this->config->item('ajax_base_url');?>" />
		<input type="hidden" name="h_base_url" id="h_base_url" value="<?php echo base_url();?>" /> 
		<input type="hidden" id="h_current_test_type" name="h_current_test_type" value="<?php if(isset($test_detail->current_test_type) && $test_detail->current_test_type!=''){echo $test_detail->current_test_type;}?>">
		<input type="hidden" name="h_anonymousTest" id="h_anonymousTest" value="<?php echo $test_detail->anonymousTest;?>" />
		<input type="hidden" id="h_test_code" name="h_test_code" value="<?php if(isset($test_detail->test_code) && $test_detail->test_code!=''){echo $test_detail->test_code;}?>" />
		<input type="hidden" id="h_test_id" name="h_test_id" value="<?php if(isset($test_detail->test_id) && $test_detail->test_id!=''){echo $test_detail->test_id;}?>" />
		<input type="hidden" id="h_department_id" name="h_department_id" value="<?php if(isset($test_detail->department_id) && $test_detail->department_id!=''){echo $test_detail->department_id;}?>" />		
	
	<?php if($test_detail->anonymousTest==1){?>	
	<div class="form-group">
		<label class="control-label">First Name *</label>
		<div class=""><input type="text" class="form-control required" name="txt_first_name" id="txt_first_name" value="<?php //if(isset($test_auth_code_detail->first_name)&&$test_auth_code_detail->first_name!=''){echo $test_auth_code_detail->first_name;}?>" /></div>
	</div>
	
	<div class="form-group">
		<label class="control-label">Last Name *</label>
		<div class=""><input type="text" class="form-control required" name="txt_last_name" id="txt_last_name" value="<?php //if(isset($test_auth_code_detail->last_name)&&$test_auth_code_detail->last_name!=''){echo $test_auth_code_detail->last_name;}?>" /></div>
	</div>
	
	<div class="form-group">
		<label class="control-label">Email *</label>
		<div class=""><input type="text" class="form-control email required" name="txt_email" id="txt_email" value="<?php //if(isset($test_auth_code_detail->last_name)&&$test_auth_code_detail->last_name!=''){echo $test_auth_code_detail->last_name;}?>" /></div>
	</div>
	
	<?php } $i=1; foreach($dempgraphy_questions_detail as $questions_detail){?>

	<?php $answers_result =0;
	//$answers_result = get_test_demo_answers_detail_by_question_id($test_detail->test_id, $auth_code, $questions_detail->question_id);?>
				
		<input type="hidden" id="h_question_id[]" name="h_question_id[]" value="<?php if(isset($questions_detail->question_id) && $questions_detail->question_id!=''){echo $questions_detail->question_id;}?>">
		<input type="hidden" id="h_question_type[]" name="h_question_type[]" value="<?php echo $questions_detail->question_type;?>">
					
		<?php if(isset($questions_detail->question_type)&&$questions_detail->question_type==3){?>
	 			
			<div class="form-group">
				<label class="control-label"><?php if(isset($questions_detail->question_title) && $questions_detail->question_title!=''){echo ucwords($questions_detail->question_title);} ?></label>
				<div class=""><input type="text" title="<?php if(isset($questions_detail->required_message)&&$questions_detail->required_message!=''){echo $questions_detail->required_message;}?>" name="field_name<?php echo $questions_detail->question_id; ?>" id="field_name<?php echo $questions_detail->question_id; ?>" class="form-control <?php if(isset($questions_detail->is_required)&&$questions_detail->is_required=='1'){echo 'required';}?>" value="<?php if(isset($answers_result)&&$answers_result!=''){echo $answers_result;}?>"/></div>
			</div>
			   
		<?php }else if(isset($questions_detail->question_type)&& $questions_detail->question_type==1){ 
				
				$question_answers = get_choics_of_multiple_type_question_tests($questions_detail->question_id); ?>	
			
				<div class="form-group">
					<label class=" control-label"><?php if(isset($questions_detail->question_title)&&$questions_detail->question_title!=''){echo ucwords($questions_detail->question_title);} ?></label>
					<div class="">
						<select title="<?php if(isset($questions_detail->required_message)&&$questions_detail->required_message!=''){echo $questions_detail->required_message;}?>" class="form-control <?php if(isset($questions_detail->is_required)&&$questions_detail->is_required=='1'){echo 'required';}?>" name="field_name<?php echo $questions_detail->question_id; ?>" id="field_name<?php echo $questions_detail->question_id; ?>">
							<option value="">-- select --</option>
						<?php foreach($question_answers as $answers){?>
							 <option value="<?php echo $answers->answer_id;?>" <?php if(isset($answers_result)&& $answers_result==$answers->answer_id){?> selected="selected" <?php }?>><?php echo $answers->answer_choice; ?></option>
						<?php } ?>
						</select>
					</div>
				</div>
			
		<?php } ?>	 

	<?php $i++; }?>	

		
		<?php $i=1; foreach($test_courses_detail as $courses_detail){?>
		
		<?php $courses_result = 0;
		// $courses_result = get_courses_test_answers_detail_by_course_id($test_detail->test_id, $courses_detail->id, $auth_code);?>
		
			<div class="form-group">
				<label class="control-label">Course(s) currently enrolled in #<?php echo $i.': <span style="font-weight:200;">&nbsp;&nbsp;'.$courses_detail->course_enrolled.'</span>';//' '.$courses_detail->pslo_number;?></label>
				<input type="hidden" name="h_courses_id[]" id="h_courses_id[]" value="<?php echo $courses_detail->id;?>" />
				&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="txt_courses[]" id="txt_courses[]" value="<?php echo $courses_detail->id;?>" <?php if(isset($courses_result)&& $courses_result>0){?> checked="checked" <?php }?>/>
			</div>
			
		<?php $i++; }?>	
		
		<div class="form-group row">
			<button type="submit" class="next_btn" id="startTestBtn" style="padding:5px 50px; font-size:15px;">Start Test</button>
		</div>	 
	
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>	
 </div> 	   
</div>
</div>

<script>
jQuery(document).ready(function(){ 
	jQuery('#startTestFrm').validate({
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
			var test_code = jQuery('#h_test_code').val();
			var form = jQuery('#startTestFrm');
			var url = ajax_base_url+form.attr('action');
			jQuery.ajax({
				type: "POST",
				url: url,
				data: form.serialize(), // serializes the form's elements.
				beforeSend: function(){
					jQuery('#startTestBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||');
					if(result_arr[0]=='success'){
						window.location=site_base_url+'test/questions/'+test_code+'/'+result_arr[1];
					}else if(result_arr[0]=='error' && result_arr[1]=='pre_test_first'){
 						document.cookie = '<?php echo $cookieName;?>' + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
 						jQuery("html, body").animate({ scrollTop: 0 }, "slow");
						jQuery('#result_display').html('<div class="alert alert-danger">You must need to gave pre-test first!</div>');
						jQuery('#startTestBtn').html('Start Test');
					}else{
						jQuery("html, body").animate({ scrollTop: 0 }, "slow");
						jQuery('#result_display').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						jQuery('#startTestBtn').html('Start Test');
					}
				},
				error: function(xhr, status, error_desc){				
					jQuery("html, body").animate({ scrollTop: 0 }, "slow");
					jQuery('#result_display').html('<div class="alert alert-danger">'+error_desc+'</div>');
					jQuery('#startTestBtn').html('Start Test');
				}
			});		
			return false;
		}
	});
});
</script>