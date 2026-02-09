<script type="text/javascript">
function delete_entry(val){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin/clients/delete?id='+val;
 		} 
 	}
} 
</script> 

<section class="content">
<div class="box">
	<div class="box-header with-border">
      <h3 class="box-title">Listing</h3>
		<div class="box-tools pull-right">
		  <a style="padding: 3px 5px; vertical-align:top; " href="<?php echo base_url();?>admin/clients/add" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New </a>
		</div>
    </div>
            
  <!-- start body div -->
	<div class="box-body">
	<div class="col-xs-12 table-responsive">
		<table class="table table-hover " id="table_recordtbl">
			<thead>
				<tr>
					<th width="5%" nowrap="nowrap">S.No</th>
		            <th nowrap="nowrap"> Name </th>
		            <th nowrap="nowrap">Email</th>
		            <th nowrap="nowrap">Phone</th>
		            <th nowrap="nowrap">State</th>
		            <th nowrap="nowrap">City</th>
		            <th nowrap="nowrap">Name Of Organization</th> 
		            <th nowrap="nowrap">Type Of Organization</th>
		            <th nowrap="nowrap">Action</th>
				</tr>
			</thead>
			
			<tbody>
				<?php $i=1; foreach ($client_profile_details as $row) { ?>
				<tr>
					<td><?php echo  $i;?></td>

					<td><?php echo $row->first_name.' '.$row->last_name;?></td> 
					
					<td><?php echo $row->email;?></td>
					 
					<td><?php echo $row->phone;?></td> 
					
					<td><?php echo $row->state;?></td> 
					
					<td><?php echo $row->city;?></td> 
					
					<td><?php echo $row->organization_name;?></td>
					
					<td>
						<?php if(!empty($row->organization_type)){ $orgid = $row->organization_type;}
							$organization = get_master_organization_type_by_id($orgid); ?>
							<?php echo $organization->type;?>
					</td>

					<td>
						<a href="<?php echo  base_url();?>admin/clients/edit/<?php echo $row->id;?>" class="btn btn-success btn-sm"> Edit</a> 
						<a class="btn btn-danger btn-sm" onclick="return delete_entry('<?php echo $row->id;?>');"> Delete</a>
					</td>
				</tr>
				<?php  $i++; } ?>          

			</tbody>
		                              
		</table>

	</div>

</div>
<!-- /.box-body -->
<!-- Modal -->    
</div>
        <!-- /.box-body -->

        
      <!-- /.box -->
    </section>
    