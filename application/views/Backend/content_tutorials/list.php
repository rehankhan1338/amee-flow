<script type="text/javascript">
function delete_entry(val,heading_id,action_status){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin/content_tutorials/delete?id='+val+'&hid='+heading_id+'&as='+action_status;
 		} 
 	}
}
</script> 

<section class="content">
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title" style="display: inline-block;">
			<?php if(isset($_GET['hid'])&& $_GET['hid']!=''){			
				$heading_name = get_content_tutorials_heading_name_by_heading_id($_GET['hid']);
				echo 'Sub Menu List for '.$heading_name;			
			}?>			
		</h3>    
		<div class="box-tools pull-right">
			<a style="padding: 4px 15px; vertical-align:top; " href="<?php echo base_url();?>admin/content/tutorials/heading?as=<?php if(isset($_GET['as'])&& $_GET['as']!=''){echo $_GET['as'];}?>" class="btn btn-default"><i class="fa fa-mail-reply" aria-hidden="true"></i> Back to Menu </a>
		</div>
	</div>

	<div class="box-body row">
	<div class="col-xs-12 table-responsive">
		<table class="table table-hover table-striped" id="table_recordtbl">
			<thead>
				<tr>
					<th width="3%" nowrap="nowrap">#</th>
		            <th nowrap="nowrap">Sub heading</th> 
					<th nowrap="nowrap">Description</th>
		            <th nowrap="nowrap">Action</th>
				</tr>
			</thead>
			 
			<tbody>
				<?php $i=1; foreach ($content_tutorials_sub_heading_details as $row) { ?>
				<tr>
					<td><?php echo  $i;?></td>
						
					<td style="font-weight:600;">
						<?php if(isset($row->heading_id) && $row->heading_id!=''){$heading_id = $row->heading_id;}?>						
						
						<?php if(isset($row->sub_heading) && $row->sub_heading!=''){echo $row->sub_heading;}?>												
					</td>	
									 
					<td><?php if(isset($row->description) && $row->description!=''){echo $row->description;}?></td>
					
					<!--<td><?php echo date('d M Y',$row->add_date);?></td> --> 

					<td nowrap="nowrap">
						<a href="<?php echo base_url();?>admin/content_tutorials/edit?shid=<?php echo $row->id;?>&hid=<?php echo $heading_id;?>&as=<?php if(isset($_GET['as'])&& $_GET['as']!=''){echo $_GET['as'];}?>" style="font-size:16px;color:#3c763d;"><i class="fa fa-pencil"></i></a>
						<a onclick="return delete_entry('<?php echo $row->id;?>','<?php echo $heading_id;?>','<?php if(isset($_GET['as'])&& $_GET['as']!=''){echo $_GET['as'];}?>');" style="font-size:16px;color:#a94442; margin-left:20px;"><i class="fa fa-trash"></i></a> 
					</td>
				</tr>
				<?php  $i++; } ?> 
			</tbody>		                             
		</table>
	</div>
	</div>
  
</div>
</section>
    