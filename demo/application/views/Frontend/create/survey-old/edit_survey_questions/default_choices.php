<?php if($question_type==1){

$get_choics	= get_choics_of_multiple_type_question($edit_question_fulldetails->question_id);

?>

<?php if(count($get_choics)>0){  $r=1;foreach($get_choics as $choics){?>
		
<input type="hidden" name="answer_choice_id[]" id="answer_choice_id[]" value="<?php echo $choics->answer_id ;?>"/>

<div class="form-group" id="old_div_choice_<?php echo $r;?>" style="padding-left:50px;">
	<input type="text" name="old_choice_<?php echo $choics->answer_id ;?>" id="old_choice_<?php echo $choics->answer_id ;?>" class="form-control required" value="<?php echo $choics->answer_choice ;?>"  placeholder="Insert text to write Choice <?php echo $r;?>" style="width:40%; display:inline-block; " <?php if(isset($survey_question_reponses_check) && $survey_question_reponses_check>0){?> readonly="" <?php } ?>  /><?php if(isset($survey_question_reponses_check) && $survey_question_reponses_check==0){?>&nbsp;&nbsp;<a href="<?php echo base_url();?>survey/delete_question_choice?answer_id=<?php echo $choics->answer_id ;?>&question_id=<?php echo $edit_question_fulldetails->question_id;?>&question_type=<?php echo $edit_question_fulldetails->question_type;?>" onclick="return confirm('Are you sure you want to delete this choice?');" class="btn btn-danger btn-xs"  >Delete</a><?php } ?>
</div>

<?php $r++; } } else{ ?>

<div class="form-group answer_fields" id="div_choice_1" style="padding-left:50px;">
	<input type="text" name="choice_1" id="choice_1" value="" class="form-control required" style="width:50%;" placeholder="Insert text to write Choice 1"  />
	<input type="hidden" name="new_choice_arr[]" id="new_choice_arr[]" value="1" />
</div>

<div class="form-group answer_fields" id="div_choice_2" style="padding-left:50px;">
	<input type="text" name="choice_2" id="choice_2" value="" class="form-control required" style="width:50%;" placeholder="Insert text to write Choice 2"  />
	<input type="hidden" name="new_choice_arr[]" id="new_choice_arr[]" value="2" />
</div>

<?php } ?>

<div class="multiple_choices_manage" style="padding-left:50px;"></div>
 
<?php } ?>

<?php if($question_type==2){ ?>

<div class="loader_result_apply_automatic_matrix_scales">
<?php if($question_type!=$edit_question_fulldetails->question_type){ ?>
<input type="hidden" name="h_tr_row_count" id="h_tr_row_count" value="1">
<input type="hidden" name="h_tr_colum_count" id="h_tr_colum_count" value="4">
<table class="matrix table" >
	<thead>
		<tr class="append_matric_column">
			<td style="visibility:hidden;">Categories</td>
			<td class="matrix_column td_matrix_column_1"><input type="text" name="field_matrix_column_1" id="field_matrix_column_1" value="" class="form-control required" placeholder="Scale point 1" /></td>
			<td class="matrix_column td_matrix_column_2"><input type="text" name="field_matrix_column_2" id="field_matrix_column_2" value="" class="form-control required" placeholder="Scale point 2" /></td>
			<td class="matrix_column td_matrix_column_3"><input type="text" name="field_matrix_column_3" id="field_matrix_column_3" value="" class="form-control required" placeholder="Scale point 3" /></td>
			<td class="matrix_column td_matrix_column_4"><input type="text" name="field_matrix_column_4" id="field_matrix_column_4" value="" class="form-control required" placeholder="Scale point 4" /></td>
		</tr>
	</thead>
	<tbody>
		<tr class="matrix_row div_statement_1" style="border-top:1px solid #dedede;">
			<td><input type="text" name="field_matrix_row_1" id="field_matrix_row_1" value="" class="form-control required" placeholder="Statement 1" /></td>
			<td class="column_1" style="vertical-align:middle;"><input name="option_row_1" id="option_row_1" value="" type="radio"></td>
			<td class="column_2" style="vertical-align:middle;"><input name="option_row_1" id="option_row_1" value="" type="radio"></td>
			<td class="column_3" style="vertical-align:middle;"><input name="option_row_1" id="option_row_1" value="" type="radio"></td>
			<td class="column_4" style="vertical-align:middle;"><input name="option_row_1" id="option_row_1" value="" type="radio"></td>
		</tr> 
	</tbody>
</table>
<?php }else{ 

$get_column	= get_choics_of_multiple_column($edit_question_fulldetails->question_id);
$get_rows = get_choics_of_multiple_rows($edit_question_fulldetails->question_id);

?>
<input type="hidden" name="h_tr_row_count" id="h_tr_row_count" value="0">
<input type="hidden" name="h_tr_colum_count" id="h_tr_colum_count" value="0">
<table class="matrix table " >
		<thead>
			<tr class="append_matric_column " style="text-align:center;">
				<td style="text-align:center; vertical-align:middle; font-weight:600;"></td>
				<?php foreach($get_column as $column){?>
					<td class="matrix_columnnnn nmtd_matrix_column_<?php echo $column->row_id;?>">
						<input type="hidden" name="h_column_id[]" id="h_column_id[]" value="<?php echo $column->row_id;?>">
						<input type="hidden" name="h_column_name[]" id="h_column_name[]" value="<?php echo $column->choices;?>">
						<input type="text" name="old_field_matrix_column_<?php echo $column->row_id;?>" id="old_field_matrix_column_<?php echo $column->row_id;?>" value="<?php echo $column->choices;?>" class="form-control required" placeholder="Scale point" <?php if(isset($survey_question_reponses_check) && $survey_question_reponses_check>0){?> readonly="" <?php } ?> />
						
					</td>
				<?php } ?>			
 			</tr>
		</thead>
		<tbody>
			<?php $k=1; foreach($get_rows as $rows){?>
			
				<tr class="matrix_rownnn old_div_statement_<?php echo $k;?>" style="border-top:1px solid #dedede;">
					<td>
					<input type="hidden" name="h_statement_row_id[]" id="h_statement_row_id[]" value="<?php echo $rows->row_id;?>">
					<input type="hidden" name="h_statement_row_name[]" id="h_statement_row_name[]" value="<?php echo $rows->choices;?>">
					<input type="text" value="<?php echo $rows->choices;?>" name="old_field_matrix_row_<?php echo $rows->row_id;?>" id="old_field_matrix_row_<?php echo $rows->row_id;?>" class="form-control required" <?php if(isset($survey_question_reponses_check) && $survey_question_reponses_check>0){?> readonly="" <?php } ?> /></td>
					<?php $l=1; foreach($get_column as $column){ ?>
						<td style="vertical-align:middle;"><input name="option_row_<?php echo $k;?>_column_<?php echo $l;?>" id="option_row_<?php echo $k;?>_column_<?php echo $l;?>" type="radio"></td>
					<?php $l++; }?>
 
				</tr> 		
			<?php $k++; }?>
		</tbody>
	</table>
<?php } ?>	
	
</div>


<?php } ?>


