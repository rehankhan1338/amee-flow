<script type="text/javascript">
function delete_entry(val,action_status){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin/content_tutorials/heading_delete?id='+val+'&as='+action_status;
 		} 
 	}
} 
</script> 

<section class="content">
<div class="box">
	<div class="box-header with-border">
	    <h3 class="box-title" style="display: inline-block;">Menu List</h3>           
		<div class="box-tools pull-right">
		  <a style="padding: 4px 15px; font-size:15px; vertical-align:top;" href="<?php echo base_url();?>admin/content/tutorials/heading/add?as=<?php if(isset($_GET['as'])&& $_GET['as']!=''){echo $_GET['as'];}?>" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp;Add Menu </a>
		</div>
    </div>
            
  <!-- start body div -->
	<div class="box-body row">
	<div class="col-xs-12 table-responsive">
		<table class="table table-striped" style="font-size:15px;">		 
			 
			 
				<?php $i=1; foreach ($content_tutorials_heading_details as $heading_details) { ?>
				<tr> 				
					<td style="padding:10px; font-weight:600;">
						<!--<a href="<?php echo base_url();?>admin/content_tutorials?hid=<?php if(isset($heading_details->id) && $heading_details->id!=''){echo $heading_details->id;}?>">-->
							<?php if(isset($heading_details->heading) && $heading_details->heading!=''){
								echo $i.'. '.ucfirst($heading_details->heading);}?>							
						<!--</a>-->
					
					 	<div class="pull-right">
					 		 <a style=" padding:3px 10px;" href="<?php echo base_url();?>admin/content_tutorials?hid=<?php if(isset($heading_details->id) && $heading_details->id!=''){echo $heading_details->id;}?>&as=<?php if(isset($_GET['as'])&& $_GET['as']!=''){echo $_GET['as'];}?>" class="btn btn-default">View Sub-Menu </a> 
					 		 <a style="margin-left: 5px; margin-right: 15px; padding:3px 10px;"  href="<?php echo base_url();?>admin/content_tutorials/add?hid=<?php if(isset($heading_details->id)&& $heading_details->id!=''){echo $heading_details->id;}?>&as=<?php if(isset($_GET['as'])&& $_GET['as']!=''){echo $_GET['as'];}?>" class="btn btn-default"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Sub-Menu </a>
					 			
							<a href="<?php echo base_url();?>admin/content/tutorials/heading/edit?hid=<?php echo $heading_details->id;?>&as=<?php if(isset($_GET['as'])&& $_GET['as']!=''){echo $_GET['as'];}?>" style="font-size:16px;color:#3c763d;"><i class="fa fa-pencil"></i></a>
							<a onclick="return delete_entry('<?php echo $heading_details->id;?>','<?php if(isset($_GET['as'])&& $_GET['as']!=''){echo $_GET['as'];}?>');" style="font-size:16px;color:#a94442; margin-left:20px;"><i class="fa fa-trash"></i></a>
						</div>
					</td>
				</tr>
				<?php  $i++; } ?> 
			                              
		</table>
	</div>
	</div>


</div>
</section>