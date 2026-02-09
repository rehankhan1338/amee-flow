<?php if($question_type==1){ 

$i=1; foreach($default_question_answers_detail as $answers_detail){?>

		<div class="form-group answer_fields" id="div_choice_<?php echo $i;?>" style="padding-left:50px;">
			<input type="text" name="choice_<?php echo $i;?>" id="choice_<?php echo $i;?>" value="<?php if(isset($answers_detail->answer_choice)&&$answers_detail->answer_choice!=''){echo $answers_detail->answer_choice;}?>" class="form-control required" style="width:50%;" placeholder="Insert text to write Choice 1"  />
		</div>

<?php $i++; }?>	

<!--<div class="form-group answer_fields" id="div_choice_2" style="padding-left:50px;">
	<input type="text" name="choice_2" id="choice_2" value="" class="form-control required" style="width:50%;" placeholder="Insert text to write Choice 2"  />
</div>-->

<div class="multiple_choices_manage" style="padding-left:50px;"></div>


<div class="form-group is_demo_question" style="padding-left:50px; padding-top:10px;">
	<label style="font-weight:600;">Is Demography Question:</label> &nbsp;&nbsp;&nbsp;&nbsp;
	<input type="radio" name="is_demography" id="is_demography" value="1" <?php if(isset($default_questions_row->is_demography)&&$default_questions_row->is_demography=='1'){?> checked="checked" <?php }?> class="required" style="margin: 0 0 0 10px;"/> &nbsp;Yes &nbsp;&nbsp;
	<input type="radio" name="is_demography" id="is_demography" value="0" <?php if(isset($default_questions_row->is_demography)&&$default_questions_row->is_demography=='1'){?> checked="checked" <?php }?> class="required" style="margin: 0 0 0 10px;"/> &nbsp;No
</div>
<?php } ?>

<?php if($question_type==2){ ?>
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


<?php } ?>


<?php if($question_type==3){ ?>

<div class="form-group answer_fields" id="div_choice_2" style="padding-left:50px;">
	<textarea readonly="readonly" name="text_question_type_field" id="text_question_type_field" class="form-control" style="width:80%;resize:none;" placeholder="Example field look"></textarea>
</div>

<?php } ?>


<?php if($question_type==4){ ?>
	
	<div class="col-md-12 nps" style="text-align:center;">
		<div class="col-md-1"><span>0</span><input class="form-control" type="radio" name="npsq" /></div>
		<div class="col-md-1"><span>1</span><input class="form-control" type="radio" name="npsq" /></div>
		<div class="col-md-1"><span>2</span><input class="form-control" type="radio" name="npsq" /></div>
		<div class="col-md-1"><span>3</span><input class="form-control" type="radio" name="npsq" /></div>
		<div class="col-md-1"><span>4</span><input class="form-control" type="radio" name="npsq" /></div>
		<div class="col-md-1"><span>5</span><input class="form-control" type="radio" name="npsq" /></div>
		<div class="col-md-1"><span>6</span><input class="form-control" type="radio" name="npsq" /></div>
		<div class="col-md-1"><span>7</span><input class="form-control" type="radio" name="npsq" /></div>
		<div class="col-md-1"><span>8</span><input class="form-control" type="radio" name="npsq" /></div>
		<div class="col-md-1"><span>9</span><input class="form-control" type="radio" name="npsq" /></div>
		<div class="col-md-1"><span>10</span><input class="form-control" type="radio" name="npsq" /></div>
		<div class="col-md-1"></div>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-12 nps" style="text-align:center;">
	
		<div class="col-md-3"><span><input type="text" name="npsq_first_field" id="npsq_first_field" value="" class="form-control required" placeholder="Not Likely at All" /></span></div>
		<div class="col-md-1"></div>
		<div class="col-md-3"><span><input type="text" name="npsq_middle_field" id="npsq_middle_field" value="" class="form-control" placeholder="Neutral"  /></span></div>
		<div class="col-md-1"></div>
		<div class="col-md-3"><span><input type="text" name="npsq_last_field" id="npsq_last_field" value="" class="form-control required" placeholder="Extremley Likely" /></span></div>
	
	</div>
 

<?php } ?>
