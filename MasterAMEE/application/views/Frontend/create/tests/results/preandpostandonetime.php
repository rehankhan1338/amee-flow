<button class="btn btn-primary pull-right" onclick="return download_res_tbl();" style="margin-bottom:10px; margin-top:-50px;">Download as Image</button>
<div id="test_section_tbl">
<?php if(isset($test_details->test_type) && $test_details->test_type==1){?>



<table class="table table-hover table-bordered table-striped" >

	<thead>

		<tr class="trbg"> 

			<th style="vertical-align:middle;" nowrap="nowrap">#</th>

			<th style="vertical-align:middle;" nowrap="nowrap">Code / Name </th>

			<th style="vertical-align:middle;" nowrap="nowrap">Pre Score</th>

			<th style="vertical-align:middle;" nowrap="nowrap">Post Scores</th>

			<th style="vertical-align:middle;">Gain / Loss</th>

			<th style="vertical-align:middle;">Percentage</th>

			<th style="vertical-align:middle;">Gain or Loss</th>

		</tr>

	</thead>

	<tbody>

	<?php 

	

	$pre_score_calculation_arr=array();

	$post_score_calculation_arr=array();

	

	 $j=1; foreach($student_test_complete_detail as $result){?>

	

		<tr>

  			<td style="vertical-align:middle;"><?php echo $j;?></td>		

			<td style="font-weight:600;vertical-align:middle;"><?php if(isset($result->auth_code)&& $result->auth_code!=''){echo $result->auth_code;};if(isset($result->first_name)&& $result->first_name!=''){ echo ' / '.$result->first_name.' '.$result->last_name;}?></td>

			<td>

			<?php 

				if(isset($result->start_date) && $result->start_date!='' && $result->start_date!=0){

					$pre_score_count = get_score_of_test_answers_result($result->test_id,$result->auth_code,'1');

					if($pre_score_count>0){echo $pre_score=$pre_score_count;

					$pre_score_calculation_arr[] = $pre_score;

					}else{echo $pre_score=0;}

				}else{

					echo '<span class="not_yet_gave">Not Yet</span>';$pre_score=0;

				}

				

			?>

			</td>

			<td>

			<?php 

				if(isset($result->post_start_date) && $result->post_start_date!='' && $result->post_start_date!=0){

					$post_score_count = get_score_of_test_answers_result($result->test_id,$result->auth_code,'2');

					if($post_score_count>0){echo $post_score = $post_score_count;

					$post_score_calculation_arr[] = $post_score;

				}else{echo $post_score=0;}

				}else{

					echo '<span class="not_yet_gave">Not Yet</span>';$post_score=0;

				}

			?>

			</td>

			<td><?php if(isset($result->post_start_date) && $result->post_start_date!='' && $result->post_start_date!=0){ echo $gain_loss_result = $post_score-$pre_score; }else{ echo '-';}?></td>	

			<td><?php if(isset($result->post_start_date) && $result->post_start_date!='' && $result->post_start_date!=0){ echo round(($gain_loss_result*100)/$total_score).'%';}else{ echo '-';}?></td>	

			<td style="font-weight:600;"><?php if(isset($result->post_start_date) && $result->post_start_date!='' && $result->post_start_date!=0){ if($gain_loss_result==0){ echo 'No Gain / Loss';}else if($gain_loss_result>0){echo 'Gain';}else{ echo 'Loss';}}else{ echo '-';}?></td>		

			

		</tr>

			

	<?php $j++; } ?>

	</tbody>

</table>

 

<table class="table table-bordered table-hover table-striped" style="margin-top:10px; font-weight:600;">

	<tbody>	

		<tr class="trbg"> 

			<th style="vertical-align:middle;" nowrap="nowrap">Pretest / Posttest Descriptive Statistics </th>

			<th style="vertical-align:middle;" nowrap="nowrap">Pre Test</th>

			<th style="vertical-align:middle;" nowrap="nowrap">Post Test</th>

		</tr>	

		<tr>

			<td>Mean</td>

			<td><?php echo $this->mylibrary->getMean($pre_score_calculation_arr);?></td>

			<td><?php echo $this->mylibrary->getMean($post_score_calculation_arr);?></td>	

		</tr>

		<tr>

			<td>Mode</td>

			<td><?php //$pre_score_calculation_arr12=array(implode(',',$pre_score_calculation_arr));

			echo $this->mylibrary->getMode($pre_score_calculation_arr);?></td>

			<td><?php //$post_score_calculation_arr12=array(implode(',',$pre_score_calculation_arr));

			echo $this->mylibrary->getMode($pre_score_calculation_arr);?></td>			

		</tr>

		<tr>

			<td>Median</td>

			<td><?php echo $this->mylibrary->getMedian($pre_score_calculation_arr); ?></td>	

			<td><?php echo $this->mylibrary->getMedian($post_score_calculation_arr); ?></td>		

		</tr>

		<tr>

			<td>Standard Deviation</td>

			<td><?php echo $this->mylibrary->getStandardDeviation($pre_score_calculation_arr); ?></td>	

			<td><?php echo $this->mylibrary->getStandardDeviation($post_score_calculation_arr); ?></td>	

		</tr>

		<tr>

			<td>Variance</td>

			<td><?php echo $this->mylibrary->getVariance($pre_score_calculation_arr); ?></td>	

			<td><?php echo $this->mylibrary->getVariance($post_score_calculation_arr); ?></td>		

		</tr>

		<tr>

			<td>Valid Responses</td>

			<td><?php echo count($student_test_complete_detail);?></td>

			<td><?php echo count($student_post_test_complete_detail);?></td>

		</tr>

		<tr>

			<td>Invalid Responses</td>

			<td><?php echo count($student_test_incomplete_detail);?></td>	

			<td><?php echo count($student_post_test_incomplete_detail);?></td>	

		</tr>

		<tr>

			<td>Response Rate</td>

			<td>

			<?php 

			if(count($tests_email_detail)>0){

			$incom_com_reponses = count($student_test_complete_detail)+count($student_test_incomplete_detail);

			echo $reponse_rate = round(($incom_com_reponses/count($tests_email_detail))*100,2);

			}else{echo '0';}

			?>%

			</td>	

			<td>

			<?php 

			if(count($tests_email_detail)>0){

			$post_incom_com_reponses = count($student_post_test_complete_detail)+count($student_post_test_incomplete_detail);

			echo $reponse_rate = round(($post_incom_com_reponses/count($tests_email_detail))*100,2);

			}else{echo '0';}

			?>%

			</td>

		</tr>

		 

	</tbody>		

</table>



<?php }else{ ?>



<h4>One Time Test Frequency Distribution </h4>



<table class="table table-hover table-bordered table-striped" style="margin-top:10px;" id="table_recordtbl25">

	<thead>

		<tr class="trbg"> 

			<th style="vertical-align:middle;" width="3%" nowrap="nowrap">#</th>

			<th style="vertical-align:middle;" nowrap="nowrap">Code / Name </th>

			<th style="vertical-align:middle;" nowrap="nowrap" width="30%">Score</th>

			<!--<th style="vertical-align:middle;">Frequency </th>

			<th style="vertical-align:middle;">Percentage</th>-->

		</tr>

	</thead>

	<tbody>

	<?php 

	

	$one_time_score_calculation_arr=array(); 

	

	 $j=1; foreach($student_test_complete_detail as $result){?>

	

		<tr>

  			<td style="vertical-align:middle;"><?php echo $j;?></td>		

			<td style="font-weight:600;vertical-align:middle;"><?php if(isset($result->auth_code)&& $result->auth_code!=''){echo $result->auth_code;};if(isset($result->first_name)&& $result->first_name!=''){ echo ' / '.$result->first_name.' '.$result->last_name;}?></td>

			<td>

			<?php 

				if(isset($result->start_date) && $result->start_date!='' && $result->start_date!=0){

					$one_time_score_count = get_score_of_test_answers_result($result->test_id,$result->auth_code,'3');

					if($one_time_score_count>0){echo $one_time_score=$one_time_score_count;

						$one_time_score_calculation_arr[] = $one_time_score;

					}else{echo $one_time_score=0;}

				}else{

					echo '<span class="not_yet_gave">Not Yet</span>';$one_time_score=0; 

				}	

			?>

			</td>

			 

			<!--<td> </td>	

			<td> </td>	--> 	

			

		</tr>

			

	<?php $j++; }  ?>

	</tbody>

</table>



<table class="table table-bordered table-hover table-striped" style="margin-top:10px; font-weight:600;">

	<tbody>	

		<tr class="trbg"> 

			<th style="vertical-align:middle;" colspan="2" nowrap="nowrap">One-Time Test Descriptive Statistics </th>

		</tr>	

		<tr>

			<td>Mean</td>

			<td width="30%"><?php echo $this->mylibrary->getMean($one_time_score_calculation_arr);?></td>

		</tr>

		<tr>

			<td>Mode</td>

			<td><?php //$one_time_score_calculation_arr12=array(implode(',',$one_time_score_calculation_arr));

			echo $this->mylibrary->getMode($one_time_score_calculation_arr);?></td>		

		</tr>

		<tr>

			<td>Median</td>

			<td><?php echo $this->mylibrary->getMedian($one_time_score_calculation_arr); ?></td>			

		</tr>

		<tr>

			<td>Standard Deviation</td>

			<td><?php echo $this->mylibrary->getStandardDeviation($one_time_score_calculation_arr); ?></td>	

		</tr>

		<tr>

			<td>Variance</td>

			<td><?php echo $this->mylibrary->getVariance($one_time_score_calculation_arr); ?></td>		

		</tr>

		<tr>

			<td>Valid Responses</td>

			<td><?php echo count($student_test_complete_detail);?></td>	

		</tr>

		<tr>

			<td>Invalid Responses</td>

			<td><?php echo count($student_test_incomplete_detail);?></td>	

		</tr>

		<tr>

			<td>Response Rate</td>

			<td>

			<?php 

			if(count($tests_email_detail)>0){

			$incom_com_reponses = count($student_test_complete_detail)+count($student_test_incomplete_detail);

			echo $reponse_rate = round(($incom_com_reponses/count($tests_email_detail))*100,2);

			}else{echo '0';}

			?>%

			</td>	

		</tr>

	</tbody>		

</table>



<?php } ?>
</div>