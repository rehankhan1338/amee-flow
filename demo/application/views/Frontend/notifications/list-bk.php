
<div class="clearfix"></div>		  
 <table class="table table-hover  table-striped" id="table_recordtbl">
	<thead>
		<tr class="trbg">
			<th class="survey_listing_td" width="6%"  style="vertical-align:middle;text-align:center;">#</th>
			<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">Message </th> 
			<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">Type </th>  
			<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">Sent Date </th> 
		</tr>
	 </thead>
		<tbody>
			<?php if(count($department_notification_list)>0){ $i=1; foreach ($department_notification_list as $row) {  ?>
			<tr>
				<td style="text-align:center;"><?php echo $i;?></td>
				<td><?php if(isset($row->message) && $row->message!=''){echo $row->message;}else{echo '-';}?></td>
				<td><?php if(isset($row->notification_type) && $row->notification_type!=''){echo $row->notification_type;}else{echo '-';}?></td>
				<td><?php if(isset($row->send_time) && $row->send_time!=''){echo date('m/d/Y h:i A',$row->send_time);}else{echo '-';}?></td>
			</tr>
			<?php  $i++; }} ?>          
				
		</tbody>
</table>
</div> 
 
<div class="clearfix"></div>
	 