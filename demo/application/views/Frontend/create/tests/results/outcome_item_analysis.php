<div class="row survey_results"> 
<script src="<?php echo base_url();?>assets/frontend/js/canvasjs.min.js"></script>		
<?php if(isset($learning_outcomes_listing_question_present) && $learning_outcomes_listing_question_present!=''){?>

		<div class="col-md-3 result_left_side" >
		
			<?php $learning_outcomes = explode(',',$learning_outcomes_listing_question_present);
					for($ios=0;$ios<count($learning_outcomes);$ios++){ ?>
					
				<a href="<?php echo base_url();?>department/create/tests/management?tab_id=7&test_id=<?php echo $_GET['test_id'];?>&dept_id=<?php echo $_GET['dept_id'];?>&view_result=outcome_item_analysis&plos_id=<?php echo $learning_outcomes[$ios];?>">
					<div class="col-md-12 left_side_que <?php if(isset($_GET['plos_id']) && $_GET['plos_id']==$learning_outcomes[$ios]){ echo 'que_selected';}?>">
						<h4>
							<?php  
							$learning_outcome_details = get_test_learning_outcome_full_details_h($learning_outcomes[$ios]);
							echo $learning_outcome_details->plso_prefix.' - '.$learning_outcome_details->plso_title;
							?>
						</h4>
					</div>
				</a>
				
			<?php  }  ?>
		
		</div>
		<div class="col-md-9 result_right_side">
		<?php if(isset($_GET['plos_id']) && $_GET['plos_id']!=''){?>
		 		<h4 align="center"><?php
				$learning_outcome_details = get_test_learning_outcome_full_details_h($_GET['plos_id']);
							echo $learning_outcome_details->plso_prefix.' - '.$learning_outcome_details->plso_title;
				?></h4>
			<?php 
				
			if(count($test_plos_questions_listing)>0){
				
			$i=1; foreach($test_plos_questions_listing as $plos_question_details)	{
					
					if(isset($plos_question_details->question_type) && $plos_question_details->question_type==1){ 

						$get_choics	= get_choics_of_multiple_type_question_tests($plos_question_details->question_id); 


				if(isset($test_details->test_type)&& $test_details->test_type==1){

  						$pre_all_choice_count = get_all_choice_test_result_count_by_pslo_question_id_h($plos_question_details->question_id,'1');	
						$post_all_choice_count = get_all_choice_test_result_count_by_pslo_question_id_h($plos_question_details->question_id,'2');				
						
 		?>
				
<button class="btn btn-primary pull-right" onclick="return download_res_tbl();" style="margin-bottom:10px; ">Download as Image</button>
<table class="table table-hover table-bordered table-striped" id="test_section_tbl">
	<thead>
		<tr class="trbg"> 
			<th colspan="5" style="vertical-align:middle;" nowrap="nowrap"><?php echo $i.'. '.$plos_question_details->question_title;	?></th>
		</tr>
		<tr class="">
 			<th style="vertical-align:middle;" nowrap="nowrap">Response</th>
			<th style="vertical-align:middle;" nowrap="nowrap">Test Type</th>
			<th style="vertical-align:middle;" nowrap="nowrap">Percentage</th>
			<th style="vertical-align:middle;" nowrap="nowrap">Frequency</th>
			<th style="vertical-align:middle;">Count</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($get_choics as $choics){
		
			$pre_choice_count = get_choice_test_result_count_by_plos_answer_choice_id_h($choics->answer_id,$plos_question_details->question_id,'1');
						
			if($pre_all_choice_count>0){
				$pre_percentage = round(($pre_choice_count*100)/$pre_all_choice_count,2);
			}else{
				$pre_percentage = 0;
			}
			
			$post_choice_count = get_choice_test_result_count_by_plos_answer_choice_id_h($choics->answer_id,$plos_question_details->question_id,'2');
						
			if($post_all_choice_count>0){
				$post_percentage = round(($post_choice_count*100)/$post_all_choice_count,2);
			}else{
				$post_percentage = 0;
			}
			?>
			<tr>
				<td rowspan="2" style="vertical-align:middle; font-weight:600;"><?php echo ucfirst($choics->answer_choice); if(isset($plos_question_details->correct_answer) && $plos_question_details->correct_answer==$choics->answer_id){?> <i class="fa fa-star" aria-hidden="true" style="color:#485b79; margin-left:5px;"></i> <?php } ?> </td>
				<td>Pre</td>
				<td>
				<div class="progress">
				  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $pre_percentage;?>%" aria-valuenow="<?php echo $pre_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $pre_percentage;?>%</div>
				</div>
				</td>
				<td><?php echo round($pre_percentage,2);?>%</td>
				<td><?php echo $pre_choice_count;?></td>
				
  			</tr>
			<tr>
				 <td>Post</td>
				<td>
				<div class="progress">
				  <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: <?php echo $post_percentage;?>%" aria-valuenow="<?php echo $post_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $post_percentage;?>%</div>
				</div>
				</td>
				<td><?php echo round($post_percentage,2);?>%</td>
				<td><?php echo $post_choice_count;?></td>
				
  			</tr>
		<?php } ?>
	</tbody>
</table>
			
		<?php }else{
		
			$one_time_all_choice_count = get_all_choice_test_result_count_by_pslo_question_id_h($plos_question_details->question_id,'3');	
			
			 ?>
		
		<button class="btn btn-primary pull-right" onclick="return download_res_tbl();" style="margin-bottom:10px; ">Download as Image</button>
<table class="table table-hover table-bordered table-striped" id="test_section_tbl">
	<thead>
		<tr class="trbg"> 
			<th colspan="4" style="vertical-align:middle;" nowrap="nowrap"><?php echo $i.'. '.$plos_question_details->question_title;	?></th>
		</tr>
		<tr class="">
 			<th style="vertical-align:middle;" nowrap="nowrap">Response</th>
			<th style="vertical-align:middle;" nowrap="nowrap">Percentage</th>
			<th style="vertical-align:middle;" nowrap="nowrap">Frequency</th>
			<th style="vertical-align:middle;">Count</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($get_choics as $choics){
		
			$one_time_choice_count = get_choice_test_result_count_by_plos_answer_choice_id_h($choics->answer_id,$plos_question_details->question_id,'3');
						
			if($one_time_all_choice_count>0){
				$one_time_percentage = round(($one_time_choice_count*100)/$one_time_all_choice_count,2);
			}else{
				$one_time_percentage = 0;
			}
			
			
			?>
			<tr>
				<td style="vertical-align:middle; font-weight:600;"><?php echo ucfirst($choics->answer_choice); if(isset($plos_question_details->correct_answer) && $plos_question_details->correct_answer==$choics->answer_id){?> <i class="fa fa-star" aria-hidden="true" style="color:#485b79; margin-left:5px;"></i> <?php } ?> </td>
				<td>
				<div class="progress">
				  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $one_time_percentage;?>%" aria-valuenow="<?php echo $one_time_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $one_time_percentage;?>%</div>
				</div>
				</td>
				<td><?php echo round($one_time_percentage,2);?>%</td>
				<td><?php echo $one_time_choice_count;?></td>
				
  			</tr>
			
		<?php } ?>
	</tbody>
</table>
		
		
		<?php } ?>
			
			
			
				
				<?php 
				}	
				$i++;} 
				
				
			}
			?>
 <?php }  ?>	
		</div>	
		<?php }  ?>	
</div>