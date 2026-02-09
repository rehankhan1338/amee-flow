<script type="text/javascript">
function delete_entry(val) {
	if (val != "") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
			window.location = "<?php echo $this->config->item('ajax_base_url').$this->config->item('admin_directory_name').'users/delete_organization?organizationId='; ?>"+val;
		}
	}
}
function update_toggle_swtich_values(organizationId,column_name){
	if(organizationId>0){
		var checkstatus=$('#toggle-event-'+column_name+organizationId).prop('checked');
		if(checkstatus == true){
			var status=1;		
		}else{
			var status=0;		 
		}	
		$.ajax({url: "<?php echo base_url(). $this->config->item('admin_directory_name');?>users/update_account_status?organizationId="+organizationId+"&column_name="+column_name+"&status="+status, 
			beforeSend: function(){ 
				$('#spinner_'+column_name+'_'+organizationId).html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result){
				if(result=='success'){
					$('#spinner_'+column_name+'_'+organizationId).html('');
				}
			}
		});
	} 
}
function sendNotification(){
	var n = $(".case:checked").length;
	if(n>=1){
		$('#notification_send').modal('show');
		var new_array=[];
		$(".case:checked").each(function() {
			var n_total=parseInt($(this).val());
			new_array.push(n_total);
		});
		$('#hSelectedIds').val(new_array);
	}else{
		alert("Please select at least one organization!");
		return false;
	}

}
$(document).ready(function() {
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
<style>
.table small {display: block;margin-left: 5px; font-size: 95%;margin-top: 2px; font-weight:600;}
.mstus {border: 1px dashed;padding: 1px 10px;margin-bottom: 0;font-size: 14px;}
.accepted {color: green;}
.rejected {color: #a94442;}
.table .btn-group-sm>.btn, .btn-sm {font-size:13px;}
</style>

<section class="content">
	<div class="row">
		<div class="col-md-12"> 
			<div class="box">   
				<div class="box-header with-border">
					<h3 class="box-title">Listing</h3>
					<div class="box-tools pull-right">
						<button type="button" onclick="return sendNotification();" class="btn btn-primary" style="padding:4px 30px;">Send Notification</button>
					</div>
				</div> 
					<div class="box-body row">
						 
						<div class="col-xs-12 table-responsive">
							<table class="table table-striped " id="table_recordtbl">
								<thead>
									<tr>
										<th width="2%"><input type="checkbox" id="selectall" /></th>
										<th>Organization Name</th>
										<th>Acc. Type</th>
										<th>Subscription Type</th>
										<th>Reg. On</th>
										<th>Expire On</th>
										<th>Status</th>
										<th>Members</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1;
									foreach ($orgainzations_data as $row) { ?>
										<tr>
											<td><input type="checkbox" class="case" id="userIds[]" name="userIds[]" value="<?php echo $row->organizationId; ?>" /></td>
											<td style="font-weight:600;"><?php echo $row->organizationName; ?><small><?php echo $row->contactPerson;?></small></td>
											<td><?php echo $this->config->item('organization_types_array_config')[$row->organizationType]['name']; ?></td>
											<td><?php echo $this->config->item('subscription_types_array_config')[$row->subscriptionType]['name'];
											if($row->regCost>0){
											echo '<small>Paid: $'.number_format($row->regCost,2).'</small>'; }?></td>
											<td><?php if(isset($row->createDate) && $row->createDate!='' && $row->createDate>0){echo date('m/d/Y',$row->createDate);}else{echo '&ndash;';}?></td>
											<td><?php if(isset($row->expire_date) && $row->expire_date!='' && $row->expire_date>0){echo date('m/d/Y',$row->expire_date);}else{echo '&ndash;';}?></td>
											<td>
												<input <?php if(isset($row->isActive) && $row->isActive==1){?> checked="checked" <?php } ?> id="toggle-event-isActive<?php echo $row->organizationId;?>" onchange="return update_toggle_swtich_values('<?php echo $row->organizationId;?>','isActive');" data-toggle="toggle" data-size="mini" data-onstyle="success" data-offstyle="danger" data-on="Active" data-off="Inactive" type="checkbox">
												<span id="spinner_isActive_<?php echo $row->organizationId;?>"></span>
											</td>
											<td style="font-weight:600;"><?php echo $row->membersCnt;?></td>
											<td nowrap="nowrap">
												<a class="btn btn-primary btn-sm" href="<?php echo $this->config->item('ajax_base_url').$this->config->item('admin_directory_name').'users/details/'.$row->encryptId;?>">Details</a>
												<a style="margin-left:3px;" onclick="return delete_entry('<?php echo $row->organizationId; ?>');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
											</td>
										</tr>
									<?php $i++;
									} ?>
								</tbody>
							</table>
						</div>
					</div>
<div class="modal fade" tabindex="-1" role="dialog" id="notification_send">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="display:inline-block">Notification Send</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		<form id="sendNotificationFrm" method="post" action="users/send_notification">
			<input type="hidden" id="hBaseUrl" name="hBaseUrl" value="<?php echo base_url().$this->config->item('admin_directory_name');?>" />
			<input type="hidden" id="hAjaxUrl" name="hAjaxUrl" value="<?php echo $this->config->item('ajax_base_url').$this->config->item('admin_directory_name');?>" />
			<input type="hidden" id="hSelectedIds" name="hSelectedIds" value="" />
			<div class="modal-body" id="message_inner">
				 
					<div id="resMsg"></div>
					<div class="form-group">
						<label>Subject *</label>
						<input type="text" class="form-control required" id="subjectNoti" name="subjectNoti" value="" autocomplete="off" />
					</div>
					<div class="form-group" style="margin-bottom:0;">
						<label>Message *</label>
						<textarea name="MessageNoti" id="editor"></textarea>
					</div>
 			</div> 
			<div class="modal-footer">
				<button class="btn btn-primary" type="submit" id="submitBtn" style="padding:5px 30px;">Send Now!</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding:5px 30px;">Close</button>
			</div> 
		</form>
<script>
$(document).ready(function() {
	$('#sendNotificationFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var site_base_url = $('#hBaseUrl').val();
			var ajaxUrl = $('#hAjaxUrl').val();
			var form = $('#sendNotificationFrm');
			var url = ajaxUrl+form.attr('action');
			alert(url);
			for(var instanceName in CKEDITOR.instances){
				CKEDITOR.instances[instanceName].updateElement();
			}
			jQuery.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					$("#submitBtn").attr("disabled",true);
					$('#submitBtn').html('Sending <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					if(result=='success'){
						window.location=site_base_url+'users';
					}else{						
						$('#resMsg').html('<div class="alert alert-danger">'+result+'</div>');
						$("html, body").animate({ scrollTop: 0 }, "slow");
						$('#submitBtn').html('Send Now!');
						$("#submitBtn").attr("disabled",false);
					}					
				},
				error: function(xhr, status, error_desc){				
					$("html, body").animate({ scrollTop: 0 }, "slow");
					$('#resMsg').html('<div class="alert alert-danger">'+error_desc+'</div>');
					$('#submitBtn').html('Send Now!');
					$("#submitBtn").attr("disabled",false);
				}
			});		
			return false;
		}
	});
});
</script>    
    </div>
  </div>
</div>
			</div>
		</div>
	</div>
</section>