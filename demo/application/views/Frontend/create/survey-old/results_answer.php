<?php include(APPPATH.'views/Frontend/create/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<div class="survey_heading">
	<h3> 
		<?php if(isset($survey_details->survey_name)&& $survey_details->survey_name!=''){
			echo $survey_details->survey_name;};?>
	</h3>
</div>

<!--<div class="btn_div pull-right" style="margin-top:-52px;">
</div>-->

<link rel="stylesheet" href="<?php echo base_url();?>/assets/frontend/dynamic_drag_drop/css/style.css" />
<style type="text/css">
.que_hover:hover{ text-decoration:underline;}
</style>

<div id="test_questions" class="subcontent">
	<div class="col-md-123">
		<div class="contenttitle2 nomargintop">
			<h3> Survey Questions</h3>
		</div>	 

		<div class="clearfix"></div>
		<ul id="sortable" class="sortable_drag" style="padding: 20px 10px!important;">
		<?php if(count($surveys_questions_detail)>0){
			$j=1; foreach($surveys_questions_detail as $questions_detail){?>
			
			<li>
			<h4>
			<a class="que_hover">
				
				<?php if(isset($questions_detail->question_title) && $questions_detail->question_title!=''){ echo 'Q'.$j.'. '.ucfirst($questions_detail->question_title);}?>		
				
				<p>
				<?php 				
					$question_id = $questions_detail->question_id;
					$question_type = $questions_detail->question_type;
					$survey_id = $questions_detail->survey_id;
					
					$survey_answers = get_survey_result_answers_detail($question_id,$question_type,$survey_id,$auth_code);
					 
					if(count($survey_answers)>0){
						foreach($survey_answers as $survey_result_details){
							
							if(isset($survey_result_details->is_matrix_question) && $survey_result_details->is_matrix_question==0){
														 
							 	if($question_type==3 || $question_type==4){
								
									echo $answer_name = $survey_result_details->answer;	
													
								}else if($question_type==1){
								
									$answer_name = get_answer_name_by_answer_id_h($survey_result_details->answer,$question_type);
									echo $answer_name; 									
								}
								
 							}else{
							
								$row_name = get_matrix_choics_name_by_choice_id_h($survey_result_details->row_id);
								$coulmn_name = get_matrix_choics_name_by_choice_id_h(get_survey_matrix_answers_detail($survey_id, $auth_code, $question_id, $survey_result_details->row_id));
								echo $row_name.' - '.$coulmn_name;
								echo '<br>';						
							}					
						}					
					}				
				?>					
				</p>
			</a>
			</h4>
			</li>
		<?php $j++;} }?>		 
		</ul>
	</div>
</div>