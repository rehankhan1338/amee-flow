<style>
 .radio label.checked{
    background-color: #df2626;
    width: 100%;
    padding-top: 5px;
    padding-bottom: 5px;
    padding-left: 30px;
    border-radius: 4px;
    color: white;
}
</style>
<div class="col-md-12">
<div class="questions_div">
<form class="" id="frm" method="post" action="<?php echo base_url();?>survey_form/answer_save" enctype="multipart/form-data">	
	
	<input type="hidden" id="h_survey_code" name="h_survey_code" value="<?php if(isset($survey_detail->survey_code)&&$survey_detail->survey_code!=''){echo $survey_detail->survey_code;}?>">
	<input type="hidden" id="h_survey_id" name="h_survey_id" value="<?php if(isset($survey_detail->survey_id)&&$survey_detail->survey_id!=''){echo $survey_detail->survey_id;}?>">
	<input type="hidden" id="h_department_id" name="h_department_id" value="<?php if(isset($survey_detail->department_id)&&$survey_detail->department_id!=''){echo $survey_detail->department_id;}?>">
	<input type="hidden" id="h_auth_code" name="h_auth_code" value="<?php if(isset($auth_code)&&$auth_code!=''){echo $auth_code;}?>">
	<input type="hidden" name="next_page_link" id="next_page_link" value="<?php echo $next_page_link; ?>">

