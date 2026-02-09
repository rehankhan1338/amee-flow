<section class="content">
<script type="text/javascript">
function send_notification_to_department(){
	var n = jQuery(".case:checked").length;
	if(n>=1){
		var notification_box = jQuery('#notification_box').val();
		var notification_type = jQuery('#notification_type').val();
		if(notification_box==''){
			alert('Please enter your message want to send!');
			return false;
		}else if(notification_type==''){
			alert('Please select notification type!');
			return false;
		}else{
			var r = confirm("Are you sure want to send given notification selected department!");
			if (r == true) {
				var new_array=[];
				jQuery(".case:checked").each(function() {
				var n_total=parseInt(jQuery(this).val());
				new_array.push(n_total);
				});
				window.location  = '<?php echo base_url();?>admin/notifications/send?id='+new_array+'&message='+notification_box+'&notification_type='+notification_type;
			}
		}
	}else{
		alert("Please select at least one department!");
		return false;
	}
}
$(function(){   
   $("#selectall").click(function () {
         $('.case').attr('checked', this.checked); 
   });
   $(".case").click(function(){
       if($(".case").length == $(".case:checked").length) {
           $("#selectall").attr("checked", "checked");
       } else {
           $("#selectall").removeAttr("checked");
       }
   });
});
</script>
<div class="box snapshot_page">
	
   <!-- start body div -->
	<div class="box-body" style="padding:0;">
	
		<div class="row">
			<div class="col-md-12">
 				<div class="col-md-8" style="margin:0; padding:0;">
					<input type="text" name="notification_box" value="" id="notification_box" placeholder="Enter your message" class="form-control"  />
				</div>
				<div class="col-md-2">
					<select class="form-control"  name="notification_type" id="notification_type">
						<option value="">-select notification type-</option>
						<option value="Assessment Meetings">Assessment Meetings</option>
						<option value="Assessment Reports">Assessment Reports</option>
						<option value="Assessment Tasks">Assessment Tasks</option>
						<option value="Assessment Week">Assessment Week</option>
						<option value="General">General</option>
						<option value="Notifications">Notifications</option>
						<option value="Registration">Registration</option> 
					</select>
				</div>
				<div class="col-md-2"  style="margin:0; padding:0;">
					<a style="vertical-align:top; width:100%;" class="btn btn-primary" onclick="return send_notification_to_department();" ><i class="glyphicon glyphicon-send"></i> &nbsp;&nbsp;Send Notification</a>
				</div>
			</div> 	
		</div>	
 		
	<div class="row" style="margin-top: 15px;">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-hover table-bordered table-striped" id="table_recordtbl12">
					<thead>
						<tr class="trbg">
							<th width="3%"  style="vertical-align:top;text-align:center;"><input type="checkbox" name="selectall" id="selectall" /></th>
							<th style="vertical-align:top;" nowrap="nowrap">Name Of Department </th>
							<th style="vertical-align:top;" nowrap="nowrap">Last Notification Message </th> 
							<th style="vertical-align:top;" nowrap="nowrap">Last Notification Type </th>  
							<th style="vertical-align:top;" nowrap="nowrap">Last Notification Date </th> 
							<th style="vertical-align:top;" nowrap="nowrap">View Notifications</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; foreach ($departments_details as $row) {
							
							$notification_sent_details = get_last_notification_sent_details_h($row->id);
						 ?>
						<tr>
							<td style="text-align:center;"><input type="checkbox" name="department_id[]" id="department_id" class="case" value="<?php echo $row->id;?>" /></td>
							<td><?php echo $row->department_name;?></td> 
							<td><?php if(isset($notification_sent_details->message) && $notification_sent_details->message!=''){echo $notification_sent_details->message;}else{echo '-';}?></td>
							<td><?php if(isset($notification_sent_details->notification_type) && $notification_sent_details->notification_type!=''){echo $notification_sent_details->notification_type;}else{echo '-';}?></td>
							<td><?php if(isset($notification_sent_details->send_time) && $notification_sent_details->send_time!=''){echo date('m/d/Y h:i A',$notification_sent_details->send_time);}else{echo '-';}?></td>
							<td nowrap="nowrap">
								<a href="<?php echo base_url();?>admin/notifications/display/<?php echo $row->id;?>"><i style="font-size: 25px;" class="fa fa-list-alt" aria-hidden="true"></i></a> 
								<label style="margin-bottom:0;"><b><?php echo ' ('.get_all_notification_count_of_department_h($row->id).')';?></b></label>
							</td>
						</tr>
						<?php  $i++; } ?>          
		
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- /.box-body -->
<!-- Modal -->    
</div>	
  <!-- /.box -->
</section>