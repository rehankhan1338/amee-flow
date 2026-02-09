<script type="text/javascript">
function delete_entry(val){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin/category/delete?id='+val;
 		} 
 	}
} 
</script> 
<section class="content">
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">Listing</h3>
		<div class="box-tools pull-right">
			<a style="padding: 3px 5px; vertical-align:top; " href="<?php echo base_url();?>admin/widgets/add" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New </a>
		</div>
	</div>
                    
    <!-- start body div -->
	<div class="box-body">
	
		<div class="col-xs-12 table-responsive">
		<table class="table table-hover " id="table_recordtbl">
			<thead>
				<tr>
					<th width="5%" nowrap="nowrap">S.No</th>
		            <th nowrap="nowrap">Widget Title</th> 
					<th nowrap="nowrap">Widget Type</th>
					<th nowrap="nowrap">Status</th>
		            <th nowrap="nowrap">Action</th>
				</tr>
			</thead>
			
			<tbody>
			<?php $i=1; foreach ($widgets_list as $widgets_data) { ?>
				<tr>
					<td><?php echo  $i;?></td>
					<td style="font-weight:600;"><?php echo $widgets_data->widget_title;?></td> 
					<td><?php if($widgets_data->is_widgets_meta==0){ echo 'Normal';}else{ echo 'Custom';}?> </td>
					<td>
						<?php if($widgets_data->status==1){?>
							<span style="color:#D73925; font-size:10px;"><i class="fa fa-circle"></i></span>
						<?php }else{ ?>
							<span style="color:#52AB0B;font-size:10px;"><i class="fa fa-circle"></i></span>
						<?php }?>
					</td>
					<td>
					    <a href="<?php echo  base_url();?>admin/category/edit/<?php echo $widgets_data->id;?>" class="btn btn-success btn-sm"> Edit</a> 
						<a class="btn btn-danger btn-sm" onclick="return delete_entry('<?php echo $widgets_data->id;?>');"> Delete</a>
					   
					  	<?php if(isset($widgets_data->is_widgets_meta) && $widgets_data->is_widgets_meta=='1'){?>
					    	<a href="<?php echo  base_url();?>admin/widgets/addmeta?wid=<?php echo $widgets_data->id;?>" class="btn btn-info btn-sm"> Add Meta </a>
						<?php }?>
					</td>
				</tr>
		    <?php  $i++; } ?>                  
		    </tbody>                          
		</table>
		</div>
	
	</div>
    <!-- /.box-body --> 
</div>
</section>
    