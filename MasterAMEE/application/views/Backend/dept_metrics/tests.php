<table class="table table-hover table-bordered table-striped table_mar20" id="table_recordtbl12">
	<thead>
		<tr class="trbg">
			<th rowspan="2" width="3%"  style="vertical-align:middle;color: #f6e4a5;">#</th>
			<th rowspan="2" style="vertical-align:middle;color: #f6e4a5;">Department/Program</th> 
			<th colspan="2" style="vertical-align:top; text-align:center;color: #f6e4a5;">Test</th>
			<th rowspan="2" style="vertical-align:middle;color: #f6e4a5;">Date Created</th>
			<th rowspan="2" style="vertical-align:middle;color: #f6e4a5;">Criterion Result</th>
		</tr>
		<tr class="trbg">
			<th style="vertical-align:top;">Name of Test</th> 
			<th style="vertical-align:top;"># Responses</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=1; foreach ($departments_details as $departments){
			
				$test_listing = get_admin_test_listing_h($departments->id);
				
				if(count($test_listing)>0){
				
				$kl=1;	foreach($test_listing as $test_details){
					
					if($kl==1){
			?>
				<tr>
					<td rowspan="<?php echo count($test_listing);?>"><?php echo  $i;?></td>
					<td rowspan="<?php echo count($test_listing);?>"><?php echo ucfirst($departments->department_name);?></td>
					<td><?php echo $test_details->test_title;?></td>
					<td><?php echo get_tests_reponses_count($test_details->test_id,$test_details->department_id);?>	</td> 
					<td><?php if(isset($test_details->creation_date_time) && $test_details->creation_date_time!=''){echo date('M d, Y h:i A',$test_details->creation_date_time);}?></td>
					<td><a>Click here</a></td>
				</tr>
				
				<?php }else{ ?>
				
					<tr>
						<td><?php echo $test_details->test_title;?></td>
						<td><?php echo get_tests_reponses_count($test_details->test_id,$test_details->department_id);?>	</td> 
						<td><?php if(isset($test_details->creation_date_time) && $test_details->creation_date_time!=''){echo date('M d, Y h:i A',$test_details->creation_date_time);}?></td>
						<td><a>Click here</a></td> 
					</tr>
				
				<?php } ?>
		
		<?php $kl++; } }else{ ?>
			
			<tr>
				<td><?php echo  $i;?></td>
				<td><?php echo ucfirst($departments->department_name);?></td>
				<td style="color:#a94442;">No data available</td>
				<td>-</td> 
				<td>-</td> 
				<td>-</td> 
			</tr>
			
		<?php } ?>
		<?php  $i++; } ?>          

	</tbody>
</table>