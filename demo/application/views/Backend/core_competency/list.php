<script type="text/javascript">
function delete_entry(val){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin/core_competency/delete?id='+val;
 		} 
 	}
} 
</script> 

<section class="content">
<div class="box">
	<div class="box-header with-border">
      <h3 class="box-title">Listing</h3>
		<div class="box-tools pull-right">
		  <a style="padding: 3px 5px; vertical-align:top; " href="<?php echo base_url();?>admin/core_competency/add" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New </a>
		</div>
    </div>
            
  <!-- start body div -->
	<div class="box-body">
	<div class="col-xs-12 table-responsive">
		<table class="table table-hover " id="table_recordtbl">
			<thead>
				<tr>
					<th width="5%" nowrap="nowrap">S.No</th>
		            <th nowrap="nowrap">Name</th> 
		            <th nowrap="nowrap">Action</th>
				</tr>
			</thead>
			
			<tbody>
				
				<?php $i=1; foreach ($core_competency_details as $row) { ?>
				<tr>
					<td><?php echo  $i;?></td>
				
					<td style="font-weight:600;"><?php echo $row->name;?></td> 
					
					<!--<td><?php if(isset($row->last_login) && $row->last_login!=''){echo date('d M Y', $row->last_login);}else{echo 'Not Yet';} ?></td> -->
					<td nowrap="nowrap">
						<a href="<?php echo  base_url();?>admin/core_competency/edit/<?php echo $row->id;?>" class="btn btn-success btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a>  
   
   						<a class="btn btn-danger btn-sm" onclick="return delete_entry('<?php echo $row->id;?>');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
    