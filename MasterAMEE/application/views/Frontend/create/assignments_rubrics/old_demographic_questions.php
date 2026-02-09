<div id="survey_questions" class="subcontent margin20">
<div class="col-md-123">
	<div class="contenttitle2 nomargintop">
		<h3> Demograpic Questions</h3>
	</div>
	<div class="pull-right">
		
		<a class="btn btn-default" href="<?php echo base_url();?>department/create/assignments_rubrics/question/add/<?php echo $assignments_rubrics_row->id;?>" style="padding:3px 7px; font-size:15px;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Question</a>				
	
	</div>
	<div class="clearfix"></div>
	
	<?php if(count($assignments_rubrics_questions_detail)>0){ 
		$k=1; foreach($assignments_rubrics_questions_detail as $questions_details){?>
		
	<div class="bs-example">
	<div class="panel-group" id="accordion_<?php echo $questions_details->question_id; ?>">
	<div class="panel panel-default">
			  
		<div class="panel-heading">
			<h4 class="panel-title">
			<a data-toggle="collapse" data-parent="#accordion_<?php echo $questions_details->question_id; ?>" href="#collapse_<?php echo $questions_details->question_id; ?>"><?php if(isset($questions_details->question_title) && $questions_details->question_title!=''){echo ucfirst($questions_details->question_title);}?> 
			</a>
			</h4>
		</div>
		
		
		<div id="collapse_<?php echo $questions_details->question_id; ?>" class="panel-collapse collapse">
		<div class="panel-body" >
			<?php if(isset($questions_details->question_type) && $questions_details->question_type==1){ 
				
				$get_choics	= get_choics_of_multiple_type_question_rubrics($questions_details->question_id);

				foreach($get_choics as $choics){?>
				
					<p><?php echo $choics->answer_choice ;?></p>

			<?php } }?>
		</div>
		</div>
		
		
	</div>
	</div>
	</div>
	<?php $k++;} } ?>
	
</div>
</div>