<?php $i=$current_page; foreach($surveys_questions_detail as $questions_detail){?>
<?php $answers_result = get_survey_answers_detail_by_question_id($survey_detail->survey_id, $auth_code, $questions_detail->question_id);?>
			
	<input type="hidden" id="h_question_id[]" name="h_question_id[]" value="<?php if(isset($questions_detail->question_id)&&$questions_detail->question_id!=''){echo $questions_detail->question_id;}?>">
				
	<?php if(isset($questions_detail->question_type)&&$questions_detail->question_type==3){?>
		<div class="qus_box">
			<div class="qus_head">
				<span><?php echo $i; ?></span>
				<div class="que_line"><?php if(isset($questions_detail->question_title)&&$questions_detail->question_title!=''){echo ucwords($questions_detail->question_title);} ?></div>
			</div>
			
			<div class="qus_options">
				<input type="text" title="<?php if(isset($questions_detail->required_message)&&$questions_detail->required_message!=''){echo $questions_detail->required_message;}?>" name="field_name<?php echo $questions_detail->question_id; ?>" id="field_name<?php echo $questions_detail->question_id; ?>" class="form-control <?php if(isset($questions_detail->is_required)&&$questions_detail->is_required=='1'){echo 'required';}?>" value="<?php if(isset($answers_result)&&$answers_result!=''){echo $answers_result;}?>"/>
			</div>
			
		</div>
	
	
	<?php }else if(isset($questions_detail->question_type)&& $questions_detail->question_type==1){ 
		$question_answers = get_choics_of_multiple_type_question($questions_detail->question_id); ?>	
		
		<div class="qus_box">
			<div class="qus_head">
				<span><?php echo $i; ?></span>
				<div class="que_line"><?php if(isset($questions_detail->question_title)&&$questions_detail->question_title!=''){echo ucwords($questions_detail->question_title);} ?>
				</div>
			</div>
			<div class="qus_options">
				<?php foreach($question_answers as $answers){?>
					<div class="radio">
						<label><input type="radio" title="<?php if(isset($questions_detail->required_message)&&$questions_detail->required_message!=''){echo $questions_detail->required_message;}?>" name="field_name<?php echo $questions_detail->question_id; ?>" id="field_name<?php echo $questions_detail->question_id; ?>" class="<?php if(isset($questions_detail->is_required)&&$questions_detail->is_required=='1'){echo 'required';}?>" value="<?php echo $answers->answer_id;?>" <?php if(isset($answers_result)&& $answers_result==$answers->answer_id){?> checked="checked" <?php }?> />
							<?php echo $answers->answer_choice; ?>
						</label>
					</div>
				<?php } ?>
				
			</div>
			<!--<div class="errorTxt<?php //echo $questions_detail->question_id;?> alert alert-danger">This field is required!</div>-->
		</div>
	
	<?php }else if(isset($questions_detail->question_type)&& $questions_detail->question_type==7){ 
		$question_answers = get_choics_of_multiple_type_question($questions_detail->question_id); ?>	
		
		<div class="qus_box">
			<div class="qus_head">
				<span><?php echo $i; ?></span>
				<div class="que_line"><?php if(isset($questions_detail->question_title)&&$questions_detail->question_title!=''){echo ucwords($questions_detail->question_title);} ?>
				</div>
			</div>
			<div class="qus_options">
				<?php foreach($question_answers as $answers){?>
					<div class="radio">
						<label><input type="checkbox" title="<?php if(isset($questions_detail->required_message)&&$questions_detail->required_message!=''){echo $questions_detail->required_message;}?>" name="field_name<?php echo $questions_detail->question_id; ?>[]" id="field_name<?php echo $questions_detail->question_id; ?>" class="<?php if(isset($questions_detail->is_required)&&$questions_detail->is_required=='1'){echo 'required';}?>" value="<?php echo $answers->answer_id;?>" <?php if(isset($answers_result)&& $answers_result==$answers->answer_id){?> checked="checked" <?php }?> /> &nbsp;
							<?php echo $answers->answer_choice; ?>
						</label>
					</div>
				<?php } ?>
				
			</div>
			<!--<div class="errorTxt<?php //echo $questions_detail->question_id;?> alert alert-danger">This field is required!</div>-->
		</div>	
		
	<?php }else if(isset($questions_detail->question_type)&&$questions_detail->question_type==2){
		$multiple_column = get_choics_of_multiple_column($questions_detail->question_id); 
		$multiple_rows = get_choics_of_multiple_rows($questions_detail->question_id); ?>
		
		<div class="qus_box">
			<div class="qus_head">
				<span><?php echo $i; ?></span>
				<div class="que_line"><?php if(isset($questions_detail->question_title)&&$questions_detail->question_title!=''){echo ucwords($questions_detail->question_title);} ?></div>
			</div>
			
			<div class="qus_options">
			<table class="matrix" cellpadding="5px">
				<thead>
					<td style="visibility:hidden;">Categories</td>
					
					<?php foreach($multiple_column as $columns){?>
						<td nowrap="nowrap" style="font-weight:600;"><?php echo $columns->choices;?></td>
					<?php }?>
				</thead>
				
				<?php foreach($multiple_rows as $rows){?>
					<tr style="border-top:1px solid #dedede;">
					
						<?php $matrix_answers_result = get_survey_matrix_answers_detail($survey_detail->survey_id, $auth_code, $questions_detail->question_id, $rows->row_id);?>
											
						<td style="font-weight:600;"><input type="hidden" name="row_id[]" id="row_id[]" value="<?php echo $rows->row_id;?>"/>
							<?php echo $rows->choices;?>
						</td>						
												
						<?php foreach($multiple_column as $columns){?>
							<td><input type="radio" name="matrix_field_name<?php echo $rows->row_id;?>" id="matrix_field_name<?php echo $rows->row_id;?>" value="<?php echo $columns->row_id;?>" class="<?php if(isset($questions_detail->is_required) && $questions_detail->is_required=='1'){echo 'required';}?>" <?php if(isset($matrix_answers_result) && $matrix_answers_result==$columns->row_id){?> checked="checked" <?php } ?> /></td>
						<?php } ?>
					</tr>
				<?php }?>
			</table>
			</div>
		</div>	
	
	
	<?php }else if(isset($questions_detail->question_type)&&$questions_detail->question_type==4){?>
		<div class="qus_box">
			<div class="qus_head">
				<span><?php echo $i; ?></span>
				<div class="que_line"><?php if(isset($questions_detail->question_title)&&$questions_detail->question_title!=''){echo ucwords($questions_detail->question_title);} ?></div>
			</div>
			
			<div class="qus_options">
            <ul class="rank_label">
				<li><?php if(isset($questions_detail->nps_first_field) && $questions_detail->nps_first_field!=''){ echo $questions_detail->nps_first_field;}?></li>
				<li><?php if(isset($questions_detail->nps_middle_field) && $questions_detail->nps_middle_field!=''){ echo $questions_detail->nps_middle_field;}?></li>
				<li><?php if(isset($questions_detail->nps_last_field) && $questions_detail->nps_last_field!=''){ echo $questions_detail->nps_last_field;}?></li>
			</ul>
            <div class="switch-field">
            	<?php for($np=0; $np<=10; $np++){?>	 
            		<input type="radio" title="<?php if(isset($questions_detail->required_message)&&$questions_detail->required_message!=''){echo $questions_detail->required_message;}?>" name="field_name<?php echo $questions_detail->question_id; ?>" id="<?php echo $np;?>" class="<?php if(isset($questions_detail->is_required)&&$questions_detail->is_required=='1'){echo 'required';}?>" value="<?php echo $np;?>" <?php if(isset($answers_result)&& $answers_result==$np){?> checked="" <?php }?> />
					<label for="<?php echo $np;?>"><?php echo $np;?></label>
            	<?php } ?>
            </div>
          </div>
		</div>
		
	<?php }else if(isset($questions_detail->question_type)&& $questions_detail->question_type==8){ 
		$question_answers = get_choics_of_multiple_type_question($questions_detail->question_id); ?>	

<script type="text/javascript" src="<?php echo base_url();?>assets/frontend/dynamic_drag_drop/js/jquery-ui-1.10.4.custom.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/dynamic_drag_drop/css/style.css" />
<script type="text/javascript">
jQuery(function() {
    jQuery('#sortable').sortable({
        axis: 'y',
        opacity: 0.7,
        handle: 'span',
        update: function(event, ui) {
            var list_sortable = jQuery(this).sortable('toArray').toString();
    		$('#field_name<?php echo $questions_detail->question_id; ?>').val(list_sortable);
        }
    });
});
</script>
		<div class="qus_box">
			<div class="qus_head">
				<span><?php echo $i; ?></span>
				<div class="que_line"><?php if(isset($questions_detail->question_title)&&$questions_detail->question_title!=''){echo ucwords($questions_detail->question_title);} ?>
				</div>
				
			</div>
			<div class="qus_options">
				<ul id="sortable" class="sortable_drag">
				<?php $roArr = array();
				foreach($question_answers as $answers){ $roArr[] = $answers->answer_id;?>
					<li id="<?php echo $answers->answer_id;?>">
						<span></span>
						<h4 style="margin-bottom:0; margin-top:3px;"><?php echo $answers->answer_choice; ?></h4>
					</li>
				<?php } ?>				
				</ul>
				<input type="hidden" id="field_name<?php echo $questions_detail->question_id; ?>" name="field_name<?php echo $questions_detail->question_id; ?>" value="<?php echo implode(',',$roArr);?>" />
			</div>
			<!--<div class="errorTxt<?php //echo $questions_detail->question_id;?> alert alert-danger">This field is required!</div>-->
		</div>	
		
	<?php }?>	

<?php $i++; }?>	
	
	<div class="que_submit">
 		<input type="submit"  class="next_btn" name="next_page" id="next_page" value="Next" />
	</div>
 	
	
</form>	
</div>
</div>

<script type="text/javascript">  
	jQuery(function () {
	
		jQuery('#frm').validate({
			ignore: [], 
			highlight: function(element) {
				jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
			},
			errorElement: 'span',
			errorClass: 'error',
			errorPlacement: function (error, element) {
				if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
					error.insertAfter(element.parent().parent().parent());
				}else {
					error.insertAfter(element);
				}
			},
			success: function(element) {
				element.closest('.form-group').removeClass('has-error').addClass('has-success');
				element.remove();
			}		
		}); 
	});
</script>