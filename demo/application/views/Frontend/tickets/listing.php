<script>
function supplier_details_modal(post_id,site_base_url){
	if(post_id!=''){
		var supplier_name = $('#td_supplier_name_'+post_id).html();
		$('#popup_supplier_title').html(supplier_name);
		$.ajax({url: site_base_url+"my_products/details_popup?post_id="+post_id, 
			beforeSend: function(){ 
				$('#td_supplier_name_'+post_id).html('<i class="fa fa-spinner fa-spin"></i> please wait -');
			},
			success: function(result){ //alert(result);
				if(result!=''){
					$('#popup_supplier_details_modal_body').html(result);	
					jQuery("#supplier_details_modal").modal('show');
					$('#td_supplier_name_'+post_id).html(supplier_name);
				}
			}
		});
	}
}
function update_status_fuc(product_id,update_status){
  	 $.ajax({url: "<?php echo base_url();?>my_products/update_status?product_id="+product_id+"&update_status="+update_status, 
		beforeSend: function(){ 
			$('#pro_status_'+product_id).html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
		},
		success: function(result){
			$('#pro_status_'+product_id).html(result);
		}
	});
}
</script>


<div class="clearfix"></div>
<style>
.alert-success{ margin:-20px 0 30px;}
.ms_stus { border: 1px dashed; padding: 1px 10px; font-size: 13px; font-weight:600; }
.mstus { border: 1px dashed; padding: 3px 20px; margin-bottom: 10px; font-size: 15px; font-weight:bold; }
.tbl_mstus {border: 1px dashed;padding: 2px 10px;margin-bottom: 0;font-size: 13px;font-weight: 600;}
.accepted { color: green; }
.rejected { color: #a94442; }
</style>
<?php if(count($my_tickets_listing)>0){?>

	<div class="survey_heading" style="text-align: left;margin-top: -20px; margin-bottom:5px;;">
		<h3 style="font-weight:600;">Tickets</h3>
		<div class="btn_div" style="float:right;">
			<a class="btn btn-primary" href="<?php echo base_url();?>tickets/generate"> <i class="fa fa-plus"></i> &nbsp;Create your support ticket</a>
		</div>
	</div>

	<div class="col-md-12 instructions"><strong>Instructions:</strong> Click on Ticket ID to view details.</div>
	<div class="clearfix"></div> 	
	
	 <table class="table table-striped" id="table_recordtbl12">
		<thead>
			<tr class="trbg">
				<th class="survey_listing_td" style="vertical-align:middle;" width="3%">#</th>
				<th class="survey_listing_td" style="vertical-align:middle;">Ticket ID</th>
				<th class="survey_listing_td" style="vertical-align:middle;">Created On</th>
				<th class="survey_listing_td" style="vertical-align:middle;">Conversation</th>
				<th class="survey_listing_td" style="vertical-align:middle;">Last Update</th>
				<th class="survey_listing_td" style="vertical-align:middle;">Status</th>
				<th class="survey_listing_td" style="vertical-align:middle;">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php  $i=1;foreach($my_tickets_listing as $row){ ?>
				<tr>
					<td><?php echo $i;?></td>
					<td nowrap="nowrap">
					<?php if(isset($row->unread_user_status) && $row->unread_user_status==1){?><span style="color:#52AB0B;font-size:8px;"><i class="fa fa-circle"></i></span>&nbsp;&nbsp;<?php } ?><a class="ftdt" href="<?php echo base_url();?>tickets/conversations/<?php echo $row->unique_ticket_id; if(isset($row->unread_user_status) && $row->unread_user_status==1){echo '?u=1';}?>"><?php echo $row->unique_ticket_id;?></a></td>
					<td><?php echo date('d M Y, h:i A',$row->generated_time);?></td>					 
					<td><?php echo $row->conversation_cnt;?></td>
					<td><?php echo date('d M Y, h:i A',$row->last_modification_date);?></td>
					<td><?php if($row->ticket_status==0){?><label class="tbl_mstus accepted">Open</label><?php }else{?><label class="tbl_mstus rejected">Closed</label><?php } ?></td>
					<td class="action_icons">
 						<a class="text-danger" style="font-size:20px;" onclick="return confirm('Are you sure you want to delete this image?');" href="<?php echo base_url();?>tickets/delete/<?php echo $row->id.'/'.$row->unique_ticket_id;?>" ><i class="fa fa-trash-o"></i></a></td>
				</tr>
			<?php $i++;} ?>
		</tbody>
	</table>
<?php }else{ ?>
	<div align="center">
		<p>&nbsp;</p>
		<h3><i>AMEE enables you to create and manage support tickets.</i></h3>
		<p style="font-size:18px;">please click the button "Create Ticket" to start.</p>
		<a class="btn btn-default" href="<?php echo base_url();?>tickets/generate" style="padding:4px 30px; font-size:16px;"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Create Ticket</a>
	</div>
<?php } ?>  
<div class="clearfix"></div>   