<script type="text/javascript">
jQuery(function () { 
	jQuery('#frm_edit_pop<?php echo $skip_id;?>').validate({
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
<form method="post" id="frm_edit_pop<?php echo $skip_id;?>" action="<?php echo base_url();?>survey/edit_skip_logic_condition_entry">
<input type="hidden" name="h_question_id" id="h_question_id" value="<?php echo $question_id;?>" />
<input type="hidden" name="h_question_type" id="h_question_type" value="<?php echo $question_type;?>" />
<input type="hidden" name="h_skip_id" id="h_skip_id" value="<?php echo $skip_id;?>" />
<input type="hidden" name="h_survey_id" id="h_survey_id" value="<?php echo $survey_id;?>" />
<div class="row">
<div class="col-md-12">
<div class="col-md-5">
	<div class="form-group">
		<label>Condition:</label>
		<select class="form-control required" name="edit_answer_id_condition" id="edit_logic_condition">
			<option value=""> -- select --</option>
			<?php foreach($survey_question_ansers_details as $ansers_details){?>
				<option value="<?php echo $ansers_details->answer_id;?>" <?php if(isset($skip_logic_condition_fulldetails->answer_id) && $skip_logic_condition_fulldetails->answer_id==$ansers_details->answer_id){?> selected="selected" <?php } ?>><?php echo $ansers_details->answer_choice; if(isset($ansers_details->choices_scale) && $ansers_details->choices_scale!='' && $question_type==2){ echo ' - '.$ansers_details->choices_scale; } ?></option>
			<?php } ?>
		</select>
	</div>
</div>

<div class="col-md-2" style="margin:0; padding:0">
	<div class="form-group">
		<label>Operator:</label>
		<select class="form-control required" name="edit_logic_operator" id="edit_logic_operator">
			<option value=""> -- select --</option>
			<option value="0" <?php if(isset($skip_logic_condition_fulldetails->logic) && $skip_logic_condition_fulldetails->logic==0){?> selected="selected" <?php } ?> >Is Selected</option>
			<option value="1" <?php if(isset($skip_logic_condition_fulldetails->logic) && $skip_logic_condition_fulldetails->logic==1){?> selected="selected" <?php } ?>>Is Not Selected</option>
		</select>
	</div>
</div>

<div class="col-md-3">
	<div class="form-group">
		<label>Skip To:</label>
		<?php $skip_to_question_list = get_skip_to_question_list_h($survey_id,$question_priority);?>	
		<select class="form-control required" name="edit_logic_skip_to" id="edit_logic_skip_to">
			<option value=""> -- select --</option>
			<?php if(count($skip_to_question_list)>0){ foreach($skip_to_question_list as $skip_to_question_details){?>
				<option value="<?php echo $skip_to_question_details->question_id;?>" <?php if(isset($skip_logic_condition_fulldetails->skip_to) && $skip_logic_condition_fulldetails->skip_to==$skip_to_question_details->question_id){?> selected="selected" <?php } ?>>Q<?php echo $skip_to_question_details->priority;?> - <?php echo $skip_to_question_details->question_title;?></option>
			<?php } } ?>
			<option value="finish_survey" <?php if(isset($skip_logic_condition_fulldetails->skip_to) && $skip_logic_condition_fulldetails->skip_to=='finish_survey'){?> selected="selected" <?php } ?>>End of Survey</option>
		</select>
	</div>
</div>

<div class="col-md-2" style="margin:0; padding:0">
	<label>&nbsp;</label>
	<button type="submit" class="btn btn-default" style="display:block; padding:4px 20px;margin-top: 5px;" >Done</button>
</div>
</div>
</div>
</form>