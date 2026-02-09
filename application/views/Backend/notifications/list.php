<script type="text/javascript">
function delete_entry(val){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin/notifications/delete?id='+val;
 		} 
 	}
} 
function viewMessageBody(id){
	if(id!=''){
		$.ajax({
			type: "POST", 
			url: '<?php echo base_url();?>admin/notifications/ajax_message?id='+id,
			beforeSend: function(){
				$('#view_lnk_'+id).html('<i class="fa fa-spinner fa-spin"></i>');
				var title = $('#td_title_'+id).html();
				$('#popup_title').html(title);						
			},
			success: function(result, status, xhr){//alert(result);
				$('#popup_builder_res').html(result);
				$("#open_popup").modal('show');
				$('#view_lnk_'+id).html('View');
			}
		});
	}
}
</script> 
<section class="content">
	<div class="box">
<style>
.table td p{ margin-bottom:2px;}
.alert{font-weight: 600;}
.pro_name{border-bottom: 1px dashed #333; letter-spacing: 0.5px; color:#333; cursor:pointer;  font-weight:600;}
.pro_name:hover{border-bottom: 1px solid #000;color:#000;text-decoration:none;}
</style>
		<div class="box-header with-border">
			<h3 class="box-title">Listing</h3>
			<div class="box-tools pull-right">
				<a style="padding: 4px 15px; vertical-align:top; font-weight:600;" href="<?php echo base_url();?>admin/notifications/add" class="btn btn-primary"><i class="fa fa-plus"></i> &nbsp;Add New </a>
			</div>
		</div>	
		<div class="box-body row">
			<div class="col-xs-12 table-responsive">
				<table class="table table-hover table-striped" id="table_recordtbl">
					<thead>
						<tr>
							<th width="3%" nowrap="nowrap">#</th>
							<th nowrap="nowrap">Title</th> 
							<th nowrap="nowrap">Message</th>
							<th nowrap="nowrap">Created On</th> 
							<th nowrap="nowrap">Send To</th>
							<th nowrap="nowrap">Action</th>
						</tr>
					</thead>
					<tbody>
					<?php $i=1; foreach ($notifications_details as $notifications_data) { ?>
						<tr>
							<td><?php echo  $i;?></td>
							<td style="font-weight:600;" id="td_title_<?php echo $notifications_data->notificationId;?>"><?php echo $notifications_data->title;?></td> 
							<td><a class="pro_name" id="view_lnk_<?php echo $notifications_data->notificationId;?>" onclick="return viewMessageBody('<?php echo $notifications_data->notificationId;?>')">View</a></td>
							<td><?php echo date('d M Y, h:i A',$notifications_data->createTime);?></td> 
							<td>
								<?php if(isset($notifications_data->sendTo) && $notifications_data->sendTo!=''){ 
									$uniIds = explode(',',$notifications_data->sendTo);
									foreach($uniIds as $unId){?>
										<p><?php  $Funi = filter_array($university_data,$unId,'id'); echo $Funi[0]['university_name'];?></p>
									<?php } } ?>
								
							</td>
							<td>
								<a href="<?php echo  base_url();?>admin/notifications/edit/<?php echo $notifications_data->notificationId;?>" class="btn btn-success btn-sm"> Edit</a> 
								<a class="btn btn-danger btn-sm" onclick="return delete_entry('<?php echo $notifications_data->notificationId;?>');"> Delete</a>
							</td>
						</tr>
					<?php  $i++; } ?>          
					</tbody>
				</table>
			</div>
		</div>   
	</div>
</section>

<div class="modal fade" id="open_popup" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background: #367fa9;color: #fff;">
				<h4 id="popup_title" style="display: inline;"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div id="popup_builder_res"></div>
			</div>
		</div>
	</div>
</div>