<?php if($question_type==3){ ?>

<div class="form-group answer_fields" id="div_choice_2" style="padding-left:50px;">
	<textarea readonly="readonly" name="text_question_type_field" id="text_question_type_field" class="form-control" style="width:80%;resize:none;" placeholder="Example field look"></textarea>
</div>

<?php } ?>


<?php if($question_type==4){ ?>
	
	<div class="col-md-12 nps" style="text-align:center;">
		<div class="col-md-1"><span>0</span><p><input type="radio" name="npsq" /></p></div>
		<div class="col-md-1"><span>1</span><p><input type="radio" name="npsq" /></p></div>
		<div class="col-md-1"><span>2</span><p><input type="radio" name="npsq" /></p></div>
		<div class="col-md-1"><span>3</span><p><input type="radio" name="npsq" /></p></div>
		<div class="col-md-1"><span>4</span><p><input type="radio" name="npsq" /></p></div>
		<div class="col-md-1"><span>5</span><p><input type="radio" name="npsq" /></p></div>
		<div class="col-md-1"><span>6</span><p><input type="radio" name="npsq" /></p></div>
		<div class="col-md-1"><span>7</span><p><input type="radio" name="npsq" /></p></div>
		<div class="col-md-1"><span>8</span><p><input type="radio" name="npsq" /></p></div>
		<div class="col-md-1"><span>9</span><p><input type="radio" name="npsq" /></p></div>
		<div class="col-md-1"><span>10</span><p><input type="radio" name="npsq" /></p></div>
		<div class="col-md-1"></div>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-12 nps" style="text-align:center;">
	
		<div class="col-md-3"><span><input type="text" name="npsq_first_field" id="npsq_first_field" value="<?php if(isset($edit_question_fulldetails->nps_first_field) && $edit_question_fulldetails->nps_first_field!=''){ echo $edit_question_fulldetails->nps_first_field; } ?>" class="form-control required" placeholder="Not Likely at All" <?php if(isset($survey_question_reponses_check) && $survey_question_reponses_check>0){?> readonly="" <?php } ?> /></span></div>
		<div class="col-md-1"></div>
		<div class="col-md-3"><span><input type="text" name="npsq_middle_field" id="npsq_middle_field" value="<?php if(isset($edit_question_fulldetails->nps_middle_field) && $edit_question_fulldetails->nps_middle_field!=''){ echo $edit_question_fulldetails->nps_middle_field; } ?>" class="form-control" placeholder="Neutral" <?php if(isset($survey_question_reponses_check) && $survey_question_reponses_check>0){?> readonly="" <?php } ?>  /></span></div>
		<div class="col-md-1"></div>
		<div class="col-md-3"><span><input type="text" name="npsq_last_field" id="npsq_last_field" value="<?php if(isset($edit_question_fulldetails->nps_last_field) && $edit_question_fulldetails->nps_last_field!=''){ echo $edit_question_fulldetails->nps_last_field; } ?>" class="form-control required" placeholder="Extremley Likely" <?php if(isset($survey_question_reponses_check) && $survey_question_reponses_check>0){?> readonly="" <?php } ?> /></span></div>
	
	</div>
 

<?php } ?>
