<script type="text/javascript">
function delete_entry(val) {
	if (val != "") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
			window.location = "<?php echo $this->config->item('ajax_base_url').$this->config->item('admin_directory_name').'spotlight/delete_submission?spotlightId='; ?>"+val;
		}
	}
}
function update_toggle_swtich_values(spotlightId,column_name){
	if(spotlightId>0){
		var checkstatus=$('#toggle-event-'+column_name+spotlightId).prop('checked');
		if(checkstatus == true){
			var status=0;		
		}else{
			var status=1;		 
		}	
		$.ajax({url: "<?php echo base_url(). $this->config->item('admin_directory_name');?>spotlight/update_status?spotlightId="+spotlightId+"&column_name="+column_name+"&status="+status, 
			beforeSend: function(){ 
				$('#spinner_'+column_name+'_'+spotlightId).html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result){
				if(result=='success'){
					$('#spinner_'+column_name+'_'+spotlightId).html('');
				}
			}
		});
	} 
}
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
				  
					<div class="box-body row">
						 
						<div class="col-xs-12 table-responsive">
							<table class="table table-striped " id="table_recordtbl">
								<thead>
									<tr>
										<th width="2%">#</th>
										<th>Submitted By</th>
										<th>Company</th>
										<th>Submission On</th>
										<th>Display on Web</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1;
									foreach ($spotlight_submissions_data as $row) { ?>
										<tr>
											<td><?php echo $i; ?></td>
											<td style="font-weight:600;"><?php echo $row['firstName'].' '.$row['lastName'];?> <small><?php echo $row['email']; ?></small></td>
											<td><?php echo $row['organizationName']; ?></td>
											<td><?php if(isset($row['createdTime']) && $row['createdTime']!='' && $row['createdTime']>0){echo date('m/d/Y, h:i A',$row['createdTime']);}else{echo '&ndash;';}?></td>
											<td>
												<input <?php if(isset($row['displayWebSts']) && $row['displayWebSts']==0){?> checked="checked" <?php } ?> id="toggle-event-displayWebSts<?php echo $row['spotlightId'];?>" onchange="return update_toggle_swtich_values('<?php echo $row['spotlightId'];?>','displayWebSts');" data-toggle="toggle" data-size="mini" data-onstyle="success" data-offstyle="danger" data-on="Yes" data-off="No" type="checkbox">
												<span id="spinner_displayWebSts_<?php echo $row['spotlightId'];?>"></span>
											</td>
											<td>
												<input <?php if(isset($row['isStatus']) && $row['isStatus']==0){?> checked="checked" <?php } ?> id="toggle-event-isStatus<?php echo $row['spotlightId'];?>" onchange="return update_toggle_swtich_values('<?php echo $row['spotlightId'];?>','isStatus');" data-toggle="toggle" data-size="mini" data-onstyle="success" data-offstyle="danger" data-on="Accept" data-off="Reject" type="checkbox">
												<span id="spinner_isStatus_<?php echo $row['spotlightId'];?>"></span>
											</td>
											<td nowrap="nowrap">
												<a href="<?php echo base_url().$this->config->item('admin_directory_name').'spotlight/edit?spotlightId='.$row['spotlightId']; ?>" class="btn btn-primary btn-sm">Edit</a>												
												<a style="margin-left:3px;" onclick="return delete_entry('<?php echo $row['spotlightId']; ?>');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
											</td>
										</tr>
									<?php $i++;
									} ?>
								</tbody>
							</table>
						</div>
					</div>
 
			</div>
		</div>
	</div>
</section>