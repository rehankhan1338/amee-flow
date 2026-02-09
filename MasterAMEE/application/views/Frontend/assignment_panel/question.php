<div class="col-md-12"> 
<style>
.que_submit {margin: 20px 0;}
.modal-dialog{max-width:400px;}
.modal-dialog .modal-header strong{ color:#fff;}</style>
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
jQuery('#frm_pop').validate({
  ignore: [], 
  highlight: function(element) {
	jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
  },
  success: function(element) {
	element.closest('.form-group').removeClass('has-error').addClass('has-success');
	element.remove();
  }
});	
jQuery('#frm_self_pop').validate({
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
function open_model_upload_instruction_add(){
	var txt_first_name = jQuery("#txt_first_name").val();
	var txt_last_name = jQuery("#txt_last_name").val();
	if(txt_first_name==''){
		alert('Please enter your first name!');
	}else if(txt_last_name==''){
		alert('Please enter your last name!');
	}else{
		jQuery("#open_model_upload_instruction_add").modal('show');
	}
}
function open_model_self_rate_add(){
 	jQuery("#open_model_self_rate_add").modal('show');
}
function fun_upload_instruction(upload_type){
	if(upload_type=='textbox'){
		jQuery('#d_textbox').show();
		jQuery('#document_title').addClass(" required ");
		
		jQuery('#d_browse').hide();
		jQuery('#upload_inst').removeClass(" required ");
		
		jQuery('#d_youtube_link').hide();
		jQuery('#txt_youtube_link').removeClass(" required ");
	
	}else if(upload_type=='youtube_video_link'){
		jQuery('#d_browse').hide();
		jQuery('#upload_inst').removeClass(" required ");
		jQuery('#d_youtube_link').show();
		jQuery('#txt_youtube_link').addClass(" required ");
		jQuery('#d_textbox').hide();
		jQuery('#document_title').removeClass(" required ");
	}else{
 		jQuery('#d_youtube_link').hide();
		jQuery('#txt_youtube_link').removeClass(" required ");
		jQuery('#d_browse').show();
		jQuery('#upload_inst').addClass(" required ");
		
		jQuery('#d_textbox').hide();
		jQuery('#document_title').removeClass(" required ");
	}
}
</script>
<div class="questions_div question_page_assignment_panel">
	
	<form  id="frm" method="post" action="<?php echo base_url();?>assignment/answer_save" enctype="multipart/form-data">	
		<div class="instructions"><strong>Assignment Prompt: </strong>Define the word communication in 150 words or less and type your response into the textbox option.</div>
		<div class="que_submit"> 
			<a class="btn btn-default" style="padding:5px 50px;" onclick="return open_model_upload_instruction_add();"><i class="fa fa-upload" aria-hidden="true"></i> Create Assignment</a>			
	 	</div>
		<hr />
		<input type="hidden" id="h_assignment_code" name="h_assignment_code" value="<?php if(isset($assingment_detail->assignment_code)&&$assingment_detail->assignment_code!=''){echo $assingment_detail->assignment_code;}?>">
		<input type="hidden" id="h_assignment_id" name="h_assignment_id" value="<?php if(isset($assingment_detail->id) && $assingment_detail->id!=''){echo $assingment_detail->id;}?>">
		<input type="hidden" id="h_department_id" name="h_department_id" value="<?php if(isset($assingment_detail->department_id) && $assingment_detail->department_id!=''){echo $assingment_detail->department_id;}?>">
		<input type="hidden" id="h_auth_code" name="h_auth_code" value="<?php if(isset($auth_code)&&$auth_code!=''){echo $auth_code;}?>">
		
 	<?php $i=1; foreach($assingment_questions_detail as $questions_detail){?>

	<?php $answers_result = get_assingment_answers_detail_by_question_id($assingment_detail->id, $auth_code, $questions_detail->question_id);?>
				
		<input type="hidden" id="h_question_id[]" name="h_question_id[]" value="<?php if(isset($questions_detail->question_id) && $questions_detail->question_id!=''){echo $questions_detail->question_id;}?>">
		<input type="hidden" id="h_question_type[]" name="h_question_type[]" value="<?php echo $questions_detail->question_type;?>">
					
		<?php if(isset($questions_detail->question_type)&&$questions_detail->question_type==3){?>
	 			
			<div class="form-group">
				<label class="control-label"><?php if(isset($questions_detail->question_title) && $questions_detail->question_title!=''){echo ucwords($questions_detail->question_title);} ?> <?php if(isset($questions_detail->is_required)&&$questions_detail->is_required=='1'){echo '*';}?></label>
				<div class=""><input type="text" title="<?php if(isset($questions_detail->required_message)&&$questions_detail->required_message!=''){echo $questions_detail->required_message;}?>" name="field_name<?php echo $questions_detail->question_id; ?>" id="field_name<?php echo $questions_detail->question_id; ?>" class="form-control <?php if(isset($questions_detail->is_required)&&$questions_detail->is_required=='1'){echo 'required';}?>" value="<?php if(isset($answers_result)&&$answers_result!=''){echo $answers_result;}?>"/></div>
			</div>
			   
		<?php }else if(isset($questions_detail->question_type)&& $questions_detail->question_type==1){ 
				
				$question_answers = get_assignment_choics_of_multiple_type_question($questions_detail->question_id); ?>	
			
				<div class="form-group">
					<label class=" control-label"><?php if(isset($questions_detail->question_title)&&$questions_detail->question_title!=''){echo ucwords($questions_detail->question_title);} ?> <?php if(isset($questions_detail->is_required)&&$questions_detail->is_required=='1'){echo '*';}?></label>
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

		
		<?php $i=1; foreach($assingment_courses_detail as $courses_detail){?>
		
		<?php $courses_result = get_courses_assingment_answers_detail_by_course_id($assingment_detail->id, $courses_detail->id, $auth_code);?>
		
			<div class="form-group">
				<label class="control-label">Course(s) currently enrolled in #<?php echo $i.': <span style="font-weight:200;">&nbsp;&nbsp;'.$courses_detail->course_enrolled.'</span>';//' '.$courses_detail->pslo_number;?></label>
				<input type="hidden" name="h_courses_id[]" id="h_courses_id[]" value="<?php echo $courses_detail->id;?>" />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="txt_courses[]" id="txt_courses[]" value="<?php echo $courses_detail->id;?>" <?php if(isset($courses_result)&& $courses_result>0){?> checked="checked" <?php }?>/>
			</div>
			
		<?php $i++; }?>	
		  
		<div class="que_submit">
	 		<button type="submit" class="btn btn-primary" name="next_page" id="next_page" style="padding:5px 50px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save & Update</button>
			 		
	 	</div> 	
	</form>	

<hr />
	<div class="final_rating">
		<div class="form-group">
			<label class="control-label">Please self-rate before submitting final answer.</label>
			&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-success" onclick="return open_model_self_rate_add();"><i class="fa fa-star" aria-hidden="true"></i> Self Rate</a>
		</div>
		
		<div class="col-md-12 instructions">
			<label class="control-label col-md-4" style="margin-bottom:0;">Is this your final answer? </label>
			<div class="col-md-8">
				<input type="radio" name="finish_status" id="finish_status_1" onclick="return apply_finish_status('1','<?php echo $assingment_detail->id;?>','<?php echo $auth_code;?>','<?php echo $assingment_detail->assignment_code;?>');" value="1" /> Yes &nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="finish_status" id="finish_status_0" onclick="return apply_finish_status('0','<?php echo $assingment_detail->id;?>','<?php echo $auth_code;?>','<?php echo $assingment_detail->assignment_code;?>');" checked="checked" value="0" /> No</div>
		</div><br /><br /><br />
	</div>

</div>
</div>

<script type="text/javascript">
function apply_finish_status(status,assingment_id,auth_code,assignment_code){	

	if(status!='' && assingment_id!='' && auth_code!=''){
		
		if(status==1){
			var txt_first_name = jQuery("#txt_first_name").val();
			var txt_last_name = jQuery("#txt_last_name").val();
			if(txt_first_name==''){
				alert('Please enter your first name!');
			}else if(txt_last_name==''){
				alert('Please enter your last name!');
			}else{
				window.location.href = "<?php echo base_url();?>assignment/apply_finish_status?status="+status+'&assingment_id='+assingment_id+'&auth_code='+auth_code+'&assignment_code='+assignment_code;
			}	
		}else{
			window.location.href = "<?php echo base_url();?>assignment/apply_finish_status?status="+status+'&assingment_id='+assingment_id+'&auth_code='+auth_code+'&assignment_code='+assignment_code;
		}
		
	}else{
		return false;
	} 	
 }	
</script>

<div class="modal fade" id="open_model_self_rate_add" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<strong>Self-Rate</strong>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	
	<div class="modal-body" style="padding:10px;">
		<form method="post" id="frm_self_pop" class="" action="<?php echo base_url();?>assignment/self_rating_save" enctype="multipart/form-data">
			
			<div class="col-md-12 instructions">Self-Rate! Please rate how well you think you scored on this assessment task. Click the drop down box below and select an option. </div>
			<input type="hidden" id="h_assignment_code" name="h_assignment_code" value="<?php if(isset($assingment_detail->assignment_code)&&$assingment_detail->assignment_code!=''){echo $assingment_detail->assignment_code;}?>">
			<input type="hidden" id="h_assignment_id" name="h_assignment_id" value="<?php if(isset($assingment_detail->id)&&$assingment_detail->id!=''){echo $assingment_detail->id;}?>">
			<input type="hidden" name="h_auth_code" id="h_auth_code" value="<?php echo $auth_code;?>" />
			
 			<div class="form-group">
				<label class="control-label">Rate Your-Self *</label>
				<select class="form-control required" name="txt_rate_your_self" id="txt_rate_your_self">
					<option value="">--select--</option>
					<?php foreach($assingment_rubric_criterion_detail as $criterion_detail)	{?>
						<option value="<?php echo $criterion_detail->id;?>"<?php if(isset($assingment_auth_code_detail->rate_your_self) && $assingment_auth_code_detail->rate_your_self==$criterion_detail->id){ ?> selected="selected" <?php } ?>><?php echo $criterion_detail->range_name_column.' ('.$criterion_detail->oprf_column.'-'.$criterion_detail->oprf_column_sec.')';?></option>
					<?php } ?>			
				</select>
			</div>
 
 			<div class="form-group">
				<input type="submit" name="submit" class="btn btn-primary view_btn" value='Submit'/>
			</div>
			
		</form>
		
		<div class="clearfix"></div>
	</div>
</div>
</div>
</div>

<div class="modal fade" id="open_model_upload_instruction_add" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<strong>Create Assignment</strong>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	
	<div class="modal-body" style="padding:10px;">
		<form method="post" id="frm_pop" class="" action="<?php echo base_url();?>assignment/document_save" enctype="multipart/form-data">
			<input type="hidden" name="h_assignment_id" id="h_assignment_id" value="<?php echo $assingment_detail->id;?>" />
			<input type="hidden" name="h_assignment_code" id="h_assignment_code" value="<?php echo $assingment_detail->assignment_code;?>" />
			<input type="hidden" name="h_auth_code" id="h_auth_code" value="<?php echo $auth_code;?>" />
			
 			<div class="form-group">
				<label class="control-label">Upload Type *</label>
				<select class="form-control required" name="upload_instruction_type" id="upload_instruction_type" onchange="return fun_upload_instruction(this.value);">
					<option value="">--select--</option>
 					<option value="audio">Upload Audio</option>
					<option value="document">Upload Document</option>
					<option value="image">Upload Image</option>
					<!--<option value="video">Video</option>-->
					<option value="youtube_video_link">Upload Video Link</option>
					<option value="textbox">Textbox</option>						
				</select>
			</div>
			
			<div class="form-group" id="d_browse" style="display:none; margin-top:15px;">
				<input type="file" class="required" name="upload_inst" id="upload_inst" />
			</div>
			
			<div class="form-group" id="d_youtube_link" style="display:none;">
				<label class="control-label">Video Link *</label>
				<input type="text" class="form-control" name="txt_youtube_link" id="txt_youtube_link" value="" placeholder="https://www.youtube.com/watch?v=UFuyjjYAz_U" />
			</div>	
			
			<div class="form-group" id="d_textbox" style="display:none; margin-top:15px;">
				<label class="control-label">Document Title *</label>
				<textarea rows="5" class="form-control" name="document_title" id="document_title" placeholder="Document Title"></textarea>
			</div>
			
			<div class="form-group">
				<input type="submit" name="submit" class="btn btn-primary view_btn" value='Submit'/>
			</div>
			
		</form>
		
		<div class="clearfix"></div>
	</div>
</div>
</div>
</div>