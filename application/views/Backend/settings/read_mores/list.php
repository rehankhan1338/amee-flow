<style>
th{ vertical-align:top !important;}
.table small {display: block;margin-left: 5px; font-size: 90%;margin-top: 2px;}
.mstus {border: 1px dashed;padding: 1px 10px;margin-bottom: 0;font-size: 14px;}
.accepted {color: green;}
.rejected {color: #a94442;}
</style>
<script type="text/javascript">
function delete_entry(val){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin/accounts/delete?id='+val;
 		} 
 	}
}
</script> 
<section class="content">
<div class="box">
	<div class="box-body row">
	<div class="col-xs-12 table-responsive">
		<table class="table table-striped " id="table_recordtbl">
			<thead>
				<tr>
					<th width="3%">#</th>
		            <th>Title</th> 
					<th>Description</th>
					<th>Status</th>
		            <th>Action</th>
				</tr>
			</thead>			 
			<tbody>
				<?php $i=1; foreach ($track_readiness_read_mores_data as $row){ ?>
				<tr>
					<td><?php echo  $i;?></td>				
					<td style="font-weight:600;"><?php echo $row->title;?></td>				
					<td><?php echo $row->description;?></td>					  
					<td nowrap="nowrap"><?php if($row->status==0){?><label class="mstus accepted">Active</label><?php }else{?><label class="mstus rejected">In-active</label><?php } ?></td>
					<td nowrap="nowrap">
						<a href="<?php echo  base_url();?>admin/setting/track-readiness/read-mores-edit/<?php echo $row->id;?>" class="btn btn-success btn-sm"> Edit</a>
					</td>
				</tr>
				<?php  $i++; } ?>
			</tbody>		                              
		</table>
</div>
</div>  
</div>
</section>