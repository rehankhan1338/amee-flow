<button class="btn btn-primary pull-right" onclick="return download_res_tbl();" style="margin-bottom:10px; margin-top:-50px; ">Download as Image</button>
<table class="table table-hover table-bordered table-striped" id="assignment_section_tbl">
	<thead>
		<tr class="trbg"> 
			<th class="survey_listing_td" style="vertical-align:middle;" width="3%" nowrap="nowrap">#</th>
			<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">Raters </th>
			<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">Number of Ratings Completed</th>
			<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">Number of Ratings Incomplete</th>
			<!--<th class="survey_listing_td" style="vertical-align:middle;">Action</th>-->
		</tr>
	</thead>
	<tbody>
	<?php  $assignment_raters_listing = get_assignment_raters_listing_h($_GET['dept_id'],$_GET['ar_id']);
	 
			$j=1; foreach($assignment_raters_listing as $raters_details){
	
				$completed_ratings = get_assignment_raters_rating_status_h($_GET['ar_id'],$raters_details->auth_code,'1');
				$not_completed_ratings = get_assignment_raters_rating_status_h($_GET['ar_id'],$raters_details->auth_code,'2');
		
		?>
		
		<tr>
 			<td><?php echo $j;?></td>		
			<td style="font-weight:600;"><?php if(isset($raters_details->auth_code)&& $raters_details->auth_code!=''){echo $raters_details->auth_code;};if(isset($raters_details->rater_name) &&  $raters_details->rater_name!=''){ echo ' / '.$raters_details->rater_name;}?></td>
			<td><?php echo $completed_ratings;?></td>
			<td><?php echo $not_completed_ratings;?></td>
 			<!--<td></td>-->
		</tr>
	
	<?php $j++; } ?>
	</tbody>
</table>