<div class="row survey_results"> 
<script src="<?php echo base_url();?>assets/frontend/js/canvasjs.min.js"></script>		
<?php if(count($tests_questions_detail)>0){?>

		<div class="col-md-3 result_left_side" >
		
			<?php $i=1; foreach($tests_questions_detail as $questions_details){ ?>
					
				<a href="<?php echo base_url();?>department/create/tests/management?tab_id=7&test_id=<?php echo $_GET['test_id'];?>&dept_id=<?php echo $_GET['dept_id'];?>&view_result=item_analysis&question_id=<?php echo $questions_details->question_id;?>&ques_type=<?php echo $questions_details->question_type;?>">
					<div class="col-md-12 left_side_que <?php if(isset($_GET['question_id']) && $_GET['question_id']==$questions_details->question_id){ echo 'que_selected';}?>">
						<h4><?php echo 'Q'.$i.' - '.ucfirst($questions_details->question_title); ?></h4>
					</div>
				</a>
				
			<?php $i++; } ?>
		
		</div>
		<div class="col-md-9 result_right_side">
		<?php if(isset($_GET['question_id']) && $_GET['question_id']!=''){
		
		$question_id=$_GET['question_id']; 
		
		$question_fulldetails = get_test_question_fulldetails_h($question_id);
		
		?>
		 		<h4 align="center">Q<?php if(isset($question_fulldetails->priority) && $question_fulldetails->priority>0){ echo $question_fulldetails->priority;}?> - <?php echo $question_fulldetails->question_title;?></h4>
			<?php 
				
 					if(isset($question_fulldetails->question_type) && $question_fulldetails->question_type==1){ 

						$get_choics	= get_choics_of_multiple_type_question_tests($question_fulldetails->question_id); 
 
				if(isset($test_details->test_type)&& $test_details->test_type==1){

  						$pre_all_choice_count = get_all_choice_test_result_count_by_pslo_question_id_h($question_fulldetails->question_id,'1');	
						$post_all_choice_count = get_all_choice_test_result_count_by_pslo_question_id_h($question_fulldetails->question_id,'2');				
						
 		?>
				
<button class="btn btn-primary pull-right" onclick="return download_res_tbl();" style="margin-bottom:10px; ">Download as Image</button>
<table class="table table-hover table-bordered table-striped" id="test_section_tbl">
	<thead>
		<tr class="trbg"> 
			<th colspan="5" style="vertical-align:middle;" nowrap="nowrap"><?php echo $question_fulldetails->question_title;	?></th>
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
		
			$pre_choice_count = get_choice_test_result_count_by_plos_answer_choice_id_h($choics->answer_id,$question_fulldetails->question_id,'1');
						
			if($pre_all_choice_count>0){
				$pre_percentage = round(($pre_choice_count*100)/$pre_all_choice_count,2);
			}else{
				$pre_percentage = 0;
			}
			
			$post_choice_count = get_choice_test_result_count_by_plos_answer_choice_id_h($choics->answer_id,$question_fulldetails->question_id,'2');
						
			if($post_all_choice_count>0){
				$post_percentage = round(($post_choice_count*100)/$post_all_choice_count,2);
			}else{
				$post_percentage = 0;
			}
			?>
			<tr>
				<td rowspan="2" style="vertical-align:middle; font-weight:600;"><?php echo ucfirst($choics->answer_choice); if(isset($question_fulldetails->correct_answer) && $question_fulldetails->correct_answer==$choics->answer_id){?> <i class="fa fa-star" aria-hidden="true" style="color:#485b79; margin-left:5px;"></i> <?php } ?> </td>
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
		
			$one_time_all_choice_count = get_all_choice_test_result_count_by_pslo_question_id_h($question_fulldetails->question_id,'3');	
			
			 ?>
		
<button class="btn btn-primary pull-right" onclick="return download_res_tbl();" style="margin-bottom:10px; ">Download as Image</button>
<table class="table table-hover table-bordered table-striped" id="test_section_tbl">
	<thead>
		<tr class="trbg"> 
			<th colspan="4" style="vertical-align:middle;" nowrap="nowrap"><?php echo $i.'. '.$question_fulldetails->question_title;	?></th>
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
		
			$one_time_choice_count = get_choice_test_result_count_by_plos_answer_choice_id_h($choics->answer_id,$question_fulldetails->question_id,'3');
						
			if($one_time_all_choice_count>0){
				$one_time_percentage = round(($one_time_choice_count*100)/$one_time_all_choice_count,2);
			}else{
				$one_time_percentage = 0;
			}
			
			
			?>
			<tr>
				<td style="vertical-align:middle; font-weight:600;"><?php echo ucfirst($choics->answer_choice); if(isset($question_fulldetails->correct_answer) && $question_fulldetails->correct_answer==$choics->answer_id){?> <i class="fa fa-star" aria-hidden="true" style="color:#485b79; margin-left:5px;"></i> <?php } ?> </td>
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
		
			<?php  } else if(isset($question_fulldetails->question_type) && $question_fulldetails->question_type==3){ 
			
			
			if(isset($test_details->test_type)&& $test_details->test_type==1){
			
			?>
				
<button class="btn btn-primary pull-right" onclick="return download_res_tbl();" style="margin-bottom:10px; ">Download as Image</button>
<table class="table table-hover table-bordered table-striped" id="test_section_tbl">
	<thead>
		<tr class="trbg"> 
			<th colspan="3"><h4 class="nfw600">Q. <?php echo $question_fulldetails->question_title;?></h4></th>
		</tr>
		<tr> 
			<th>Participants Answer</th>
			<th>Pre Test Reponses</th>
			<th>Post Test Reponses</th>
		</tr>
	</thead>
 	<tbody>
	<?php 
		if(count($tests_email_detail)>0){
			foreach($tests_email_detail as $authcode_details){
			
				$auth_code = $authcode_details->auth_code;
				$pre_answer = get_all_item_test_textbox_answer_listing_h($_GET['test_id'],$question_fulldetails->question_id,$auth_code,'1');
				$post_answer = get_all_item_test_textbox_answer_listing_h($_GET['test_id'],$question_fulldetails->question_id,$auth_code,'2');
	?>
		<tr>
			<td><span class="nfw600"><?php echo $auth_code;if(isset($authcode_details->first_name)&& $authcode_details->first_name!=''){ echo ' / '.$authcode_details->first_name.' '.$authcode_details->last_name;}?></span></td>
			<td><?php echo $pre_answer;?></td>
			<td><?php echo $post_answer;?></td>
		</tr>	
	<?php } }else{ ?>
		<tr>
			<td>-- no answer available --</td>
		</tr>
	<?php } ?>
	
	</tbody>
</table>
			<?php }else{ ?>
			
<button class="btn btn-primary pull-right" onclick="return download_res_tbl();" style="margin-bottom:10px; ">Download as Image</button>
<table class="table table-hover table-bordered table-striped" id="test_section_tbl">
	<thead>
		<tr class="trbg"> 
			<th><h4 class="nfw600">Q. <?php echo $question_fulldetails->question_title;?></h4></th>
		</tr>
	</thead>
 	<tbody>
	<?php 
		if(count($tests_email_detail)>0){
			foreach($tests_email_detail as $authcode_details){
			
				$auth_code = $authcode_details->auth_code;
				$onetime_answer = get_all_test_authcode_textbox_answer_listing_h($_GET['test_id'],$question_fulldetails->question_id,$auth_code,'3');
	?>
		<tr>
			<td><span class="nfw600"><?php echo 'Ans '.$auth_code;
			if(isset($authcode_details->first_name)&& $authcode_details->first_name!=''){ echo ' / '.$authcode_details->first_name.' '.$authcode_details->last_name;}
			echo ' - ';?></span><?php echo $onetime_answer;?></td>
		</tr>	
	<?php } }else{ ?>
		<tr>
			<td>-- no answer available --</td>
		</tr>
	<?php } ?>
	
	</tbody>
</table>			
			
			<?php } ?>	
			
			<?php } ?>
			
		<?php }  ?>	
		
	</div>	
	
	<?php }  ?>	
</div>