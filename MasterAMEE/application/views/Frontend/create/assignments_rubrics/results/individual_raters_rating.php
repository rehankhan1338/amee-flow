<h4><?php  if(isset($assingment_auth_code_detail->auth_code)&& $assingment_auth_code_detail->auth_code!=''){echo $assingment_auth_code_detail->auth_code;};if(isset($assingment_auth_code_detail->first_name)&& $assingment_auth_code_detail->first_name!=''){ echo ' / '.$assingment_auth_code_detail->first_name.' '.$assingment_auth_code_detail->last_name;} echo " (Rater's Feedback Results)";?>
</h4>
<button class="btn btn-primary pull-right" onclick="return download_res_tbl();" style="margin-bottom:10px; margin-top:-50px; ">Download as Image</button> 
<table class="table table-hover table-bordered table-striped" id="assignment_section_tbl">
<thead>
<tr class="trbg">
	<th rowspan="2" class="survey_listing_td" style="vertical-align:middle; " width="3%">#</th>
	<th rowspan="2" class="survey_listing_td" style="vertical-align:middle;">Rater Code</th>
	<th colspan="<?php echo count($assingment_rubric_builder_category_list);?>" class="survey_listing_td" style="vertical-align:top; text-align:center;">Individual Raters Score</th>
	<th rowspan="2" class="survey_listing_td" style="vertical-align:middle;">Individual Overall Raters Score</th>
 	<!--<th rowspan="2" class="survey_listing_td" style="vertical-align:middle;">Action</th>-->
</tr>
<tr class="trbg">
	 <?php if(count($assingment_rubric_builder_category_list)>0){?>
	 	<?php foreach($assingment_rubric_builder_category_list as $category_details){?>
			<th class="survey_listing_td" style="vertical-align:top;"><?php echo ucfirst(strtolower($category_details->category_name));?></th>
	 <?php } } ?>
</tr>
</thead>
<?php $raters_listing = get_raters_listing_with_feedback_details_h($_GET['ar_id'],$assingment_auth_code_detail->auth_code);

if(count($raters_listing)>0){

?>

<tbody>


<?php  $i=1; foreach($raters_listing as $raters_detail){ $total_category_score=array();?>

<tr>
<td><?php echo $i;?></td>
<td style="font-weight:600;"><?php echo $raters_detail->rater_auth_code;

	$raters_full_details = get_raters_details_h($raters_detail->rater_auth_code);
	if(isset($raters_full_details->rater_name)&& $raters_full_details->rater_name!=''){ echo ' / '.$raters_full_details->rater_name;}
?></td>


<?php if(count($assingment_rubric_builder_category_list)>0){?>
	 	<?php foreach($assingment_rubric_builder_category_list as $category_details){?>
<td>
<?php echo $total_category_score[]=get_assingment_raters_score_of_category_count_h($_GET['ar_id'], $raters_detail->rater_auth_code, $assingment_auth_code_detail->auth_code,$category_details->rubric_id);?>

</td>
<?php } } ?>


<td><?php echo $overall_average_rating[] = array_sum($total_category_score);?></td>
<!--<td></td>-->
</tr>

<?php $i++; }?>	
</tbody>
<tfoot>
	<tr>
		<td style="font-weight:600; font-size:18px;" colspan="2">Overall Average Rating</td>
		<td style="font-weight:600; font-size:18px;" colspan="<?php echo count($assingment_rubric_builder_category_list)+1;?>"><?php echo round(array_sum($overall_average_rating)/count($assingment_rubric_builder_category_list),2);?></td>
	</tr>
</tfoot>
<?php } else{ ?> 		 

<tbody>
	<tr>
		<td colspan="<?php echo 3+count($assingment_rubric_builder_category_list);?>">No ratings made yet </td>
	</tr>
</tbody>
<?php } ?>
</table>
<div class="clearfix"></div>