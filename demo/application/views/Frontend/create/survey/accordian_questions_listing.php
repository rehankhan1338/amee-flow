<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>

<link rel="stylesheet" href="<?php echo base_url();?>/assets/frontend/dynamic_drag_drop/css/style.css" />
<script type="text/javascript">
	jQuery(function() {
    jQuery('#sortable').sortable({
        axis: 'y',
        opacity: 0.7,
        handle: 'span',
        update: function(event, ui) {
            var list_sortable = jQuery(this).sortable('toArray').toString();
    		// change order in the database using Ajax
    		jQuery.ajax({
                url: '<?php echo base_url();?>survey/set_order_questions',
                type: 'POST',
                data: {list_order:list_sortable},
                success: function(data) {
                	var redirect_url = '<?php echo $actual_link; ?>';  
                	jQuery(location).attr('href',redirect_url);
                	
                }
            });
        }
    }); // fin sortable
});
</script>

<div id="survey_questions" class="subcontent margin20">
<div class="col-md-123">
	<div class="contenttitle2 nomargintop">
		<h3> Survey Questions</h3>
	</div>

	<div class="pull-right">
		<a class="btn btn-warning" style="padding:3px 7px; font-size:15px;" href="<?php echo base_url();?>department/create/survey/templates/<?php echo $survey_details->survey_id;?>"><i class="fa fa-university" aria-hidden="true"></i> Survey Templates </a>
		<a class="btn btn-default" href="<?php echo base_url();?>department/create/survey/question/add/<?php echo $survey_details->survey_id;?>" style="padding:3px 7px; font-size:15px;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Question</a>
	</div>

	<div class="clearfix"></div>
	<ul id="sortable">
	<?php if(count($survey_questions_details)>0){
		$k=1; foreach($survey_questions_details as $questions_details){?>		
		
	<li id="<?php echo $questions_details->question_id;?>">
	<span></span>
		<div class="bs-example">
		<div class="panel-group" id="accordion_<?php echo $questions_details->question_id; ?>">
		<div class="panel panel-default" style="background: #ddd;">
			<div class="panel-heading" style="background: #ddd;">
				<h4 class="panel-title">
				    <a data-toggle="collapse" data-parent="#accordion_<?php echo $questions_details->question_id; ?>" href="#collapse_<?php echo $questions_details->question_id; ?>"><?php if(isset($questions_details->question_title) && $questions_details->question_title!=''){echo 'Q'.$k.'. '.ucfirst($questions_details->question_title);}?> 
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
			<div class="panel-body" style="padding-left:50px; background: #ffff;" >
				<?php if(isset($questions_details->question_type) && $questions_details->question_type==1){ 				

					$get_choics	= get_choics_of_multiple_type_question($questions_details->question_id);

				?><ul><?php
					foreach($get_choics as $choics){?>			

						<li><?php echo $choics->answer_choice ;?></li>
				<?php } ?></ul>
				<?php }?>


				<?php if(isset($questions_details->question_type) && $questions_details->question_type==2){ ?>
					<table class="matrix table">
						<thead>
						<tr class="append_matric_column">
							<td style="visibility:hidden;">Categories</td>

							<?php $get_column = get_choics_of_multiple_column($questions_details->question_id);
								foreach($get_column as $column){?>
									<td class="matrix_column td_matrix_column_1" style="font-weight:600;"><?php echo $column->choices; ?></td>
							<?php } ?>
						</tr>
						</thead>
 						<tbody>
							<?php $get_rows	= get_choics_of_multiple_rows($questions_details->question_id);
								foreach($get_rows as $rows){?>
									<tr class="matrix_row div_statement_1" style="border-top:1px solid #dedede;">	
										<td style="font-weight:600;"><?php echo $rows->choices; ?></td>

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
	</li>
	<?php $k++;} } ?>
	</ul>
</div>
</div>













