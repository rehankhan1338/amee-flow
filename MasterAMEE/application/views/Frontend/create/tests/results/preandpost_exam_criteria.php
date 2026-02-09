<?php $criterion_details = get_test_criteion_details_h($test_details->test_id);

 if(isset($test_details->test_type)&& $test_details->test_type==1){
 
?> 
<?php if(isset($test_details->self_rating)&& $test_details->self_rating==0){?>
<button class="btn btn-primary pull-right" onclick="return download_res_tbl();" style="margin-bottom:10px; margin-top:-50px;">Download as Image</button>
<table class="table table-hover table-bordered table-striped" id="test_section_tbl">
	<thead>
		<tr class="trbg"> 
			<th rowspan="2" style="vertical-align:top;" nowrap="nowrap">Exam Score Criteria</th>
			<th colspan="2" style="vertical-align:middle; text-align:center;" nowrap="nowrap">Pre Score Results</th>
			<th colspan="2" style="vertical-align:middle; text-align:center;" nowrap="nowrap">Post Score Results</th>
		</tr>
		<tr class="trbg"> 
			<th style="vertical-align:middle;" nowrap="nowrap">Count</th>
			<th style="vertical-align:middle;" nowrap="nowrap">Percentage</th>
			<th style="vertical-align:middle;" nowrap="nowrap">Count</th>
			<th style="vertical-align:middle;" nowrap="nowrap">Percentage</th>
		</tr>
	</thead>
	<tbody>
 	
		<tr>
  			<td style="font-weight:600;vertical-align:middle;"><?php echo $criterion_details->oprf_column_1.' - '.$criterion_details->oprf_column_sec_1.'&nbsp;&nbsp;&nbsp;'.$criterion_details->range_name_column_1;?></td>		
			<td>
			<?php echo $pre_exam_score = get_test_total_score_according_to_criteria_h($test_details->test_id,'1','1');
			//get_test_total_score_according_to_criteria_h($test_details->test_id,'1',$criterion_details->oprf_column_1,$criterion_details->oprf_column_sec_1);?>
			</td>
			<td>
			<?php $pre_percentage = round(($pre_exam_score*100)/5,2);?>
 			<div class="progress">
			  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $pre_percentage;?>%" aria-valuenow="<?php echo $pre_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $pre_percentage;?>%</div>
			</div>
			</td>
			<td>
			<?php echo $post_exam_score = get_test_total_score_according_to_criteria_h($test_details->test_id,'2','1');
			
			//get_test_total_score_according_to_criteria_h($test_details->test_id,'2',$criterion_details->oprf_column_1,$criterion_details->oprf_column_sec_1);?>
			</td>
			<td>
			<?php $post_percentage = round(($post_exam_score*100)/5,2);?>
 			<div class="progress">
			  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $post_percentage;?>%" aria-valuenow="<?php echo $post_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $post_percentage;?>%</div>
			</div>
			</td>
 		</tr>
		
		<tr>
  			<td style="font-weight:600;vertical-align:middle;"><?php echo $criterion_details->oprf_column_2.' - '.$criterion_details->oprf_column_sec_2.'&nbsp;&nbsp;&nbsp;'.$criterion_details->range_name_column_2;?></td>		
			<td><?php echo $pre_exam_score = get_test_total_score_according_to_criteria_h($test_details->test_id,'1','2');
			//get_test_total_score_according_to_criteria_h($test_details->test_id,'1',$criterion_details->oprf_column_2,$criterion_details->oprf_column_sec_2);?>
			</td>
			<td>
			<?php $pre_percentage = round(($pre_exam_score*100)/5,2);?>
 			<div class="progress">
			  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $pre_percentage;?>%" aria-valuenow="<?php echo $pre_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $pre_percentage;?>%</div>
			</div>
			</td>
			<td>
			<?php echo $post_exam_score = get_test_total_score_according_to_criteria_h($test_details->test_id,'2','2');
			//get_test_total_score_according_to_criteria_h($test_details->test_id,'2',$criterion_details->oprf_column_2,$criterion_details->oprf_column_sec_2);?>
			</td>
			<td>
			<?php $post_percentage = round(($post_exam_score*100)/5,2);?>
 			<div class="progress">
			  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $post_percentage;?>%" aria-valuenow="<?php echo $post_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $post_percentage;?>%</div>
			</div>
			</td>
 		</tr>
		
		<tr>
  			<td style="font-weight:600;vertical-align:middle;"><?php echo $criterion_details->oprf_column_3.' - '.$criterion_details->oprf_column_sec_3.'&nbsp;&nbsp;&nbsp;'.$criterion_details->range_name_column_3;?></td>		
			<td><?php echo $pre_exam_score = get_test_total_score_according_to_criteria_h($test_details->test_id,'1','3');
			//get_test_total_score_according_to_criteria_h($test_details->test_id,'1',$criterion_details->oprf_column_3,$criterion_details->oprf_column_sec_3);?>
			</td>
			<td>
			<?php $pre_percentage = round(($pre_exam_score*100)/5,2);?>
 			<div class="progress">
			  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $pre_percentage;?>%" aria-valuenow="<?php echo $pre_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $pre_percentage;?>%</div>
			</div>
			</td>
			<td>
			<?php echo $post_exam_score = get_test_total_score_according_to_criteria_h($test_details->test_id,'2','3');
			//get_test_total_score_according_to_criteria_h($test_details->test_id,'2',$criterion_details->oprf_column_3,$criterion_details->oprf_column_sec_3);?>
			</td>
			<td>
			<?php $post_percentage = round(($post_exam_score*100)/5,2);?>
 			<div class="progress">
			  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $post_percentage;?>%" aria-valuenow="<?php echo $post_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $post_percentage;?>%</div>
			</div>
			</td>
 		</tr>
		<?php if(isset($criterion_details->range_name_column_4) && $criterion_details->range_name_column_4!=''){?>
		<tr>
  			<td style="font-weight:600;vertical-align:middle;"><?php echo $criterion_details->oprf_column_4.' - '.$criterion_details->oprf_column_sec_4.'&nbsp;&nbsp;&nbsp;'.$criterion_details->range_name_column_4;?></td>		
			<td><?php echo $pre_exam_score = get_test_total_score_according_to_criteria_h($test_details->test_id,'1','4');
			//get_test_total_score_according_to_criteria_h($test_details->test_id,'1',$criterion_details->oprf_column_4,$criterion_details->oprf_column_sec_4);?>
			</td>
			<td>
			<?php $pre_percentage = round(($pre_exam_score*100)/5,2);?>
 			<div class="progress">
			  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $pre_percentage;?>%" aria-valuenow="<?php echo $pre_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $pre_percentage;?>%</div>
			</div>
			</td>
			<td>
			<?php echo $post_exam_score = get_test_total_score_according_to_criteria_h($test_details->test_id,'2','4');
			//get_test_total_score_according_to_criteria_h($test_details->test_id,'2',$criterion_details->oprf_column_4,$criterion_details->oprf_column_sec_4);?>
			</td>
			<td>
			<?php $post_percentage = round(($post_exam_score*100)/5,2);?>
 			<div class="progress">
			  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $post_percentage;?>%" aria-valuenow="<?php echo $post_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $post_percentage;?>%</div>
			</div>
			</td>
 		</tr>
		<?php } if(isset($criterion_details->range_name_column_5) && $criterion_details->range_name_column_5!=''){?>
		<tr>
  			<td style="font-weight:600;vertical-align:middle;"><?php echo $criterion_details->oprf_column_5.' - '.$criterion_details->oprf_column_sec_5.'&nbsp;&nbsp;&nbsp;'.$criterion_details->range_name_column_5;?></td>		
			<td><?php echo $pre_exam_score = get_test_total_score_according_to_criteria_h($test_details->test_id,'1','5');
			//get_test_total_score_according_to_criteria_h($test_details->test_id,'1',$criterion_details->oprf_column_5,$criterion_details->oprf_column_sec_5);?>
			</td>
			<td>
			<?php $pre_percentage = round(($pre_exam_score*100)/5,2);?>
 			<div class="progress">
			  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $pre_percentage;?>%" aria-valuenow="<?php echo $pre_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $pre_percentage;?>%</div>
			</div>
			</td>
			<td>
			<?php echo $post_exam_score = get_test_total_score_according_to_criteria_h($test_details->test_id,'2','5');
			//get_test_total_score_according_to_criteria_h($test_details->test_id,'2',$criterion_details->oprf_column_5,$criterion_details->oprf_column_sec_5);?>
			</td>
			<td>
			<?php $post_percentage = round(($post_exam_score*100)/5,2);?>
 			<div class="progress">
			  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $post_percentage;?>%" aria-valuenow="<?php echo $post_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $post_percentage;?>%</div>
			</div>
			</td>
 		</tr>
		<?php } ?>
	</tbody>
</table>
<?php }else{ ?><div class="col-md-12 instructions"><strong>Note:</strong> Self Rating is inactive for this test.</div> <?php } ?>
<?php }else{?>

<?php if(isset($test_details->self_rating)&& $test_details->self_rating==0){?>	

<button class="btn btn-primary pull-right" onclick="return download_res_tbl();" style="margin-bottom:10px; margin-top:-50px;">Download as Image</button>
<table class="table table-hover table-bordered table-striped" id="test_section_tbl">
	<thead>
		<tr class="trbg"> 
			<th style="vertical-align:top;" nowrap="nowrap">Exam Score Criteria</th>
			<th style="vertical-align:middle;" nowrap="nowrap">Count</th>
			<th style="vertical-align:middle;" nowrap="nowrap">Percentage</th>
		</tr>
	</thead>
	<tbody>
 	
		<tr>
  			<td style="font-weight:600;vertical-align:middle;"><?php echo $criterion_details->oprf_column_1.' - '.$criterion_details->oprf_column_sec_1.'&nbsp;&nbsp;&nbsp;'.$criterion_details->range_name_column_1;?></td>		
			<td>
			<?php echo $one_time_exam_score = get_test_total_score_according_to_criteria_h($test_details->test_id,'3','1');
			//get_test_total_score_according_to_criteria_h($test_details->test_id,'3',$criterion_details->oprf_column_1,$criterion_details->oprf_column_sec_1);?>
			</td>
			<td>
			<?php $one_time_percentage = round(($one_time_exam_score*100)/5,2);?>
 			<div class="progress">
			  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $one_time_percentage;?>%" aria-valuenow="<?php echo $one_time_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $one_time_percentage;?>%</div>
			</div>
			</td>
 		</tr>
		
		<tr>
  			<td style="font-weight:600;vertical-align:middle;"><?php echo $criterion_details->oprf_column_2.' - '.$criterion_details->oprf_column_sec_2.'&nbsp;&nbsp;&nbsp;'.$criterion_details->range_name_column_2;?></td>		
			<td><?php echo $one_time_exam_score = get_test_total_score_according_to_criteria_h($test_details->test_id,'3','2');
			//get_test_total_score_according_to_criteria_h($test_details->test_id,'3',$criterion_details->oprf_column_2,$criterion_details->oprf_column_sec_2);?>
			</td>
			<td>
			<?php $one_time_percentage = round(($one_time_exam_score*100)/5,2);?>
 			<div class="progress">
			  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $one_time_percentage;?>%" aria-valuenow="<?php echo $one_time_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $one_time_percentage;?>%</div>
			</div>
			</td>			
 		</tr>
		
		<tr>
  			<td style="font-weight:600;vertical-align:middle;"><?php echo $criterion_details->oprf_column_3.' - '.$criterion_details->oprf_column_sec_3.'&nbsp;&nbsp;&nbsp;'.$criterion_details->range_name_column_3;?></td>		
			<td><?php echo $one_time_exam_score = get_test_total_score_according_to_criteria_h($test_details->test_id,'3','3');
			//get_test_total_score_according_to_criteria_h($test_details->test_id,'3',$criterion_details->oprf_column_3,$criterion_details->oprf_column_sec_3);?>
			</td>
			<td>
			<?php $one_time_percentage = round(($one_time_exam_score*100)/5,2);?>
 			<div class="progress">
			  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $one_time_percentage;?>%" aria-valuenow="<?php echo $one_time_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $one_time_percentage;?>%</div>
			</div>
			</td>			
 		</tr>
		<?php  if(isset($criterion_details->range_name_column_4) && $criterion_details->range_name_column_4!=''){?>
		<tr>
  			<td style="font-weight:600;vertical-align:middle;"><?php echo $criterion_details->oprf_column_4.' - '.$criterion_details->oprf_column_sec_4.'&nbsp;&nbsp;&nbsp;'.$criterion_details->range_name_column_4;?></td>		
			<td><?php echo $one_time_exam_score = get_test_total_score_according_to_criteria_h($test_details->test_id,'3','4');
			//get_test_total_score_according_to_criteria_h($test_details->test_id,'3',$criterion_details->oprf_column_4,$criterion_details->oprf_column_sec_4);?>
			</td>
			<td>
			<?php $one_time_percentage = round(($one_time_exam_score*100)/5,2);?>
 			<div class="progress">
			  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $one_time_percentage;?>%" aria-valuenow="<?php echo $one_time_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $one_time_percentage;?>%</div>
			</div>
			</td>
 		</tr>
		<?php } if(isset($criterion_details->range_name_column_5) && $criterion_details->range_name_column_5!=''){?>
		<tr>
  			<td style="font-weight:600;vertical-align:middle;"><?php echo $criterion_details->oprf_column_5.' - '.$criterion_details->oprf_column_sec_5.'&nbsp;&nbsp;&nbsp;'.$criterion_details->range_name_column_5;?></td>		
			<td><?php echo $one_time_exam_score = get_test_total_score_according_to_criteria_h($test_details->test_id,'3','5');
			//get_test_total_score_according_to_criteria_h($test_details->test_id,'3',$criterion_details->oprf_column_5,$criterion_details->oprf_column_sec_5);?>
			</td>
			<td>
			<?php $one_time_percentage = round(($one_time_exam_score*100)/5,2);?>
 			<div class="progress">
			  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php echo $one_time_percentage;?>%" aria-valuenow="<?php echo $one_time_percentage;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $one_time_percentage;?>%</div>
			</div>
			</td>
 		</tr>
		<?php } ?>
	</tbody>
</table>
<?php }else{ ?><div class="col-md-12 instructions"><strong>Note:</strong> Self Rating is inactive for this test.</div> <?php } ?>

<?php } ?>