<button class="btn btn-primary pull-right" onclick="return download_res_tbl();" style="margin-bottom:10px; margin-top:-50px; ">Download as Image</button>
<?php

$test_type = $test_details->test_type;
if($test_type==1){ 		  
	   
?>

<table class="table table-hover table-bordered table-striped" id="test_section_tbl">
	<thead>
		<tr class="trbg"> 
			<th style="vertical-align:middle;" nowrap="nowrap">#</th>
			<th  style="vertical-align:middle;" nowrap="nowrap">Code / Name </th>
			<th style="vertical-align:middle;" nowrap="nowrap">Start Date</th>
			<th style="vertical-align:middle;" nowrap="nowrap">End Date</th>
			<th style="vertical-align:middle;">Status</th>
			<th style="vertical-align:middle;">Test Type</th>
			<th style="vertical-align:middle;">Answers</th>
			<th style="vertical-align:middle;">Score</th>
		</tr>
	</thead>
	<tbody>
	<?php $j=1; foreach($tests_student_complete_incomplete_detail as $result){?>
	
		<tr>
  			<td style="vertical-align:middle;" rowspan="2" ><?php echo $j;?></td>		
			<td rowspan="2"  style="font-weight:600;vertical-align:middle;"><?php if(isset($result->auth_code)&& $result->auth_code!=''){echo $result->auth_code;};if(isset($result->first_name)&& $result->first_name!=''){ echo ' / '.$result->first_name.' '.$result->last_name;}?></td>
			<td><?php if(isset($result->start_date) && $result->start_date!='' && $result->start_date!=0){ echo date('m/d/Y h:i:s',$result->start_date);}else{echo '-';}?></td>
			<td><?php if(isset($result->finish_date) && $result->finish_date!=''){ echo date('m/d/Y h:i:s',$result->finish_date);}else{echo '-';}?></td>
 			<td><?php if(isset($result->finish_status) && $result->finish_status=='1'){echo '<b>Complete</b>';}else{echo 'Incomplete';}?></td>
			<td>Pre</td>	
			<td> 
				<a style="font-size: 25px;" href="<?php echo base_url();?>department/create/tests/management?tab_id=7&test_id=<?php echo $result->test_id;?>&test_type=1&dept_id=<?php echo $_GET['dept_id'];?>&view_result=takers&auth_code=<?php echo $result->auth_code;?>"><i class="fa fa-list-alt" aria-hidden="true"></i></a>
 			</td>
			<td style="font-weight:600;vertical-align:middle;"><?php echo get_score_of_test_answers_result($result->test_id,$result->auth_code,'1');?></td>
		</tr>
		
		<tr>
			<td><?php if(isset($result->post_start_date) && $result->post_start_date!='' && $result->post_start_date!=0){ echo date('m/d/Y h:i:s',$result->post_start_date);}else{echo '-';}?></td>
			<td><?php if(isset($result->post_finish_date)&& $result->post_finish_date!=''){ echo date('m/d/Y h:i:s',$result->post_finish_date);}else{echo '-';}?></td>
 			<td><?php if(isset($result->post_finish_status) && $result->post_finish_status=='1'){echo '<b>Complete</b>';}else{
			if(isset($result->post_start_date) && $result->post_start_date!='' && $result->post_start_date!=0){echo 'Incomplete';}else{ echo '-'; } }?></td>
			<td>Post</td>	
			<td> 
			<?php if(isset($result->post_finish_status) && $result->post_finish_status=='1'){?>
				<a style="font-size: 25px;" href="<?php echo base_url();?>department/create/tests/management?tab_id=7&test_id=<?php echo $result->test_id;?>&test_type=2&dept_id=<?php echo $_GET['dept_id'];?>&view_result=takers&auth_code=<?php echo $result->auth_code;?>"><i class="fa fa-list-alt" aria-hidden="true"></i></a>
				<?php }else{ echo '-';}?> 
 			</td>
			<td style="font-weight:600;vertical-align:middle;"><?php  if(isset($result->post_finish_status) && $result->post_finish_status=='1'){echo get_score_of_test_answers_result($result->test_id,$result->auth_code,'2');}else{ echo '-';}?></td>
		</tr>
		
		
	
	<?php $j++; } ?>
	</tbody>
</table>
<?php } else{ ?>


<table class="table table-hover table-bordered table-striped" id="test_section_tbl">
	<thead>
		<tr class="trbg"> 
			<th style="vertical-align:middle;" nowrap="nowrap">#</th>
			<th style="vertical-align:middle;" nowrap="nowrap">Code / Name </th>
			<th style="vertical-align:middle;" nowrap="nowrap">Start Date</th>
			<th style="vertical-align:middle;" nowrap="nowrap">End Date</th>
			<th style="vertical-align:middle;">Status</th>
			<th style="vertical-align:middle;">Test Type</th>
			<th style="vertical-align:middle;">Answers</th>
			<th style="vertical-align:middle;">Score</th>
		</tr>
	</thead>
	<tbody>
	<?php $j=1; foreach($tests_student_complete_incomplete_detail as $result){?>
	
		<tr>
 			<td><?php echo $j;?></td>		
			<td style="font-weight:600;"><?php if(isset($result->auth_code)&& $result->auth_code!=''){echo $result->auth_code;};if(isset($result->first_name)&& $result->first_name!=''){ echo ' / '.$result->first_name.' '.$result->last_name;}?></td>
			<td><?php if(isset($result->start_date) && $result->start_date!='' && $result->start_date!=0){ echo date('m/d/Y h:i:s',$result->start_date);}else{echo '-';}?></td>
			<td><?php if(isset($result->finish_date)&& $result->finish_date!=''){ echo date('m/d/Y h:i:s',$result->finish_date);}else{echo '-';}?></td>
 			<td><?php if(isset($result->finish_status) && $result->finish_status=='1'){echo '<b>Complete</b>';}else{echo 'Incomplete';}?></td>
			<td>One Time</td>	
			<td> 
				<a style="font-size: 25px;" href="<?php echo base_url();?>department/create/tests/management?tab_id=7&test_id=<?php echo $result->test_id;?>&test_type=3&dept_id=<?php echo $_GET['dept_id'];?>&view_result=takers&auth_code=<?php echo $result->auth_code;?>"><i class="fa fa-list-alt" aria-hidden="true"></i></a>
 			</td>
			<td style="font-weight:600;vertical-align:middle;"><?php echo get_score_of_test_answers_result($result->test_id,$result->auth_code,'3');?></td>
		</tr>
	
	<?php $j++; } ?>
	</tbody>
</table>
<?php } ?>