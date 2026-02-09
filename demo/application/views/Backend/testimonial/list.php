<style>
	.tlabel{width: 15%;margin: 6px -10px 15px;}
	.form-control{width: 40%;}
</style>
<script type="text/javascript">
function delete_entry(val){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin/testimonial/delete?id='+val;
 		} 
 	}
} 
</script> 
<section class="content">
<!-- Default box -->
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">Listing</h3>
 
		<div class="box-tools pull-right">
			<a style="padding: 3px 5px; vertical-align:top;" href="<?php echo base_url();?>admin/testimonial/add" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New </a>
		</div>
	</div>
	
	
<div class="box-body">
<div class="col-xs-12 table-responsive">
              
<!-- start body div -->

	<table class="table table-hover " id="table_recordtbl">
		<thead>
			<tr>
				<th width="5%" nowrap="nowrap">S.No</th>
				<th nowrap="nowrap">Name</th> 
				<th nowrap="nowrap">Designation</th> 
				<th nowrap="nowrap">Message</th> 
				<th nowrap="nowrap">Status</th> 
				<th nowrap="nowrap">Action</th>
			</tr>
		</thead>
		
		<tbody>
			<?php $i=1; foreach ($testimonial_details as $row) { ?>
		
		<tr>
			<td><?php echo  $i;?></td>
			
			<td style="font-weight:600;" >
				<?php if(!empty($row->name)){echo $row->name;} else{echo ""; }?>
			</td> 
			
		 
				<?php /*if(!empty($row->unit_type)){$unitid=$row->unit_type;}
					$unit_detail = get_unit_name_by_id($unitid);
					if(!empty($unit_detail->unit_name)){echo $unit_detail->unit_name;}else{echo "";}*/
				?>	
			 
			
			<td >
				<?php if(!empty($row->designation)){echo $row->designation;} else{echo ""; }?>
			</td> 
			
			<td >
				<?php if(!empty($row->content)){echo $row->content;} else{echo ""; }?>
			</td> 				
							
			<td > 
				<?php if(isset($row->is_status)&& $row->is_status=='1'){?>
					<span style="color:#D73925; font-size:10px;"><i class="fa fa-circle"></i></span>
				<?php }else{ ?>
					<span style="color:#52AB0B;font-size:10px;"><i class="fa fa-circle"></i></span>
				<?php }?>
			</td> 
			
			<td nowrap="nowrap">
				<a href="<?php echo  base_url();?>admin/testimonial/edit/<?php echo $row->id;?>" class="btn btn-success btn-sm"> Edit</a> 
				<a class="btn btn-danger btn-sm" onclick="return delete_entry('<?php echo $row->id;?>');"> Delete</a>
			</td>
		</tr>
		<?php  $i++; } ?>          

		</tbody>
	              
	</table>

 

</div> 
</div>
</div>
</section>
    