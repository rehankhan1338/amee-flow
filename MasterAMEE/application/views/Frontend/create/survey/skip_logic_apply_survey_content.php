<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<strong>Survey Question : : Manage</strong>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>

	<div class="modal-body">
		 
   			<h4><b>Q. </b><?php echo $survey_question_details->question_title;?></h4>
			
			<div class="col-md-12">
				<?php if(isset($survey_question_details->question_type) && ($survey_question_details->question_type==1 || $survey_question_details->question_type==7 || $survey_question_details->question_type==8)){?>
					<ul style="margin-left:10px; margin-top:10px;">
						<?php foreach($survey_question_ansers_details as $ansers_details){?>
							<li style="padding:3px 5px;"><?php echo $ansers_details->answer_choice;?></li>
						<?php } ?>
					</ul>
				<?php } ?>
				
				<?php if(isset($survey_question_details->question_type) && $survey_question_details->question_type==2){?>
					<table class="matrix table" style="margin-top:10px;">
						<thead>
						<tr class="append_matric_column">
							<td style="visibility:hidden;">Categories</td>

							<?php $get_column	= get_choics_of_multiple_column($survey_question_details->question_id);
								foreach($get_column as $column){?>
									<td class="matrix_column td_matrix_column_1"><?php echo $column->choices; ?></td>
							<?php } ?>
						</tr>
						</thead>
						
						<tbody>
							<?php $get_rows	= get_choics_of_multiple_rows($survey_question_details->question_id);
								foreach($get_rows as $rows){?>
									<tr class="matrix_row div_statement_1" style="border-top:1px solid #dedede;">	
										<td><?php echo $rows->choices; ?></td>

										<?php foreach($get_column as $column){?>
											<td class="column_1" style="vertical-align:middle;"><input name="option_row_1" id="option_row_1" value="" type="radio" /></td>
										<?php } ?>
									</tr>
							<?php } ?>
						</tbody>
					</table>
				<?php } ?>
				
				<?php if(isset($survey_question_details->question_type) && $survey_question_details->question_type==4){?>
					<div class="col-md-12 nps" style="text-align:center; margin-top:10px;">
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
						
						<div class="col-md-3" style="text-align:left;">
							<?php if(isset($survey_question_details->nps_first_field) && $survey_question_details->nps_first_field!=''){?>
								<span style="font-weight:600;"><?php echo $survey_question_details->nps_first_field;?></span>
							<?php } ?>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-3">
							<?php if(isset($survey_question_details->nps_middle_field) && $survey_question_details->nps_middle_field!=''){?>
								<span style="font-weight:600;"><?php echo $survey_question_details->nps_middle_field;?></span>
							<?php } ?>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-3">
							<?php if(isset($survey_question_details->nps_last_field) && $survey_question_details->nps_last_field!=''){?>
								<span style="font-weight:600;"><?php echo $survey_question_details->nps_last_field;?></span>
							<?php } ?>
						</div>
					
					</div>
				<?php } ?>
			</div>			
		 
 		<div class="clearfix"></div>
	</div>
	
	 
	
	<?php if(isset($survey_details->question_per_page) && $survey_details->question_per_page==1 && isset($survey_question_details->question_type) && ($survey_question_details->question_type==1 || $survey_question_details->question_type==2 || $survey_question_details->question_type==7)){?>
	<div class="modal-footer">
 		 		
		<div style="text-align:left;">
		
				<?php if(count($skip_logic_conditions_details)>0){ ?>
				
					<div class="contenttitle2 nomargintop">
						<h3> Skip Logics</h3>
					</div>
				
				<?php foreach($skip_logic_conditions_details as $skip_conditions_details){
						$answer_label = get_answer_name_by_answer_id_h($skip_conditions_details->answer_id,$survey_question_details->question_type);
						if($skip_conditions_details->logic==0){
							$logic='Is Selected';
						}else if($skip_conditions_details->logic==1){
							$logic='Is Not Selected';
						}
					?>
					<div class="col-md-12">
					
						<h4 id="h_edit_skip_logic<?php echo $skip_conditions_details->id;?>">
							<i class="fa fa-angle-double-right" aria-hidden="true"></i> <b>Condition:</b> <?php echo $answer_label;?> <span><?php echo $logic;?></span> <b>Skip To:</b> <?php if($skip_conditions_details->skip_status==0){echo 'End of Survey';}else{ 
							$skip_question_details = get_survey_question_fulldetails_h($skip_conditions_details->skip_to);
							  echo 'Q'.$skip_question_details->priority;?> - <?php echo $skip_question_details->question_title;
							}?>
							
							<a style="font-size:16px; padding:0 5px; color:#3c763d" onclick="return edit_skip_logic_condition('<?php echo $survey_id;?>','<?php echo $skip_conditions_details->id;?>','<?php echo $survey_question_details->question_id;?>','<?php echo $survey_question_details->question_type;?>','<?php echo $survey_question_details->priority;?>');"><i class="fa fa-pencil" aria-hidden="true"></i></a>
							<a style="font-size:16px; padding:0 5px; color:#a94442" href="<?php echo base_url();?>survey/delete_skip_logic_condition?id=<?php echo $skip_conditions_details->id;?>&survey_id=<?php echo $survey_id;?>" onclick="return confirm('Are you sure you want to delete this skip condition?');"><i class="fa fa-trash" aria-hidden="true"></i></a>
							
						</h4>
					
 					</div>
					<?php } ?>
				<?php } ?>
				
				<div id="new_skip_conditions"></div>
 		
		</div>
		<button type="button" class="btn btn-primary" style="padding:4px 15px; font-size:15px;" onclick="return add_skip_logic('<?php echo $survey_id;?>','<?php echo $survey_question_details->question_id;?>','<?php echo $survey_question_details->question_type;?>','<?php echo $survey_question_details->priority;?>');"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Skip Logic...</button>
        
     </div>
	 <?php } ?>
	 
</div>
</div>