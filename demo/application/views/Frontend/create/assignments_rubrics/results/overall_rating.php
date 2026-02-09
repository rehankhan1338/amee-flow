
<button class="btn btn-primary pull-right" onclick="return download_res_tbl();" style="margin-bottom:10px; margin-top:-50px; ">Download as Image</button>
<div class="survey_results" id="assignment_section_tbl">
<?php 
$assignment_id = $_GET['ar_id'];
 
if(count($assignments_valid_user_result)>0){
?>
<h4>Individual Assignment Ratings </h4>
<table class="table table-bordered table-striped" style="margin-top:10px;">
	<thead>		
		<tr class="trbg">
			<th width="3%">#</th>
			<th>Participant</th>
			<th>Individual Rating Average</th>			
		</tr>
		</thead>
		<?php 
		$standard_mean=array();
		$raters_valid_responses=0;
		 $j=1; foreach($assignments_valid_user_result as $result){?>
			
			<tr>
				<td><?php echo $j;?></td>		
				<td style="font-weight:600;"><?php if(isset($result->auth_code)&& $result->auth_code!=''){echo $result->auth_code;};if(isset($result->first_name)&& $result->first_name!=''){ echo ' / '.$result->first_name.' '.$result->last_name;}?></td>
				
				<td>
				
					<?php	$overall_average_rating=array();
						$raters_listing = get_raters_listing_with_feedback_details_h($_GET['ar_id'],$result->auth_code);

							if(count($raters_listing)>0){  
							 
							   $i=1; foreach($raters_listing as $raters_detail){ $total_category_score=array();?>
    

<?php if(count($assingment_rubric_builder_category_list)>0){?>
	 	<?php foreach($assingment_rubric_builder_category_list as $category_details){?>
 
<?php  $total_category_score[]=get_assingment_raters_score_of_category_count_h($_GET['ar_id'], $raters_detail->rater_auth_code, $result->auth_code,$category_details->rubric_id);?>

 
<?php } } ?>


 <?php   $overall_average_rating[] = array_sum($total_category_score);?> 
 
 

<?php $i++; } echo $standard_mean[]= round(array_sum($overall_average_rating)/count($assingment_rubric_builder_category_list),2);
				$raters_valid_responses++;
							}else{
							echo $standard_mean[]= 0;
							}
							
							
							
					
					?>
				</td>
			</tr>
		
		<?php  $j++; }  ?>
		 
</table>

<h4>Assignment Descriptive Statistics</h4>
<div class="col-md-7" style="margin:0;padding:0;">
<table class="table table-bordered table-striped" style="margin-top:10px; font-weight:600;">
	<tbody>		
		<tr>
			<td>Mean</td>
			<td width="30%"><?php   echo $this->mylibrary->getMean($standard_mean);?></td>			
		</tr>
		<tr>
			<td>Mode</td>
			<td><?php  $standard_mean12=array(implode(',',$standard_mean));   echo $this->mylibrary->getMode($standard_mean12);?></td>			
		</tr>
		<tr>
			<td>Median</td>
			<td><?php echo $this->mylibrary->getMedian($standard_mean); ?></td>			
		</tr>
		<tr>
			<td>Standard Deviation</td>
			<td><?php echo $this->mylibrary->getStandardDeviation($standard_mean); ?></td>			
		</tr>
		<tr>
			<td>Variance</td>
			<td><?php echo $this->mylibrary->getVariance($standard_mean); ?></td>			
		</tr>
		<tr>
			<td>Participant Valid Responses / Raters Valid Reponses</td>
			<td><?php echo count($assignments_valid_user_result).' / '.$raters_valid_responses; //print_r($standard_mean);?></td>			
		</tr>
		<tr>
			<td>Invalid Responses</td>
			<td><?php echo count($assignments_invalid_user_result);?></td>			
		</tr>
		<tr>
			<td>Response Rate</td>
			<td>
			<?php 
			if(count($assignments_user_result)>0){
			$incom_com_reponses = count($assignments_valid_user_result)+count($assignments_invalid_user_result);
			echo $reponse_rate = round(($incom_com_reponses/count($assignments_user_result))*100,2);
			}else{echo '0';}
			?>%
			</td>		
		</tr>
	</tbody>		
</table>
</div>
<div class="col-md-5" style="margin-top:10px;">
	<img style="max-width: 100%; min-height: 320px;border: 1px solid rgb(221, 221, 221); " src="<?php echo base_url();?>assets/frontend/images/standart_deviation.png" class="img-reponsive">
</div>
<div class="clearfix"></div>

<h4>Assignment Score Criteria </h4>
<table class="table table-bordered table-striped" style="margin-top:10px; font-weight:600;">
	<thead>		
		<tr class="trbg">
			<th>Assignment Score Criteria </th>
			<th>Total of Participants</th>	
			<th>Percentage</th>		
		</tr>
		</thead>
		<tbody>
<?php $assingment_rubric_criterion_detail = get_assingment_rubric_criterion_listing_h($_GET['ar_id']); ?>

		<?php if(count($assingment_rubric_criterion_detail)>0){?>
	 	<?php foreach($assingment_rubric_criterion_detail as $criterion_detail){?>
			<tr>
				<td><?php echo $criterion_detail->oprf_column.' - '.$criterion_detail->oprf_column_sec.' &nbsp;&nbsp;'.$criterion_detail->range_name_column;?></td>
				<td><?php echo $no_of_participant = get_assignemnt_student_raters_rating_by_rubric_creiterion_h($assignments_rubrics_row->id,$criterion_detail->oprf_column,$criterion_detail->oprf_column_sec); 
				 
				 ?></td>
				<td><?php if(count($assignments_valid_user_result)>0){ echo round(($no_of_participant/count($assignments_valid_user_result))*100,2); }else{ echo '0';}?>%</td>
			</tr>
		<?php } } ?>
		</tbody>
</table>
<?php } else{ ?>
		
<h4>No ratings made yet</h4>
			
		<?php } ?>
</div>
