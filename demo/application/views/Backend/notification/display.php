<section class="content"> 
<div class="box snapshot_page">
	
   <!-- start body div -->
	<div class="box-body" style="padding:0;">
   		
	<div class="row" >
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-hover table-bordered table-striped" id="table_recordtbl12">
					<thead>
						<tr class="trbg">
							<th width="3%"  style="vertical-align:top;text-align:center;">#</th>
							<th style="vertical-align:top;" nowrap="nowrap">Message </th> 
							<th style="vertical-align:top;" nowrap="nowrap">Type </th>  
							<th style="vertical-align:top;" nowrap="nowrap">Sent Date </th> 
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
						<?php  $i++; }}else{ ?>          
							<tr><td colspan="4"> -- no record available --</td></tr>
						<?php } ?>
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