<script src="<?php echo base_url();?>assets/ExportHtml/FileSaver.js"></script> 
<script src="<?php echo base_url();?>assets/ExportHtml/jquery.wordexport.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($){
    	$("#time_tracker").click(function(event) {
        	$("#page_time_tracker").wordExport('time_tracker_report');
      	});
    });
</script>

<div class="pull-right">
	<a class="btn btn-default" href="<?php echo base_url();?>reports/reset_time_tracker" onclick="return confirm('Resetting the Time Tracker will remove all previously time tracked activities and will leave you with no record of your assessment work. Are you sure you want to reset?');" style="padding:3px 10px; font-size:15px;"><i class="fa fa-clock-o" aria-hidden="true"></i> Reset Time Tracker</a>
	<a class="btn btn-primary" id="time_tracker" style="padding:3px 10px; font-size:15px;"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
	<a class="btn btn-default" href="<?php echo base_url();?>department/reports" style="padding:3px 10px; font-size:15px;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Dashboard</a>
</div>
<div class="clearfix"></div>
<div id="page_time_tracker"> 
	<div style=" margin-bottom: 20px; text-align: center;">
	    <h2 style="color: #485b79; font-weight:600;"><?php echo $dept_session_details->department_name;?></h2>    
    </div>     

	<table width="100%" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th width="10%" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left;border:1px solid #ddd;">Date</th>
				
				<th width="10%" nowrap="nowrap" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left; border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">Start Time</th>
				
				<th width="10%" nowrap="nowrap" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left; border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">End Time</th>
				
				<th nowrap="nowrap" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left; border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">Assessment Activity</th>
				
				<th width="10%" nowrap="nowrap" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left; border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">Total Time</th>
			</tr>
		</thead>
		<tbody>	
		<?php $total_time_tracker=array();foreach($time_tracker_details as $time_tracker){?>  
			<tr>
				<td nowrap="nowrap" style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;">
					<?php if(isset($time_tracker->session_start_date_time)&& $time_tracker->session_start_date_time!=''){echo date('m/d/Y',$time_tracker->session_start_date_time);}?>
				</td>
				
				<td nowrap="nowrap" style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;border-right:1px solid #ddd;">
					<?php if(isset($time_tracker->session_start_date_time)&& $time_tracker->session_start_date_time!=''){echo date('h:i A',$time_tracker->session_start_date_time);}?>
				</td>
				
				<td nowrap="nowrap" style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">
					<?php if(isset($time_tracker->session_end_date_time)&& $time_tracker->session_end_date_time!=''){echo date('h:i A',$time_tracker->session_end_date_time);}else{ echo date('h:i A',$time_tracker->last_modification_time);}?>
				</td>
				
				<td style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">
					<?php $activity_name=array(); $activities_listing = get_activities_listing_h($time_tracker->id);
					
					if(count($activities_listing)>0){ 
						
						foreach($activities_listing as $activities_details){ 
						
							$activity_name[] = str_replace('/',' & ',str_replace('_',', ',$activities_details->activity_name));
							
					?>
					
					<?php } echo implode(' | ',$activity_name); }else{ echo '-'; } ?>
				</td>
				
				<td nowrap="nowrap" style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">
					<?php if(isset($time_tracker->time_track)&& $time_tracker->time_track!=''){
						$total_time_tracker[]=$time_tracker->time_track;
						echo gmdate('H:i:s',$time_tracker->time_track);
					}?>
				</td>
			</tr>			
		<?php } ?>	      
		</tbody>
		<tfoot>
			<tr>
				<th nowrap="nowrap" colspan="4" style="padding: 10px; font-size:16px; background:#485b79; color:#fff; vertical-align:middle; text-align:left;border:1px solid #ddd;">Total Overall Time</th>
				<th nowrap="nowrap" style="padding: 10px; background:#485b79; font-size:16px; color:#fff; vertical-align:middle; text-align:left; border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">					
					<?php echo gmdate('H:i:s',array_sum($total_time_tracker));?>					
				</th>
			</tr>
		</tfoot>
	</table>
 
</div>