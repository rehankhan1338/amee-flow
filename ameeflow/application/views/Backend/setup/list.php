<script type="text/javascript">
function delete_entry(val){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url().$this->config->item('admin_directory_name');?>/setup/delete/<?php echo $section_status_slug.'/';?>'+val;
 		} 
 	}
} 
</script>
<?php $wards_prefix = $this->config->item('wards_prefix');?>
<?php $zones_prefix = $this->config->item('zones_prefix');?> 
<section class="content">
   <div class="box">	
	<div class="box-header with-border">
		  <h3 class="box-title">Listing</h3>
		  <div class="box-tools pull-right">
				 
				  <a style="padding: 4px 20px; vertical-align:top; " href="<?php echo base_url().$this->config->item('admin_directory_name');?>/setup/add/<?php echo $section_status_slug;?>" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New <?php echo $section_status_label;?></a>
				</div>
		</div>
			   
	  <div class="box-body">

<div class="table-responsive">
	<table class="table table-striped" id="table_recordtbl12">
		<thead>
			<tr>
				<th width="3%" nowrap="nowrap">#</th>
				<th nowrap="nowrap"><?php if($section_status==1){echo 'Zone #';}else if($section_status==2){echo 'Ward #';}else{echo 'Name';}?></th> 
				<?php if($section_status==2){?><th nowrap="nowrap">Zone #</th><?php } ?> 
				<th nowrap="nowrap">Action</th>
			</tr>
		</thead>
		<tbody>
		<?php if(count($setup_masters_details)>0){$i=1; foreach ($setup_masters_details as $row) { ?>
		<tr>
			<td><?php echo $i;?></td>
			<td style="font-weight:600;"><?php if($section_status==1){echo $zones_prefix;}else if($section_status==2){echo $wards_prefix;}echo $row->name;?></td>
			<?php if($section_status==2){?><td><?php  
			
			$resarr = filter_array($fetchZonesArr,$row->parentId,'id');
			if(count($resarr)>0){ echo $zones_prefix.$resarr[0]['name'];}
			
			 ?></td><?php } ?> 
			<td>
				<a href="<?php echo base_url().$this->config->item('admin_directory_name');?>/setup/edit/<?php echo $section_status_slug.'/'.$row->id;?>" class="btn btn-success btn-sm"> Edit</a> 
				<a class="btn btn-danger btn-sm" onclick="return delete_entry('<?php echo $row->id;?>');"> <i class="fa fa-trash"></i></a>
			</td>
		</tr>
		<?php  $i++; }}else{ ?>	
		<tr>
			<td colspan="3"><i>-- no <?php echo $section_status_slug;?> available yet --</td>
		</tr>
		<?php } ?>
		</tbody>								  
	</table> 
</div>      
</div>    
</div>
</section>  