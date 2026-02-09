<table class="table table-hover table-bordered table-striped table_mar20" id="table_recordtbl12">
	<thead>
		<tr class="trbg">
			<th rowspan="2" width="3%"  style="vertical-align:middle;color: #f6e4a5;">#</th>
			<th rowspan="2" style="vertical-align:middle;color: #f6e4a5;">Department/Programs</th> 
			<th colspan="2" style="vertical-align:top; text-align:center;color: #f6e4a5;">Survey</th>
			<th rowspan="2" style="vertical-align:middle;color: #f6e4a5;">Date Created</th>
		</tr>
		<tr class="trbg">
			<th style="vertical-align:top;">Name of Survey</th> 
			<th style="vertical-align:top;"># Responses</th>
		</tr>
	</thead>
	<tbody>
		<?php $i=1; foreach ($departments_details as $departments){
			
				$survey_listing = get_admin_survey_listing_h($departments->id);
				 
				if(count($survey_listing)>0){
				
				$kl=1;	foreach($survey_listing as $survey_details){
					
					if($kl==1){
			?>
				<tr>
					<td rowspan="<?php echo count($survey_listing);?>"><?php echo  $i;?></td>
					<td rowspan="<?php echo count($survey_listing);?>"><?php echo ucfirst($departments->department_name);?></td>
					<td><?php echo $survey_details->survey_name;?></td>
					<td><?php echo get_survey_responses_count($survey_details->survey_id,$survey_details->department_id);?>	</td> 
					<td><?php if(isset($survey_details->creation_date_time) && $survey_details->creation_date_time!=''){echo date('M d, Y h:i A',$survey_details->creation_date_time);}?></td> 
				</tr>
				
				<?php }else{ ?>
				
					<tr>
						<td><?php echo $survey_details->survey_name;?></td>
						<td><?php echo get_survey_responses_count($survey_details->survey_id,$survey_details->department_id);?>	</td> 
						<td><?php if(isset($survey_details->creation_date_time) && $survey_details->creation_date_time!=''){echo date('M d, Y h:i A',$survey_details->creation_date_time);}?></td> 
					</tr>
				
				<?php } ?>
		
		<?php $kl++; } }else{ ?>
			
			<tr>
				<td><?php echo  $i;?></td>
				<td><?php echo ucfirst($departments->department_name);?></td>
				<td style="color:#a94442;">No data available</td>
				<td>-</td> 
				<td>-</td> 
			</tr>
			
		<?php } ?>
		<?php  $i++; } ?>          

	</tbody>
</table>