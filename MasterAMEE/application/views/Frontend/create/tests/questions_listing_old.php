<div id="survey_questions" class="subcontent margin20">
<div class="col-md-123">
	<div class="contenttitle2 nomargintop">
		<h3> Tests Questions</h3>
	</div>
	<div class="pull-right">
		
		<a class="btn btn-default" href="<?php echo base_url();?>department/create/tests/question/add/<?php echo $test_details->test_id;?>" style="padding:3px 7px; font-size:15px;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Question</a>				
	
	</div>
	<div class="clearfix"></div>
	
	<?php if(count($tests_questions_detail)>0){ 
		$k=1; foreach($tests_questions_detail as $questions_details){?>
		
	<div class="bs-example">
	<div class="panel-group" id="accordion_<?php echo $questions_details->question_id; ?>">
	<div class="panel panel-default">
			  
		<div class="panel-heading">
			<h4 class="panel-title">
			<a data-toggle="collapse" data-parent="#accordion_<?php echo $questions_details->question_id; ?>" href="#collapse_<?php echo $questions_details->question_id; ?>"><?php if(isset($questions_details->question_title) && $questions_details->question_title!=''){echo ucfirst($questions_details->question_title);}?> 
			<b>
				<?php if($questions_details->question_type==1){ echo ' (Multiple Choice)';}?>
				<?php if($questions_details->question_type==2){ echo ' (Matrix Table)';}?>
				<?php if($questions_details->question_type==3){ echo ' (Text Area)';}?>
				<?php if($questions_details->question_type==4){ echo ' (Net Promoter Score)';}?>
			</b>
			</a>
			</h4>
		</div>
		
		
		<div id="collapse_<?php echo $questions_details->question_id; ?>" class="panel-collapse collapse">
		<div class="panel-body" >
			<?php if(isset($questions_details->question_type) && $questions_details->question_type==1){ 
				
				$get_choics	= get_choics_of_multiple_type_question_tests($questions_details->question_id);

				foreach($get_choics as $choics){?>
				
					<p><?php echo $choics->answer_choice ;?></p>

			<?php } }?>
				

			<?php if(isset($questions_details->question_type) && $questions_details->question_type==2){ ?>
				
				<table class="matrix table">
					<thead>
					<tr class="append_matric_column">
						<td style="visibility:hidden;">Categories</td>
							
						<?php $get_column= get_choics_of_multiple_column_tests($questions_details->question_id);
							foreach($get_column as $column){?>
									
								<td class="matrix_column td_matrix_column_1"><?php echo $column->choices; ?></td>
							
						<?php } ?>
					</tr>
					</thead>

					<tbody>
						<?php $get_rows	= get_choics_of_multiple_rows_tests($questions_details->question_id);
							foreach($get_rows as $rows){?>
								<tr class="matrix_row div_statement_1" style="border-top:1px solid #dedede;">	
									<td><?php echo $rows->choices; ?></td>
								
									<?php foreach($get_column as $column){?>
										<td class="column_1" style="vertical-align:middle;"><input name="option_row_1" id="option_row_1" value="" type="radio"></td>
									<?php } ?>
								</tr>
						<?php } ?>
					</tbody>
				</table>	
			<?php } ?>	
			
			
			
			<?php if(isset($questions_details->question_type) && $questions_details->question_type==3){ ?>
								
				<div class="form-group answer_fields" id="div_choice_2" style="padding-left:50px;">
					<textarea readonly="" name="text_question_type_field" id="text_question_type_field" class="form-control" style="width:80%;resize:none;" placeholder="Example field look"></textarea>
				</div>

			<?php }?>			
			
			
			<?php if(isset($questions_details->question_type) && $questions_details->question_type==4){ ?>
								
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
				
					<div class="col-md-3" style="text-align: left;"><span><b><?php if(isset($questions_details->nps_first_field) && $questions_details->nps_first_field!=''){echo $questions_details->nps_first_field ;}?></b></span></div>
					<div class="col-md-1"></div>
					<div class="col-md-3"><span><b><?php if(isset($questions_details->nps_middle_field) && $questions_details->nps_middle_field!=''){echo $questions_details->nps_middle_field ;}?></b></span></div>
					<div class="col-md-1"></div>
					<div class="col-md-3" style="text-align: right;"><span><b><?php if(isset($questions_details->nps_last_field) && $questions_details->nps_last_field!=''){echo $questions_details->nps_last_field ;}?></b></span></div>
				
				</div>
			<?php }?>
		</div>
		</div>
	</div>
	</div>
	</div>
	<?php $k++;} } ?>
	
</div>
</div>