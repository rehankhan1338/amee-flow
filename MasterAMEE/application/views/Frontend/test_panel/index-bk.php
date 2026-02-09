<div class="col-md-12">
<div class="welcome_div">
<script type="text/javascript">  
jQuery(function () {

	jQuery('#frm').validate({
		ignore: [], 
		highlight: function(element) {
			jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error').addClass('has-success');
			element.remove();
		}	
	}); 
}); 
</script>
<h1 class="title"> Welcome to AMEE Online Test </h1>
<div class="test_page_assignment_panel">
<form class="form-horizontal" id="frm" method="post" action="<?php echo base_url();?>test_form/test_start_details" enctype="multipart/form-data" >	
 
<input type="hidden" id="h_current_test_type" name="h_current_test_type" value="<?php if(isset($test_detail->current_test_type)&&$test_detail->current_test_type!=''){echo $test_detail->current_test_type;}?>">
<input type="hidden" id="h_test_code" name="h_test_code" value="<?php if(isset($test_detail->test_code) && $test_detail->test_code!=''){echo $test_detail->test_code;}?>" />
<input type="hidden" id="h_test_id" name="h_test_id" value="<?php if(isset($test_detail->test_id) && $test_detail->test_id!=''){echo $test_detail->test_id;}?>" />
<input type="hidden" id="h_department_id" name="h_department_id" value="<?php if(isset($test_detail->department_id) && $test_detail->department_id!=''){echo $test_detail->department_id;}?>" />
<input type="hidden" id="h_auth_code" name="h_auth_code" value="<?php if(isset($auth_code) && $auth_code!=''){echo $auth_code;}?>" />		
		
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
	
	<?php $i=1; foreach($dempgraphy_questions_detail as $questions_detail){?>

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
		
		<?php if(isset($test_detail->current_test_type) && $test_detail->current_test_type!=2){?>
			<div class="que_submit">
				<button type="submit" class="btn btn-primary" name="next_page" id="next_page"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Start Test Now!</button>
			</div>
		<?php }else{ ?>
		
			<?php if(isset($test_auth_code_detail->first_name)&&$test_auth_code_detail->first_name!=''){?>
			
				<div class="que_submit">
					<a class="btn btn-primary" href="<?php echo base_url().'test/questions/'.$test_detail->test_code.'/'.$auth_code;?>"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Start Test Now !</a>
				</div>
				
				<?php }else{ ?>
					<div class="que_submit">
				<button type="submit" class="btn btn-primary" name="next_page" id="next_page"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Start Test Now!</button>
			</div>
				<?php } ?>
			
		<?php } ?>	 	
	
</form>	
 </div> 	   
</div>
</div>