<div class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box no-border">
				<div class="box-header no-border">
					<h3 class="box-title">Click the ticket ID number to read messages</h3>
					<div class="box-tools pull-right"> 
						<a style="padding: 4px 15px;vertical-align:top; margin-left:5px;" href="<?php echo $ticketSecBaseUrl.'tickets/generate';?>" class="btn btn-primary" > Create your support ticket </a>					
					</div>
				</div>
				<div class="box-body row ticket_page">
					 	
	<?php if(count($my_tickets_listing)>0){?>
		<div class="col-xs-12 table-responsive">
		<table class="table table-striped table-bordered" id="table_recordtbl23">
			<thead>
				<tr>
					<th width="1%">#</th>
					<th>Ticket ID</th>
					<th>Date &amp; Time</th>
					<th>Conversation</th>
					<th>Last Update</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php  $i=1;foreach($my_tickets_listing as $row){ ?>
					<tr>
						<td><?php echo $i;?></td>
						<td style="font-weight:600;">
						<?php if(isset($row->unread_user_status) && $row->unread_user_status==1){?><span style="color:#52AB0B;font-size:8px;"><i class="fa fa-circle"></i></span>&nbsp;&nbsp;<?php } ?><a class="pro_name" href="<?php echo $ticketSecBaseUrl;?>tickets/conversations/<?php echo $row->unique_ticket_id; if(isset($row->unread_user_status) && $row->unread_user_status==1){echo '?u=1';}?>"><?php echo $row->unique_ticket_id;?></a></td>
						<td><?php echo date('d M Y, h:i A',$row->generated_time);?></td>					 
						<td><?php echo $row->conversation_cnt;?></td>
						<td><?php echo date('d M Y, h:i A',$row->last_modification_date);?></td>
						<td><?php if($row->ticket_status==0){?><label class="mstus accepted">Open</label><?php }else{?><label class="mstus rejected">Closed</label><?php } ?></td>
						<td class="action_icons">
							<a class="text-danger" style="font-size:16px;" onclick="return confirm('Are you sure you want to delete this ticket?');" href="<?php echo base_url();?>home/ticket_delete?utId=<?php echo $row->unique_ticket_id;?>&r=<?php echo $ticketSecBaseUrl;?>"> <i class="fa fa-trash"></i> </a>
						</td>
					</tr>
				<?php $i++;} ?>
			</tbody>
		</table>
		</div>
	<?php } ?>
	</div>	 
			</div>
		</div>
	</div>
</div>
<?php // include(APPPATH.'views/Frontend/my_products/call_details_modal.php');?> 