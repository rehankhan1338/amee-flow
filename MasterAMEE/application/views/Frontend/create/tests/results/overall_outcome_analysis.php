<button class="btn btn-primary pull-right" onclick="return download_res_tbl();" style="margin-bottom:10px; margin-top:-50px; ">Download as Image</button>
<?php if(isset($test_details->test_type) && $test_details->test_type==1){?>


<table class="table table-hover table-bordered table-striped" id="test_section_tbl">
	<thead>
		<tr class="trbg"> 
			<th rowspan="2" style="vertical-align:top">Learning Outcomes</th>
			<th colspan="2" style="text-align:center;" nowrap="nowrap">Pre Test</th>
			<th colspan="2" style="text-align:center;" nowrap="nowrap">Post Test</th>
		</tr>
		<tr class="trbg"> 
			<th nowrap="nowrap" width="13%">Item Correct</th>
			<th nowrap="nowrap" width="13%">Item Incorrect</th>
			<th nowrap="nowrap" width="13%">Item Correct</th>
			<th nowrap="nowrap" width="13%">Item Incorrect</th>
		</tr>
	</thead>
 	<tbody>
	<?php  
		
		if(isset($learning_outcomes_listing_question_present) && $learning_outcomes_listing_question_present!=''){
		
		$learning_outcomes = explode(',',$learning_outcomes_listing_question_present);
 			
			$pre_total_responses = get_total_student_gave_answer_h($test_details->test_id,'1');
			$post_total_responses = get_total_student_gave_answer_h($test_details->test_id,'2');
					
			for($ios=0;$ios<count($learning_outcomes);$ios++){ ?>
		<tr>
			<td>
			<?php
				if($learning_outcomes[$ios]!=''){  
				$learning_outcome_details = get_test_learning_outcome_full_details_h($learning_outcomes[$ios]);
				echo $learning_outcome_details->plso_prefix.' - '.$learning_outcome_details->plso_title;
				
				$question_assigned_ids = get_questions_id_test_outcomes_h($test_details->test_id,$learning_outcome_details->id);
				}
			?>
			</td>
			<td>
			<?php
     				
				if(isset($question_assigned_ids) && $question_assigned_ids!=''){
				
 					$pre_final_total_responses = $pre_total_responses*(count(explode(',',$question_assigned_ids)));
  					$pre_correct_answers_count = get_correct_answer_per_of_plso_h($question_assigned_ids,$test_details->test_id,'1');
					if(isset($pre_final_total_responses) && $pre_final_total_responses>0){
 						$pre_correct_percentage = round(($pre_correct_answers_count*100)/$pre_final_total_responses);
					}else{
						$pre_correct_percentage = 0;
					}	
					
					$post_final_total_responses = $post_total_responses*(count(explode(',',$question_assigned_ids)));
					$post_correct_answers_count = get_correct_answer_per_of_plso_h($question_assigned_ids,$test_details->test_id,'2');
					if(isset($post_final_total_responses) && $post_final_total_responses>0){
 						$post_correct_percentage = round(($post_correct_answers_count*100)/$post_final_total_responses);
					}else{
						$post_correct_percentage = 0;
					}
					
				}else{
				
					$pre_correct_percentage = 0;
					$post_correct_percentage = 0;
					
				}
				
				$pre_wrong_percentage = 100-$pre_correct_percentage;
				$post_wrong_percentage = 100-$post_correct_percentage;
			?>
				<div class="progress">
				  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $pre_correct_percentage;?>%" aria-valuenow="<?php echo $pre_correct_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $pre_correct_percentage;?>%</div>
				</div>
			</td>
			<td>
				<div class="progress">
				  <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: <?php echo $pre_wrong_percentage;?>%" aria-valuenow="<?php echo $pre_wrong_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $pre_wrong_percentage;?>%</div>
				</div>
				</td>
			<td>
				<?php if(isset($post_final_total_responses) && $post_final_total_responses>0){?>
				<div class="progress">
				  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $post_correct_percentage;?>%" aria-valuenow="<?php echo $post_correct_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $post_correct_percentage;?>%</div>
				</div>
				<?php }else{ echo '<span class="not_yet_gave">Not Yet</span>';}?>
				</td>
			<td>
				<?php if(isset($post_final_total_responses) && $post_final_total_responses>0){?>
				<div class="progress">
				  <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: <?php echo $post_wrong_percentage;?>%" aria-valuenow="<?php echo $post_wrong_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $post_wrong_percentage;?>%</div>
				</div>
				<?php }else{ echo '<span class="not_yet_gave">Not Yet</span>';}?> 
				</td>
		</tr>	
 
	<?php } } ?>
	
	</tbody>
</table>

<?php }else{ ?>

<table class="table table-hover table-bordered table-striped" id="test_section_tbl">
	<thead>
		<tr class="trbg"> 
			<th style="vertical-align:top">Learning Outcomes</th>
			<th nowrap="nowrap">Item Correct</th>
			<th nowrap="nowrap">Item Incorrect</th>
		</tr>
	</thead>
 	<tbody>
	<?php $learning_outcomes = explode(',',$learning_outcomes_listing_question_present);
	
			$one_time_total_responses = get_total_student_gave_answer_h($test_details->test_id,'3');
			
			if($one_time_total_responses>0){
					
			for($ios=0;$ios<count($learning_outcomes);$ios++){ ?>
		<tr>
			<td>
			<?php  
				$learning_outcome_details = get_test_learning_outcome_full_details_h($learning_outcomes[$ios]);
				echo $learning_outcome_details->plso_prefix.' - '.$learning_outcome_details->plso_title;
				
				$question_assigned_ids = get_questions_id_test_outcomes_h($test_details->test_id,$learning_outcome_details->id);
			?>
			</td>
			<td>
			<?php
     				
				if(isset($question_assigned_ids) && $question_assigned_ids!=''){
				
 					$one_time_final_total_responses = $one_time_total_responses*(count(explode(',',$question_assigned_ids)));
  					$one_time_correct_answers_count = get_correct_answer_per_of_plso_h($question_assigned_ids,$test_details->test_id,'3');
 					$one_time_correct_percentage = round(($one_time_correct_answers_count*100)/$one_time_final_total_responses);
					
				}else{
				
					$one_time_correct_percentage = 0;
					
				}
				
				$one_time_wrong_percentage = 100-$one_time_correct_percentage;
				
			?>
				<div class="progress">
				  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $one_time_correct_percentage;?>%" aria-valuenow="<?php echo $one_time_correct_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $one_time_correct_percentage;?>%</div>
				</div>
			</td>
			<td>
				<div class="progress">
				  <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: <?php echo $one_time_wrong_percentage;?>%" aria-valuenow="<?php echo $one_time_wrong_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $one_time_wrong_percentage;?>%</div>
				</div>
			</td>
		</tr>	
 
	<?php } } ?>
	
	</tbody>
</table>

<?php } ?>