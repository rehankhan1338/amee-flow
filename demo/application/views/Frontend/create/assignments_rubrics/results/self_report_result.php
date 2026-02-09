<div class="survey_results">
<?php $assingment_rubric_criterion_detail = get_assingment_rubric_criterion_listing_h($_GET['ar_id']);?>
<?php 
//$assingment_responses_count = get_assingment_responses_count($assignments_rubrics_row->id,$assignments_rubrics_row->department_id);
$assingment_responses_count = count($assignments_valid_user_result);?>
<button class="btn btn-primary pull-right" onclick="return download_res_tbl();" style="margin-bottom:10px; margin-top:-50px; ">Download as Image</button>
<table class="table table-hover table-bordered table-striped" id="assignment_section_tbl">
	<thead>
		<tr class="trbg">
			<th>Score Range</th>
			<th>Criterion Standard</th>
			<th>Self-Report Poll</th>
			<th>% Actual Assignment Score</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($assingment_rubric_criterion_detail as $criterion_detail)	{?>
			<tr>
				<td><?php echo $criterion_detail->oprf_column.' - '.$criterion_detail->oprf_column_sec;?></td>
				<td style="font-weight:600;"><?php echo $criterion_detail->range_name_column;?></td>
				<td>
					<?php $total_self_rating_count = get_self_report_poll_count_h($criterion_detail->id,$assignments_rubrics_row->id,$assignments_rubrics_row->department_id);
						if($assingment_responses_count>0){
 							echo round(($total_self_rating_count/$assingment_responses_count)*100,2).'%';
						}else{
							echo '0%';
						}
					?>
				</td>
				<td>
					<?php $no_of_participant = get_assignemnt_student_raters_rating_by_rubric_creiterion_h($assignments_rubrics_row->id,$criterion_detail->oprf_column,$criterion_detail->oprf_column_sec); 
					 if($assingment_responses_count>0){
 							echo round(($no_of_participant/$assingment_responses_count)*100,2).'%';
						}else{
							echo '0%';
						}
					?>
				</td>
			</tr>
		<?php } ?>
			<tr style="font-size:17px;">
				<td colspan="2" style="font-weight:600;">Valid Responses</td>
				<td colspan="2" style="font-weight:600;"><?php echo $assingment_responses_count;?></td>
			</tr>
	</tbody>
</table>		
</div>